<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Publication;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Http\Resources\PublicationCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PublicationUpdateRequest;

class PublicationController extends Controller
{

    // public function __construct() {

    //     $this->middleware('auth:api')->except('index', 'show');
    //     $this->middleware('organization-only')->except('index', 'show');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if(isset($search)) {

            
            return PublicationCollection::collection(Publication::where('title', 'like', "%{$search}%")->orderBy('created_at', 'desc')->paginate(10));

        } else {

            return PublicationCollection::collection(Publication::orderBy('created_at', 'desc')->paginate(10));

        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublicationRequest $request)
    {
        $publication = new Publication;

        $publication->title = $request->title;
        $publication->description = $request->description;
        $request->active == 'on' ? $publication->active = 1 : $publication->active = 0;
        $publication->slug = str_slug($request->title);

        $publication->save();

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            // dd($flyers);

            // $filename = uniqid('publications_') . '.' . $file->getClientOriginalExtension();
            $filename = uniqid().'_'.$file->getClientOriginalName();
            $filename = str_replace(' ', '_' ,$filename);
            $path = public_path('/uploads/publications');
            $uploaded = $file->move($path, $filename);

            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($publication);
            $image->save();
        }

        // $log = new LogController();
        // $log->createLog("kreirana publikacija : ".$publication->title, 'publikacija');

        return response(['Publication created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $publication = Publication::whereSlug($slug)->first();
        // $publication = Publication::findOrFail($id);
       return new PublicationResource($publication);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        return new PublicationResource($publication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(PublicationUpdateRequest $request, $id)
    {
        $publication = Publication::findOrFail($id);

        $publication->title = $request->title;
        $publication->description = $request->description;
        $request->active == 'on' ? $publication->active = 1 : $publication->active = 0;
        $publication->slug = str_slug($request->title);

        // $publication->save();

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            // dd($flyers);
            if($publication->file) {
            File::delete(public_path('uploads/publications/'.$publication->file));
            $publication->file->delete();
            }

            // $filename = uniqid('publications_') . '.' . $file->getClientOriginalExtension();
            $filename = uniqid().'_'.$file->getClientOriginalName();
            $filename = str_replace(' ', '_' ,$filename);
            $path = public_path('/uploads/publications');
            $uploaded = $file->move($path, $filename);

            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($publication);
            $image->save();
        }

        $publication->save();
        // $log = new LogController();
        // $log->createLog("promenjena publikacija : $publication->title", 'publikacija');

        return response([
            "message" => "Publication updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response([
            "message" => "Publication deleted"
        ]);
    }

    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        File::delete(public_path('uploads/publications/').$file->filename);
        $file->delete();
        return redirect()->back()->with('status', ['type' => 'success', 'message' => __('File deleted successfully')]);

    }

    public function download($id) {

        $publication = Publication::findOrFail($id);

        if(isset($publication->file)) {

            return response()->download(public_path('/uploads/publications/'.$publication->file->filename));

        } else {

            return response(['no file provided']);

        }
    }

}
