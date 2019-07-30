<?php

namespace App\Http\Controllers\Api;

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

            
            return LibraryCollection::collection(Library::where('title', 'like', "%{$search}%")->orderBy('created_at', 'desc')->paginate(10));

        } else {

            return LibraryCollection::collection(Library::orderBy('created_at', 'desc')->paginate(10));

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

        return response(['Library created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $library = Library::whereSlug($slug)->first();
        // $publication = Publication::findOrFail($id);
       return new LibraryResource($library);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit(Library $library)
    {
        return new LibraryResource($library);
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

        return response([
            "message" => "Library updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {
        if (isset($library->file)) {
            File::delete(public_path('uploads/libraries/'.$library->file->filename));
            $library->file->delete();
        }
        $library->delete();

        return response([
            "message" => "Library deleted"
        ]);
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
