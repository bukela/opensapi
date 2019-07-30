<?php

namespace App\Http\Controllers\Admin;

use App\Organization;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');

        $organizations = User::whereHas('role', function($q){
            $q->where('name', 'organization');
        })->orderBy($order, $sort)->paginate(10);

        return view('admin.organizations.index', compact('organizations', 'filter', 'order', 'sort'));
    }

    public function search(Request $request) {


        $organizations = User::where('role_id', 3);

        if(!empty($request->search)) {

            $organizations = $organizations->where('name', 'like', "%{$request->search}%")
            
            ->orWhere('email', 'like', "%{$request->search}%")->paginate(20);

        } else {

            $organizations = User::where('role_id', 3)->paginate(20);
            
        }

        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
    
    return view('admin.organizations.index', compact('organizations','filter','order','sort'));

    }

}
