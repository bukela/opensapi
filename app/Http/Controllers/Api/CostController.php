<?php

namespace App\Http\Controllers\Api;

use App\Cost;
use App\Project;
use App\Narrative;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Requests\CostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CostResource;
use Illuminate\Support\Facades\File;
use App\Http\Resources\NewCostResource;
use App\Exceptions\EventNotBelongsToUser;
use Symfony\Component\HttpFoundation\Response;

class CostController extends Controller
{

    // public function __construct() {

    //     $this->middleware('organization-only')->except('index', 'show');
    // }

    // public function __construct() {

    //     $this->middleware('moderator-only')->except('index', 'show');
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct() {

    //     $this->middleware('auth:api')->except('index', 'show');

    // }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CostRequest $request)
    {

        $cost = new Cost;
        $cost->category_id = $request->category_id;
        $cost->project_id = $request->project_id;
        // $cost->type = $request->type;
        $cost->note = $request->note;
        $cost->payment_date = $request->payment_date;
        $cost->invoice_number = $request->invoice_number;
        // $request->approved == 'on' ? $cost->approved = 1 : $cost->approved = 0;
        $cost->status = $request->status;
        $cost->description = $request->description;
        // $cost->spent = $request->spent;
        $cost->spent_donator = $request->spent_donator;
        $cost->spent_private = $request->spent_private;

        $cost->save();

        $project = Project::findOrFail($request->project_id);
        // $project->spent_funds = $project->spent_funds + $cost->spent;
        $project->spent_funds = $project->costs->sum('spent_private') + $project->costs->sum('spent_donator');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->project_spent = $project->spent_funds;
        $narrative->save();

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            
            $original_name = $file->getClientOriginalName();
            // dd($original_name);
            $filename = uniqid('costs_') . '.' . $file->getClientOriginalExtension();
            $path = public_path('/uploads/documents');
            $uploaded = $file->move($path, $filename);


            $image = new FileModel();
            $image->original_name = $original_name;
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($cost);
            $image->save();
        }

        return response([
            'data' => new NewCostResource($cost)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        return new NewCostResource($cost);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CostRequest $request, $id)
    {
        $cost = Cost::findOrFail($id);

        if($cost->approved == 1 && auth('api')->user()->moderator != 1) {

            return response(['message' => 'Edit not allowed']);

        }

        // if($cost->approved !== 1) {

        $cost->category_id = $request->category_id;
        // $cost->spent = $request->spent;
        // $cost->type = $request->type;
        $cost->spent_donator = $request->spent_donator;
        $cost->spent_private = $request->spent_private;
        $cost->note = $request->note;
        $cost->payment_date = $request->payment_date;
        $cost->invoice_number = $request->invoice_number;
        // $request->approved == 'on' ? $cost->approved = 1 : $cost->approved = 0;
        $cost->status = $request->status;
        $cost->description = $request->description;
        $cost->update();

        $project = Project::findOrFail($cost->project_id);
        // $project->spent_funds = $project->spent_funds + $cost->spent;
        $project->spent_funds = $project->costs->sum('spent_private') + $project->costs->sum('spent_donator');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->project_spent = $project->spent_funds;
        $narrative->save();

        if ($request->hasFile('file')) {

            if(isset($cost->image)) {
                File::delete(public_path('/uploads/documents/'.$cost->image->filename));
                $cost->image()->delete();
            }
            
            $file = $request->file('file');
            
            $original_name = $file->getClientOriginalName();
            $filename = uniqid('costs_') . '.' . $file->getClientOriginalExtension();
            $path = public_path('/uploads/documents');
            $uploaded = $file->move($path, $filename);


            $image = new FileModel();
            $image->original_name = $original_name;
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($cost);
            $image->save();
        }

        return response(['data' => 'cost with id '.$cost->id.' updated'], RESPONSE::HTTP_CREATED );

        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cost = Cost::findOrFail($id);
        if (isset($cost->image)) {
            File::delete($cost->image->image_url);
            $cost->image->delete();
        }

        $cost->delete();

        return response(['data' => 'cost with id '.$cost->id.' deleted'] );
    }

    public function download($id) {

        $cost = Cost::findOrFail($id);

        if(isset($cost->image)) {

            return response()->download(public_path('/uploads/documents/'.$cost->image->filename));

        } else {

            return response(['no file provided']);

        }
    }
}
