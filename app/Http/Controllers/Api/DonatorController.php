<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\User as Donator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\DonatorResource;
use App\Http\Resources\DonatorCollection;
use Symfony\Component\HttpFoundation\Response;

class DonatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donators = User::whereHas('role', function($q){
            $q->where('name', 'donator');
        })->get();

        return DonatorCollection::collection($donators);
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
            'email'      => 'required|email|unique:donators,email',
            'password'   => 'required|confirmed'
        ]);

        $donator             = new Donator();
        $donator->name = $request->name;
        $request->active == 'on' ? $donator->active = 1 : $donator->active = 0;
        $donator->email      = $request->email;
        $request->moderator == 'on' ? $donator->moderator = 1 : $donator->moderator = 0;
        $donator->description    = $request->description;
        $donator->password   = bcrypt($request->password);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            
            $donator->avatar = $avatar_name;
        }

        $donator->save();

        // $user->organizations()->attach($request->organization);

        $log = new LogController();
        $log->createLog("created donator named $donator->name", 'donator');

        return response([
            'data' => new DonatorResource($donator)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Donator $donator)
    {
        return new DonatorResource($donator);
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
        $donator = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'active' => 'required|sometimes',
            'moderator' => 'required|sometimes',
            'password'   => 'sometimes|confirmed',
            'email'      => 'required|email|unique:donators,email,' . $donator->id,
        ]);

        $donator->name = $request->name;
        $donator->email = $request->email;
        $request->active == 'on' ? $donator->active = 1 : $donator->active = 0;
        $request->moderator == 'on' ? $donator->moderator = 1 : $donator->moderator = 0;
        $donator->description = $request->description;

        if (isset($data['password'])) {
            $donator->password = bcrypt($data['password']);
        }

        if ($request->hasFile('avatar')) {

            File::delete(public_path('uploads/avatars/'.$donator->avatar));

            $avatar = $request->file('avatar');
            $avatar_name = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            $donator->avatar = $avatar_name;
            $donator->update();
        }
        
        $donator->update();
        // $donator->organizations()->sync($request->organization);

        $log = new LogController();
        $log->createLog("edited donator named $donator->name", 'donator');


        return response([
            'data' => new DonatorResource($donator)
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
        $donator = Donator::findOrFail($id);

        if (isset($donator->avatar)) {

            File::delete(public_path('uploads/avatars/'.$donator->avatar));

        }

        $donator->delete();
        // $donator->organizations()->detach();


        $log = new LogController();
        $log->createLog("delete donator named $donator->name", 'donator');

        return response(['data' => 'Donator '.$donator->name.' deleted.']);
    }
}
