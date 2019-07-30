<?php

namespace App\Http\Controllers\Admin;

use App\User;
// use App\Donator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class DonatorController extends Controller
{
    public function index(Request $request) {

        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');

        $donators = User::whereHas('role', function($q){
            $q->where('name', 'donator');
        })->orderBy($order, $sort)->paginate(10);

        return view('admin.donators.index', compact('donators', 'filter', 'order', 'sort'));

    }

    public function search(Request $request) {


        $donators = User::where('role_id', 2);
        // ->where('email', 'like', "%{$request->search}%")
        if(!empty($request->search)) {

            $donators = $donators->where('name', 'like', "%{$request->search}%")

            ->orWhere('email', 'like', "%{$request->search}%")->paginate(20);
            
        } else {

            $donators = User::where('role_id', 2)->paginate(20);

        }
        // $donators = $donators->where('name', 'like', "%{$request->search}%")
        // ->orWhere('email', 'like', "%{$request->search}%")->paginate(20);

        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
    
    return view('admin.donators.index', compact('donators','filter','order','sort'));

    }
}
