<?php

namespace App\Http\Controllers\Admin;

use App\News;
use App\User;
use App\Event;
use App\Gallery;
use App\Library;
use App\Project;
use App\Publication;
use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function __construct() {

        return $this->middleware('auth');

    }
    public function index()
    {
       $users = User::count();

       $events = Event::count();

       $organizations = User::whereHas('role', function($q){
        $q->where('name', 'organization');
            })->count();

        $donators = User::whereHas('role', function($q){
                $q->where('name', 'donator');
            })->count();

       $projects = Project::count();
       $news = News::count();

       $publications = Publication::count();

       $libraries = Library::count();

       $galleries = Gallery::count();

        return view('admin.dashboard', compact('users', 'events', 'organizations', 'projects', 'news', 'donators','publications','libraries','galleries'));
    }

}
