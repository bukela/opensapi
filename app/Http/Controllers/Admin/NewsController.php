<?php

namespace App\Http\Controllers\Admin;

use App\News;
use App\File as FileModel;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', false);
        $order = $request->get('order', 'title');
        $sort = $request->get('sort', 'asc');

        if ($filter) {
            if ($request->get('filter') === 'news') {
                $news = News::orderBy($order, $sort)->paginate(10);
            }
        } else {
            $news = News::orderBy($order, $sort)->paginate(10);

        }

        return view('admin.news.index', compact('news', 'filter', 'order', 'sort'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(NewsRequest $request)
    {
        $news = new News();

        $news->title = $request->title;
        $request->active == 'on' ? $news->active = 1 : $news->active = 0;
        $news->slug = str_slug($request->title);
        $news->user_id = Auth::user()->id;
        $news->body  = $request->body;

        $news->save();

        $log = new LogController();
        // $log->createLog("added news named $news->title", 'news');
        $log->createLog("kreirana vest : $news->title", 'vest');

        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $filename = uniqid('news_') . '.' . $file->getClientOriginalExtension();
        //     $path = public_path('/uploads/news');

        //     $uploaded = $file->move($path, $filename);


        //     $image = new FileModel();
        //     $image->filename = $uploaded->getFilename();
        //     $image->image_url = $uploaded->getPathname();
        //     $image->file()->associate($news);
        //     $image->save();
        // }

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

        return redirect()->route('admin.news.index')->with('status', ['type' => 'success', 'message' => __('News created successfully')]);
    }

    public function show($id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.show', compact('news'));
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(NewsRequest $request, $id)
    {
        $news = News::findOrFail($id);
        
        // $request->validate([
        //     // 'title' => 'required|min:3|max:255|unique:news,title,' .$news->id,
        //     'title' => 'required|min:3|max:255',
        //     'body'  => 'required',
        //     'active' => 'required|sometimes'
        // ]);

        $news->title = $request->title;
        $request->active == 'on' ? $news->active = 1 : $news->active = 0;
        $news->slug = str_slug($request->title);
        $news->body  = $request->body;

        $news->update();


        $log = new LogController();
        // $log->createLog("edited a news named $news->title", 'news');
        $log->createLog("izmenjena vest : $news->title", 'vest');


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

        return redirect()->route('admin.news.index')->with('status', ['type' => 'success', 'message' => __('News updated successfully')]);
    }

    public function destroy($id)
    {

        $news = News::findOrFail($id);
        // File::delete(public_path().'/'.$event->flyer);
        
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
        // $log->createLog("deleted news named $news->title", 'news');
        $log->createLog("obrisana vest : $news->title", 'vest');

        return redirect(route('admin.news.index'))->with('status', ['type' => 'success', 'message' => __('News deleted successfully')]);
    }

    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        File::delete(public_path('uploads/news/').$file->filename);
        $file->delete();
        return redirect()->back();

    }

    public function featured($id) {

        $news = News::findOrFail($id);
        File::delete(public_path('uploads/featured/'.$news->featured));
        $news->update(['featured' => NULL]);
        return redirect(route('admin.news.edit', $news->id));

    }

    public function search(Request $request)
    {

        $news = News::where('title', 'like', "%{$request->search}%")
            ->paginate(20);


        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
        
        return view('admin.news.index', compact('news','filter','order','sort'));
    }
}
