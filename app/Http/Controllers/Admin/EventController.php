<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\File as FileModel;
//use App\
// use Illuminate\Console\Scheduling\Event;



class EventController extends Controller
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
            if ($request->get('filter') === 'events') {
                $events = Event::orderBy($order, $sort)->paginate(10);
            }
        } else {
            $events = Event::orderBy($order, $sort)->paginate(10);

        }

        return view('admin.events.index', compact('events', 'filter', 'order', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        // if ($request->has('flyer')) {

        //     $flyer = $request->flyer;
        //     $flyer_name = time().$flyer->getClientOriginalName();
        //     $flyer->move('uploads/events', $flyer_name);

        // }
        

        $event = new Event;
        $event->title = $request->title;
        $request->active == 'on' ? $event->active = 1 : $event->active = 0;
        $event->user_id = Auth::user()->id;
        $event->content = $request->content;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        // $event->flyer = 'uploads/events/'.$flyer_name;
        $event->slug = str_slug($request->title);
        // dd($request);
        $event->save();

        if ($request->hasFile('featured')) {
            $featured = $request->file('featured');
            $featured_name = uniqid('featured_') . '.' . $featured->getClientOriginalExtension();
            $path = public_path('/uploads/featured');
            $featured->move($path, $featured_name);
            $event->featured = $featured_name;

            $event->save();
        }

        if ($request->hasFile('flyers')) {

            $flyers = $request->file('flyers');
            // dd($flyers);

            foreach($flyers as $flyer) {
            $filename = uniqid('events_') . '.' . $flyer->getClientOriginalExtension();
            $path = public_path('/uploads/events');
            $uploaded = $flyer->move($path, $filename);

            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($event);
            $image->save();
            }
        }



        $log = new LogController();
        // $log->createLog("created event named $event->title", 'event');
        $log->createLog("kreiran događaj : $event->title", 'događaj');

        // $image = new FileModel();
        //     $image->filename = $uploaded->getFilename();
        //     $image->image_url = $uploaded->getPathname();
        //     $image->file()->associate($event);
        //     $image->save();

        // Session::flash('success', 'Event created successfully !');
        return redirect(route('admin.events.index'))->with('status', ['type' => 'success', 'message' => __('Event created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Event::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = Event::findOrFail($id);


        $event->title = $request->title;
        $request->active == 'on' ? $event->active = 1 : $event->active = 0;
        $event->content  = $request->content;
        $event->start_date  = $request->start_date;
        $event->end_date  = $request->end_date;
        $event->slug = str_slug($request->title);
        

        $event->update();

        $log = new LogController();
        // $log->createLog("edited event named $event->title", 'event');
        $log->createLog("izmenjen događaj : $event->title", 'događaj');

        if ($request->hasFile('featured')) {
            File::delete(public_path('uploads/featured/'.$event->featured));
            $featured = $request->file('featured');
            $featured_name = uniqid('featured_') . '.' . $featured->getClientOriginalExtension();
            $path = public_path('/uploads/featured');
            $featured->move($path, $featured_name);
            $event->featured = $featured_name;

            $event->save();
        }

        if ($request->hasFile('flyers')) {

            $flyers = $request->file('flyers');
            // dd($flyers);

            foreach($flyers as $flyer) {
            $filename = uniqid('events_') . '.' . $flyer->getClientOriginalExtension();
            $path = public_path('/uploads/events');
            $uploaded = $flyer->move($path, $filename);

            $image = new FileModel();
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            $image->file()->associate($event);
            $image->save();
            }
        }
        return redirect(route('admin.events.index'))->with('status', ['type' => 'success', 'message' => __('Event updated successfully')]);;
    }
        
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        // File::delete(public_path().'/'.$event->flyer);
        
        if (isset($event->images)) {
            foreach($event->images as $image) {

                File::delete($image->image_url);
                $image->delete();
            }
            
            // $event->images->delete();
        }

        if (isset($event->featured)) {
            
            File::delete(public_path('uploads/featured/'.$event->featured));
        }

        $event->delete();

        $log = new LogController();
        // $log->createLog("deleted event named $event->title", 'event');
        $log->createLog("obrisan događaj : $event->title", 'događaj');

        return redirect(route('admin.events.index'))->with('status', ['type' => 'success', 'message' => __('Event deleted successfully')]);
    }

    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        File::delete(public_path('uploads/events/').$file->filename);
        $file->delete();
        return redirect()->back();

    }

    public function featured($id) {

        $event = Event::findOrFail($id);
        File::delete(public_path('uploads/featured/'.$event->featured));
        $event->update(['featured' => NULL]);
        return redirect(route('admin.events.edit', $event->id));

    }

    public function search(Request $request)
    {

        $events = Event::where('title', 'like', "%{$request->search}%")
            ->paginate(20);


        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
        
        return view('admin.events.index', compact('events','filter','order','sort'));
    }
}
