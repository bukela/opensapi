<?php

namespace App\Http\Controllers\Admin;

use App\Cost;
use App\Project;
use App\Category;
use App\Narrative;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Requests\CostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $categories = Category::all();

        return view('admin.costs.create', compact('categories'));
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
        $cost->note = $request->note;
        // $cost->type = $request->type;
        $cost->spent_donator = $request->spent_donator;
        $cost->spent_private = $request->spent_private;
        $cost->payment_date = $request->payment_date;
        $cost->invoice_number = $request->invoice_number;
        // $request->approved == 'on' ? $cost->approved = 1 : $cost->approved = 0;
        $cost->status = $request->status;
        $cost->description = $request->description;
        $cost->spent = $request->spent;

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
            
            $filename = uniqid('costs_') . '.' . $file->getClientOriginalExtension();
            $path = public_path('/uploads/documents');
            $uploaded = $file->move($path, $filename);


            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($cost);
            $image->save();
        }

        $log = new LogController();
        // $log->createLog("$project->title : Spent $cost->spent on $cost->description", 'cost');
        $log->createLog("kreiran trošak id:$cost->id za projekt : $project->title , iznos : $cost->spent", 'trošak');


        // return redirect(route('admin.projects.index'));
        return redirect(route('admin.project.show',$project->id))->with('status', ['type' => 'success', 'message' => __('Cost created successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $cost = Cost::findOrFail($id);
        $project = $cost->project_id;
        $categories = Category::where('project_id', $project)->get();
        return view('admin.costs.edit', compact('cost', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cost = Cost::findOrFail($id);
        
        $cost->category_id = $request->category_id;
        $cost->spent = $request->spent;
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
            // File::delete(public_path('/uploads/documents/'.$cost->image->filename));
            // $cost->image()->delete();
            // File::delete(public_path('/uploads/documents/'.$cost->image->filename));

            $file = $request->file('file');
            
            $filename = uniqid('costs_') . '.' . $file->getClientOriginalExtension();
            $path = public_path('/uploads/documents');
            $uploaded = $file->move($path, $filename);


            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($cost);
            $image->save();
        }

        $log = new LogController();
        // $log->createLog("edited cost ", 'cost');
        $log->createLog("izmenjen trošak id:$cost->id za projekt : ".$cost->project->title, 'trošak');

        // return redirect(route('admin.projects.index'))->with('status', ['type' => 'success', 'message' => __('Cost updated successfully')]);
        return redirect(route('admin.project.show',$project->id))->with('status', ['type' => 'success', 'message' => __('Cost updated successfully')]);
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

        $project = Project::findOrFail($cost->project_id);
        // $project->spent_funds = $project->spent_funds + $cost->spent;
        $project->spent_funds = $project->costs->sum('spent');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->project_spent = $project->spent_funds;
        $narrative->save();

        $log = new LogController();
        // $log->createLog("cost is removed", 'cost');
        $log->createLog("obrisan trošak id:$cost->id za projekt : ".$cost->project->title, 'trošak');

        return redirect(route('admin.project.show',$project->id))->with('status', ['type' => 'success', 'message' => __('Cost deleted successfully')]);
    }
}
