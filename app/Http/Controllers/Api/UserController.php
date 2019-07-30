<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Logger;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Api\LogController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // public function __construct() {

    //     $this->middleware('auth:api');
    //     $this->middleware('moderator-only')->except('index', 'show');
        
    // }
    public function index(Request $request)
    {
        
        $search = $request->get('search');

        if(isset($search)) {

            return UserCollection::collection(User::where('name', 'like', "%{$search}%")->
            orWhere('email', 'like', "%{$search}%")->paginate(10));

        } else {

            return UserCollection::collection(User::orderBy('created_at', 'desc')->paginate(10));

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
    public function store(UserRequest $request)
    {

        $user             = new User();
        $user->name = $request->name;
        $request->active == 'on' ? $user->active = 1 : $user->active = 0;
        $request->moderator == 'on' ? $user->moderator = 1 : $user->moderator = 0;
        $user->email      = $request->email;
        // $user->role_id    = 4;
        $user->description    = $request->description;
        $user->password   = bcrypt($request->password);

        $user->save();

        $parent = auth('api')->user();

        if($parent->role_id == 3) {

            $user->role_id = 3;
            $user->organizations()->attach($parent->id);

        }

        if($parent->role_id == 2) {

            $user->role_id = 2;
            $user->donators()->attach($parent->id);

        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            
            $user->avatar = $avatar_name;
        }


        $user->save();

        // Mail::to($request->email)->send(new WelcomeMail($user));

        $log = new LogController();
        $log->createLog("kreiran korisnik : $user->name (".$user->role->code.")", 'korisnik');

        return response([
            'message' => 'user created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
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
    public function update(UserUpdateRequest $request, $id)
    {
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $request->active == 'on' ? $user->active = 1 : $user->active = 0;
        $request->moderator == 'on' ? $user->moderator = 1 : $user->moderator = 0;
        $user->description = $request->description;

        $user->save();
        $log = new LogController();
        $log->createLog("izmenjen korisnik : $user->name", 'korisnik');

        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {

            File::delete(public_path('uploads/avatars/'.$user->avatar));

            $avatar = $request->file('avatar');
            $avatar_name = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            
            $user->avatar = $avatar_name;
            
            $user->save();
            
        }
        
        
        // $log = new LogController;
        // $log->createLog("izmenjen korisnik : $user->name", 'korisnik');
        

        return response([
            'message' => 'user updated'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (isset($user->avatar)) {

            File::delete(public_path('uploads/avatars/'.$user->avatar));

        }

        if(isset($user->organization_projects)) {

            foreach($user->organization_projects as $pro) {
                $pro->delete();
            }

        }

        if(isset($user->donator_projects)) {

            foreach($user->donator_projects as $pro) {
                $pro->delete();
            }

        }

        $user->organizations()->detach();
        $user->donators()->detach();
        $user->delete();
        
        $log = new LogController();
        // $log->createLog("delete user named $user->name", 'user');
        $log->createLog("obrisan korisnik : $user->name (".$user->role->code.")", 'korisnik');

        return response([
            'data' => 'User '.$user->name.' deleted.'
        ]);
    }
}
