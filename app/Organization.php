<?php

namespace App;

use App\Project;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'description', 'email', 'avatar'];

    public function projects() {

        $this->hasMay(Project::class);

    }

    public function users() {

        return $this->belongsToMany(User::class);

    }
}
