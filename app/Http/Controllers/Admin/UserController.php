<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Logger;
use App\Organization;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserUpdateRequest;
use App\Detail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');

        // if ($filter) {
        //     if ($request->get('filter') === 'users') {
        //         $users = User::with('role')->orderBy($order, $sort)->paginate(10);
        //     }
        // }else {
        //     $users = User::with('role')->orderBy($order, $sort)->paginate(10);
        // }

        $users = User::orderBy($order, $sort)->paginate(10);

        return view('admin.user.index', compact('users', 'filter', 'order', 'sort'));
    }

    public function create()
    {
        $roles = Role::all();
        // $organizations = Organization::all();
        $organizations = User::whereHas('role', function($q){
            $q->where('name', 'organization');
        })->get();

        $donators = User::whereHas('role', function($q){
            $q->where('name', 'donator');
        })->get();

        
        return view('admin.user.create', compact('roles','organizations','donators'));
    }

    public function create_donator() {
        return view('admin.user.donator_create');
    }

    public function create_org() {
        return view('admin.user.org_create');
    }


    public function store(UserRequest $request)
    {
        $user             = new User();
        $user->name = $request->name;
        $request->active == 'on' ? $user->active = 1 : $user->active = 0;
        $request->moderator == 'on' ? $user->moderator = 1 : $user->moderator = 0;
        $user->email      = $request->email;
        $user->role_id    = $request->role_id;
        $user->description    = $request->description;
        $user->password   = bcrypt($request->password);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('/uploads/avatars');
            $avatar->move($path, $avatar_name);
            
            $user->avatar = $avatar_name;
        }
        // dd($request);
        if($request->has('user')) {

            if(!empty($request->organization)) {

                $user->role_id = 3;
                $user->save();
                $user->organizations()->attach($request->organization);
    
            }
    
            if(!empty($request->donator)) {
    
                $user->role_id = 2;
                $user->save();
                $user->donators()->attach($request->donator);
    
            }

        }
        $user->save();

        

        $log = new LogController();
        // $log->createLog("created user named $user->name", 'user');
        $log->createLog("kreiran korisnik : $user->name", 'korisnik');

        if ($user->role_id == 3) {

            return redirect()->route('admin.detail.create', $user->id)->with('status', ['type' => 'success', 'message' => __('User created successfully')]);

        }

        // Mail::to($request->email)->send(new WelcomeMail($user));
        

        

        return redirect()->route('admin.users.index')->with('status', ['type' => 'success', 'message' => __('User created successfully')]);
    }

    public function show($id)
    {
        abort(404);
        
    }

    public function edit(User $user)
    {
        $organizations = User::whereHas('role', function($q){
            $q->where('name', 'organization');
        })->get();

        $donators = User::whereHas('role', function($q){
            $q->where('name', 'donator');
        })->get();
        return view('admin.user.edit', compact('user', 'organizations'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $request->active == 'on' ? $user->active = 1 : $user->active = 0;
        $request->moderator == 'on' ? $user->moderator = 1 : $user->moderator = 0;
        $user->description = $request->description;

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
            $user->update();
        }
        
        $user->update();
        // $user->organizations()->sync($request->organization);

        $log = new LogController();
        // $log->createLog("edited user named $user->name", 'user');
        $log->createLog("izmenjen korisnik : ".$user->name, 'korisnik');
        // if ($user->isDonator()) {

        //     return redirect()->route('admin.donators.index')->with('status', ['type' => 'success', 'message' => 'User updated successfully.']);

        // } elseif ($user->isOrganization()) {

        //     return redirect()->route('admin.organizations.index')->with('status', ['type' => 'success', 'message' => 'User updated successfully.']);

        // } else

        return redirect()->route('admin.users.index')->with('status', ['type' => 'success', 'message' => __('User updated successfully')]);
    }

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

        // if ($user->isDonator()) {

        //     return redirect()->route('admin.donators.index')->with('status', ['type' => 'success', 'message' => 'User deleted successfully.']);

        // } elseif ($user->isOrganization()) {

        //     return redirect()->route('admin.organizations.index')->with('status', ['type' => 'success', 'message' => 'User deleted successfully.']);

        // } else

        return redirect()->route('admin.users.index')->with('status', ['type' => 'success', 'message' => __('User deleted successfully')]);
    }


    public function avatar($id) {

        $user = User::findOrFail($id);
        File::delete(public_path('uploads/avatars/'.$user->avatar));
        $user->update(['avatar' => NULL]);
        return redirect(route('admin.users.edit', $user->id));

    }


    public function search(Request $request)
    {
        // $search = $request->search;
        // $users = User::with('role')->get();
        // $users = User::where('name', 'like', '%' . $search . '%')
        //     ->orWhere('email', 'like', '%' .$search. '%')
        //     // >orWhere('email', 'like', '%' .$search. '%')
        //     ->paginate(20);

        $users = User::whereHas('role', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->orWhere('email', 'like', "%{$request->search}%")
            ->orWhere('name', 'like', "%{$request->search}%")->paginate(20);


        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
        
        return view('admin.user.index', compact('users','filter','order','sort'));
    }
}
