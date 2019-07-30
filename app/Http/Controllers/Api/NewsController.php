<?php

namespace App\Http\Controllers\Api;

use App\News;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Resources\NewsCollection;
use App\Exceptions\NewsNotBelongsToUser;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
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
        // return NewsCollection::collection(News::orderBy('created_at', 'desc')->paginate(10));
        $search = $request->get('search');

        if(isset($search)) {

            
            return NewsCollection::collection(News::where('title', 'like', "%{$search}%")->paginate(10));

        } else {

            return NewsCollection::collection(News::orderBy('created_at', 'desc')->paginate(10));

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
    public function store(NewsRequest $request)
    {
        // $request->validate([
        //     'title' => 'required|min:3|max:255',
        //     'body'  => 'required',
        //     'file' => 'sometimes|image',
        //     'flyers' => 'sometimes|image',
        //     'active' => 'required|sometimes'
        // ]);

        $news = new News();

        $news->title = $request->title;
        $request->active ? $news->active = 1 : $news->active = 0;
        $news->slug = str_slug($request->title);
        $news->user_id = auth('api')->user()->id;
        $news->body  = $request->body;

        $news->save();

        $log = new LogController();
        // $log->createLog("added news named $news->title", 'news');
        $log->createLog("kreirana vest : $news->title", 'vest');

        if ($request->hasFile('flyers')) {

            $flyers = $request->file('flyers');
            // dd($flyers);

            foreach($flyers as $flyer) {
            $filename = uniqid('news_') . '.' . $flyer->getClientOriginalExtension();
            $path = public_path('/uploads/news');
            $uploaded = $flyer->move($path, $filename);

            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($news);
            $image->save();
            }
        }

        if ($request->hasFile('featured')) {
            $featured = $request->file('featured');
            $featured_name = uniqid('featured_') . '.' . $featured->getClientOriginalExtension();
            $path = public_path('/uploads/featured');
            $featured->move($path, $featured_name);
            $news->featured = $featured_name;

            $news->save();
        }


        return response([
            'data' => new NewsResource($news)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::findOrFail($id);
        // $news = News::whereSlug($slug)->first();
        return new NewsResource($news);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, News $news)
    {
        // $this->NewsUserCheck($news);


        $news->title = $request->title;
        $request->active == 'on' ? $news->active = 1 : $news->active = 0;
        $news->slug = str_slug($request->title);
        $news->body  = $request->body;

        $news->update();

        if ($request->hasFile('featured')) {
            $featured = $request->file('featured');
            $featured_name = uniqid('featured_') . '.' . $featured->getClientOriginalExtension();
            $path = public_path('/uploads/featured');
            $featured->move($path, $featured_name);
            $news->featured = $featured_name;

            $news->save();
        }

        if ($request->hasFile('flyers')) {

            $flyers = $request->file('flyers');
            // dd($flyers);

            foreach($flyers as $flyer) {
            $filename = uniqid('news_') . '.' . $flyer->getClientOriginalExtension();
            $path = public_path('/uploads/news');
            $uploaded = $flyer->move($path, $filename);

            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($news);
            $image->save();
            }
        }

        $log = new LogController();
        // $log->createLog("izmenjena vest : $news->title", 'vest');
        // $news->update($request->all());
        return response([
            'data' => new NewsResource($news)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
    //    $this->NewsUserCheck($news);

        if (isset($news->images)) {
            foreach($news->images as $image) {

                File::delete($image->image_url);
                $image->delete();
            }
            // $news->images->delete();
        }

        if (isset($news->featured)) {
            
            File::delete(public_path('uploads/featured/'.$news->featured));
        }

        $news->delete();

        $log = new LogController();
        // $log->createLog("added news named $news->title", 'news');
        $log->createLog("obrisana vest : $news->title", 'vest');

        return response(Response::HTTP_NO_CONTENT);
    }

    public function NewsUserCheck($event)
    {
        $user = auth('api')->user();
        if ($user->id !== $event->user_id) {
            
            throw new NewsNotBelongsToUser;
            
        }
    }

}
