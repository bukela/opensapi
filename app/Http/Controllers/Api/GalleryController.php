<?php

namespace App\Http\Controllers\Api;

use App\Gallery;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\GalleryCollection;

class GalleryController extends Controller
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
        // return GalleryResource::collection(Gallery::orderBy('created_at', 'desc')->paginate(10));

        $search = $request->get('search');

        if(isset($search)) {

            
            return GalleryResource::collection(Gallery::where('title', 'like', "%{$search}%")->paginate(10));

        } else {

            return GalleryResource::collection(Gallery::orderBy('created_at', 'desc')->paginate(10));

        }

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
    public function store(GalleryRequest $request)
    {
        $gallery = new Gallery;

        $gallery->title = $request->title;
        $gallery->slug = str_slug($request->title);
        $request->active == 'on' ? $gallery->active = 1 : $gallery->active = 0;
        $gallery->description = $request->description;

        $gallery->save();
        $log = new LogController();
        $log->createLog("kreirana galerija : $gallery->title", "galerija");

        if ($request->hasFile('slides')) {

            $slides = $request->file('slides');
            // dd($flyers);

            foreach($slides as $slide) {
            $filename = uniqid('gallery_') . '.' . $slide->getClientOriginalExtension();
            $path = public_path('/uploads/galleries');
            $uploaded = $slide->move($path, $filename);

            $slide = new FileModel();
            $slide->filename = $uploaded->getFilename();
            $slide->image_url = $uploaded->getPathname();
            $slide->file()->associate($gallery);
            $slide->save();
            }
        }

        

        return response(['message' => 'gallery created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // $gallery = Gallery::findOrFail($id);
        $gallery = Gallery::whereSlug($slug)->first();
        return new GalleryResource($gallery);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        return new NewsResource($gallery);
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
        $gallery = Gallery::findOrFail($id);

        $gallery->title = $request->title;
        $gallery->slug = str_slug($request->title);
        $request->active == 'on' ? $gallery->active = 1 : $gallery->active = 0;
        $gallery->description = $request->description;

        // $gallery->save();

        $log = new LogController();
        $log->createLog("izmenjena galerija : $gallery->title", "galerija");

        if ($request->hasFile('slides')) {

            $slides = $request->file('slides');
            // dd($flyers);

            foreach($slides as $slide) {
            $filename = uniqid('gallery_') . '.' . $slide->getClientOriginalExtension();
            $path = public_path('/uploads/galleries');
            $uploaded = $slide->move($path, $filename);

            $slide = new FileModel();
            $slide->filename = $uploaded->getFilename();
            $slide->image_url = $uploaded->getPathname();
            $slide->file()->associate($gallery);
            $slide->save();
            }
        }

        $gallery->save();

        return response(['message' => 'gallery updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if (isset($gallery->slides)) {
            foreach($gallery->slides as $slide) {

                File::delete(public_path('uploads/galleries/').$slide->filename);
                // File::delete($slide->image_url);
                $slide->delete();
            }
        }

        $gallery->delete();

        return response(['message' => 'gallery deleted']);
         
    }

}
