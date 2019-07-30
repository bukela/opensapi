<?php

namespace App;

use App\User;
use App\User as Organization;
use App\User as Donator;
// use App\Donator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'organization_id', 'donator_id'];

    public function user() {

        return $this->belongsTo(User::class);

    }

    public function donator() {

        return $this->belongsTo(Donator::class);

    }

    public function costs() {

        return $this->hasMany(Cost::class);
        
    }

    public function categories() {

        // return $this->belongsToMany(Category::class)->withPivot('approved_for_category')
        // ->withTimestamps();

        return $this->hasMany(Category::class);

    }

    public function organization() {

        return $this->belongsTo(Organization::class);

    }

    public function narrative() {

        return $this->hasOne(Narrative::class);

    }
}
