<?php

namespace App;

use App\Project;
use App\User as Organization;
use App\User as Donator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public function findForPassport($identifier) {

        return User::orWhere('email', $identifier)->where('active', 1)->first();

    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'description',
        'role_id',
    ];

    // protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function role() {

        return $this->belongsTo(Role::class);
    }
    
    public function isAdmin() :bool {

        return $this->role->code === 'admin';
    }

    public function isDonator() :bool {

        return $this->role->code === 'donator';
    }

    public function isOrganization() :bool {

        return $this->role->code === 'organization';
    }

    public function isModerator() :bool {

        return $this->moderator == 1;
    }

    public function is($role) {
        
        return $this->role->code === $role;
    }

    public function donator_projects() {

        return $this->hasMany(Project::class, 'donator_id');

    }

    public function organization_projects() {

        return $this->hasMany(Project::class, 'organization_id');

    }

    public function organizations() {

        // return $this->belongsToMany(Organization::class);
        return $this->belongsToMany(Organization::class, 'organization_user', 'user_id', 'organization_id');


    }

    public function donators() {

        return $this->belongsToMany(Donator::class, 'donator_user', 'user_id', 'donator_id' );

    }

    public function donator_users() {

        return $this->belongsToMany(User::class, 'donator_user', 'donator_id', 'user_id');

    }

    public function organization_users() {

        return $this->belongsToMany(User::class, 'organization_user', 'organization_id', 'user_id');

    }

    public function events() {

        return $this->hasMany(Event::class);

    }

    public function news() {

        return $this->hasMany(News::class);

    }

    public function detail() {

        return $this->hasOne(Detail::class);

    }

 }
