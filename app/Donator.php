<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Donator extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public function findForPassport($identifier) {

        return Donator::orWhere('email', $identifier)->where('active', 1)->first();

    }

    // protected $guard = 'donator';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'description',
        'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects() {

        return $this->hasMany(Project::class);

    }

    public function users() {

        return $this->belongsToMany(User::class, 'donator_user', 'donator_id', 'user_id');

    }

}
