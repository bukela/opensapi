<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Library;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\LibraryRequest;
use App\Http\Resources\LibraryResource;
use App\Http\Resources\LibraryCollection;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends Controller
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
            if ($request->get('filter') === 'libraries') {
                $libraries = Library::orderBy($order, $sort)->paginate(10);
            }
        } else {
            $libraries = Library::orderBy($order, $sort)->paginate(10);

        }
        // $publications = Publication::all();
        return view('admin.libraries.index',compact('libraries','filter','order','sort'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.libraries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibraryRequest $request)
    {
        $library = new Library;

        $library->title = $request->title;
        $library->description = $request->description;
        $request->active == 'on' ? $library->active = 1 : $library->active = 0;
        $library->slug = str_slug($request->title);

        $library->save();

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            // dd($flyers);

            // $filename = uniqid('publications_') . '.' . $file->getClientOriginalExtension();
            $filename = uniqid().'_'.$file->getClientOriginalName();
            $filename = str_replace(' ', '_' ,$filename);
            $path = public_path('/uploads/libraries');
            $uploaded = $file->move($path, $filename);

            $book = new FileModel();
            $book->filename = $uploaded->getFilename();
            $book->image_url = $uploaded->getPathname();
            $book->file()->associate($library);
            $book->save();
        }

        // $log = new LogController();
        // $log->createLog("kreirana publikacija : ".$publication->title, 'publikacija');

        $log = new LogController();
        $log->createLog("Kreirana biblioteka : $library->title", 'biblioteka');
        return redirect(route('admin.libraries.index'))->with('status', ['type' => 'success', 'message' => __('Library created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $library = Library::whereSlug($slug)->first();
        $library = Library::findOrFail($id);
        return view('admin.libraries.show', compact('library'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $library = Library::findOrFail($id);

        return view('admin.libraries.edit', compact('library'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $library = Library::findOrFail($id);

        $library->title = $request->title;
        $library->description = $request->description;
        $request->active == 'on' ? $library->active = 1 : $library->active = 0;
        $library->slug = str_slug($request->title);

        // $publication->save();

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            // dd($flyers);
            if($library->file) {
            File::delete(public_path('uploads/libraries/'.$library->file));
            $library->file->delete();
            }

            // $filename = uniqid('publications_') . '.' . $file->getClientOriginalExtension();
            $filename = uniqid().'_'.$file->getClientOriginalName();
            $filename = str_replace(' ', '_' ,$filename);
            $path = public_path('/uploads/libraries');
            $uploaded = $file->move($path, $filename);

            $book = new FileModel();
            $book->filename = $uploaded->getFilename();
            $book->image_url = $uploaded->getPathname();
            $book->file()->associate($library);
            $book->save();
        }

        $library->save();
        // $log = new LogController();
        // $log->createLog("promenjena publikacija : $publication->title", 'publikacija');

        $log = new LogController();
        $log->createLog("Izmenjena biblioteka : $library->title", 'biblioteka');
        return redirect(route('admin.libraries.index'))->with('status', ['type' => 'success', 'message' => __('Library updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $library = Library::findOrFail($id);
        if (isset($library->file)) {
            File::delete(public_path('uploads/libraries/'.$library->file->filename));
            $library->file->delete();
        }
        $library->delete();

        $log = new LogController();
        $log->createLog("Obrisana biblioteka : $library->title", 'biblioteka');
        return redirect(route('admin.libraries.index'))->with('status', ['type' => 'success', 'message' => __('Library deleted successfully')]);
    }

    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        File::delete(public_path('uploads/libraries/').$file->filename);
        $file->delete();
        return redirect()->back()->with('status', ['type' => 'success', 'message' => __('File deleted successfully')]);

    }

    public function download($id) {

        $library = Library::findOrFail($id);

        if(isset($library->file)) {

            return response()->download(public_path('/uploads/libraries/'.$library->file->filename));

        } else {

            return response(['no file provided']);

        }
    }

}
