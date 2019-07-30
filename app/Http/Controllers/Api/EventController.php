<?php

namespace App\Http\Controllers\Api;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use App\Exceptions\EventNotBelongsToUser;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use App\File as FileModel;

class EventController extends Controller
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

            
            return EventCollection::collection(Event::where('title', 'like', "%{$search}%")->paginate(10));

        } else {

            return EventCollection::collection(Event::orderBy('created_at', 'desc')->paginate(10));

        }

        // return EventCollection::collection(Event::orderBy('created_at', 'desc')->where('active', 1)->paginate(10));
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
    public function store(EventRequest $request)
    {
        $event = new Event;
        $event->title = $request->title;
        $request->active == 'on' ? $event->active = 1 : $event->active = 0;
        $event->user_id = auth('api')->user()->id;
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

        $event->save();

        return response([
            'data' => new EventResource($event)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $event = Event::whereSlug($slug)->first();
        // $event = Event::findOrFail($id);
        return new EventResource($event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        // $this->EventUserCheck($event);
        $event->title = $request->title;
        $request->active == 'on' ? $event->active = 1 : $event->active = 0;
        $event->content  = $request->content;
        $event->start_date  = $request->start_date;
        $event->end_date  = $request->end_date;
        $event->slug = str_slug($request->title);
        

        $event->update();

        $log = new LogController();
        $log->createLog("edited event named $event->title", 'event');

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
        return response([
            'data' => new EventResource($event)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        // $this->EventUserCheck($event);
        
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

        return response(Response::HTTP_NO_CONTENT);
    }

    public function EventUserCheck($event)
    {
        if (auth('api')->user()->id !== $event->user_id) {
            throw new EventNotBelongsToUser;
        }
    }

}
