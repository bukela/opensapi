<?php

namespace App\Http\Controllers\Admin;

use App\Publication;
use App\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PublicationRequest;
use App\Http\Requests\PublicationUpdateRequest;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', false);
        $order = $request->get('order', 'title');
        $sort = $request->get('sort', 'asc');

        if ($filter) {
            if ($request->get('filter') === 'publications') {
                $publications = Publication::orderBy($order, $sort)->paginate(10);
            }
        } else {
            $publications = Publication::orderBy($order, $sort)->paginate(10);

        }
        // $publications = Publication::all();
        return view('admin.publications.index',compact('publications','filter','order','sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.publications.create');
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

        // $publication->save();

        $log = new LogController();
        // $log->createLog("created event named $event->title", 'event');
        $log->createLog("kreirana publikacija : $publication->title", 'publikacija');
        return redirect(route('admin.publications.index'))->with('status', ['type' => 'success', 'message' => __('Publication created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publication = Publication::findOrFail($id);

        return view('admin.publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        return view('admin.publications.edit', compact('publication'));
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

        $log = new LogController();
        // $log->createLog("created event named $event->title", 'event');
        $log->createLog("promenjena publikacija : $publication->title", 'publikacija');
        return redirect(route('admin.publications.index'))->with('status', ['type' => 'success', 'message' => __('Publication updated successfully')]);
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

        return redirect(route('admin.publications.index'))->with('status', ['type' => 'success', 'message' => __('Publication deleted successfully')]);
    }

    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        File::delete(public_path('uploads/publications/').$file->filename);
        $file->delete();
        return redirect()->back()->with('status', ['type' => 'success', 'message' => __('File deleted successfully')]);

    }

    public function search(Request $request)
    {

        $news = Publications::where('title', 'like', "%{$request->search}%")
            ->paginate(20);


        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
        
        return view('admin.news.index', compact('news','filter','order','sort'));
    }
}
