<?php

namespace App\Http\Controllers\Admin;

use App\Gallery;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\GalleryRequest;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gallery.create');
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

        return redirect(route('admin.galleries.index'))->with('status', ['type' => 'success', 'message' => __('Gallery created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $gallery->title = $request->title;
        $gallery->slug = str_slug($request->title);
        $request->active == 'on' ? $gallery->active = 1 : $gallery->active = 0;
        $gallery->description = $request->description;

        // $gallery->save();

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

        return redirect(route('admin.galleries.index'))->with('status', ['type' => 'success', 'message' => __('Gallery updated successfully')]);
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

        return redirect(route('admin.galleries.index'))->with('status', ['type' => 'success', 'message' => __('Gallery deleted successfully')]);
    }

    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        File::delete(public_path('uploads/galleries/').$file->filename);
        $file->delete();
        return redirect()->back();

    }
}
