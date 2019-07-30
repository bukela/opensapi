<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\User as Organization; 
// use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{

    // public function __construct() {

    //     $this->middleware('auth:api')->except('index', 'show');

    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = User::whereHas('role', function($q){
            $q->where('name', 'organization');
        })->get();

        return OrganizationCollection::collection($organizations);
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'active' => 'required|sometimes',
            'moderator' => 'required|sometimes',
            'email'      => 'required|email|unique:organizations',
            'password'   => 'required|confirmed'
        ]);

        $organization = new Organization;

        $organization->name = $request->name;
        $request->active == 'on' ? $organization->active = 1 : $organization->active = 0;
        $organization->email = $request->email;
        $request->moderator == 'on' ? $organization->moderator = 1 : $organization->moderator = 0;
        $organization->description  = $request->description;
        $organization->password   = bcrypt($request->password);
        // $organization->avatar  = $request->avatar;
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = uniqid('org_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            
            $organization->avatar = $avatar_name;
        }

        $log = new LogController();
        $log->createLog("created organization named $organization->name", 'organization');

        $organization->save();

        return response([
            'data' => new OrganizationResource($organization)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        // $old_name = $organization->name;

        $request->validate([
            'name' => 'required',
            'active' => 'required|sometimes',
            'moderator' => 'required|sometimes',
            'email'      => 'required|email|unique:organizations,email,'.$organization->id,
            'password'   => 'sometimes|confirmed'
        ]);


        $organization->name = $request->name;
        $request->active == 'on' ? $organization->active = 1 : $organization->active = 0;
        $organization->email = $request->email;
        $request->moderator == 'on' ? $organization->moderator = 1 : $organization->moderator = 0;
        $organization->description  = $request->description;
        $organization->password   = bcrypt($request->password);
        // $organization->avatar  = $request->avatar;
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = uniqid('org_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            
            $organization->avatar = $avatar_name;
        }


        $organization->save();

        $log = new LogController();
        $log->createLog("edited organization named $organization->name", 'organization');

        return response([
            'data' => new OrganizationResource($organization)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (isset($organization->avatar)) {

        //     File::delete(public_path('uploads/avatars/'.$organization->avatar));

        // }

        // $organization->delete();

        // $log = new LogController();
        // $log->createLog("deleted organization named $organization->name", 'organization');

        // return response(['data' => 'Organization '.$organization->name.' deleted.']);
    }
}
