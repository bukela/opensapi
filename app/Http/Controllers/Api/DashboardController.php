<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\News;
use App\User;
use App\Event;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Resources\UserNews;
use App\Http\Resources\UserEvents;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\EventCollection;
use App\Http\Resources\ProjectResource;

class DashboardController extends Controller

{
    // public function __construct() {

    //     $this->middleware('auth:api');
    //     // $this->middleware('organization-only')->except('index', 'show');
    // }

    public function user_events(Request $request) {

        // return new UserEvents($user);
        $user = auth('api')->user()->id;
        // return $user->events;

        $search = $request->get('search');

        if(isset($search)) {

            
            return EventCollection::collection(Event::where('user_id', $user)->where('title', 'like', "%{$search}%")->paginate(10));

        } else {

            return EventCollection::collection(Event::where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10));

        }

    }

    public function user_news(Request $request) {

        
        $user = auth('api')->user()->id;
        // $news =$user->news;

        $search = $request->get('search');

        if(isset($search)) {

            
            return NewsCollection::collection(News::where('user_id', $user)->where('title', 'like', "%{$search}%")->paginate(10));

        } else {

            return NewsCollection::collection(News::where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10));

        }

    }

    public function user_projects(Request $request) {

        $search = $request->get('search');

        // return new UserNews($user);
        $user = auth('api')->user();

        if($user->role_id == 3) {

            if($user->organizations->isNotEmpty()) {

                $id = $user->organizations->first()->id;
                // dd($id);
                // return ProjectResource::collection(Project::where('organization_id', $id)->paginate(10));

                if(isset($search)) {

            
                    return ProjectResource::collection(Project::where('organization_id', $id)->where('title', 'like', "%{$search}%")->paginate(10));
        
                } else {
        
                    return ProjectResource::collection(Project::where('organization_id', $id)->paginate(10));
        
                }
     
            }
            // return ProjectResource::collection(Project::where('organization_id', $user->id)->paginate(10));

            if(isset($search)) {

            
                return ProjectResource::collection(Project::where('organization_id', $user->id)->where('title', 'like', "%{$search}%")->paginate(10));
    
            } else {
    
                return ProjectResource::collection(Project::where('organization_id', $user->id)->paginate(10));
    
            }


        }

        if($user->role_id == 2) {

            if($user->donators->isNotEmpty()) {

                $id = $user->donators->first()->id;
     
                // $donator = User::findOrFail($id);
     
                // return ProjectResource::collection(Project::where('donator_id', $donator->id)->paginate(10));

                if(isset($search)) {

            
                    return ProjectResource::collection(Project::where('donator_id', $id)->where('title', 'like', "%{$search}%")->paginate(10));
        
                } else {
        
                    return ProjectResource::collection(Project::where('donator_id', $id)->paginate(10));
        
                }
     
            }

            // return $user->donator_projects;
            // return ProjectResource::collection(Project::where('donator_id', $user->id)->paginate(10));
            if(isset($search)) {

            
                return ProjectResource::collection(Project::where('donator_id', $user->id)->where('title', 'like', "%{$search}%")->paginate(10));
    
            } else {
    
                return ProjectResource::collection(Project::where('donator_id', $user->id)->paginate(10));
    
            }

        }

    //    if($user->organizations->isNotEmpty()) {

    //        $id = $user->organizations->first()->id;
    //        dd($id);
    //        return ProjectResource::collection(Project::where('organization_id', $id)->paginate(10));

    //    }
    }

    public function organization_users() {

        // return new UserEvents($user);
        $user = auth('api')->user();
        if($user->role_id == 3) {

            return $user->organization_users;

        }

        if($user->organizations->isNotEmpty()) {

            $id = $user->organizations->first()->id;

            $organization = User::findOrFail($id);

            return $organization->organization_users;

        }

    }

    public function donator_users() {

        // return new UserEvents($user);
        $user = auth('api')->user();
        if($user->role_id == 2) {

            return $user->donator_users;

        }

        if($user->donators->isNotEmpty()) {

            $id = $user->donators->first()->id;

            $donator = User::findOrFail($id);

            return $donator->donator_users;

        }

    }
 }
