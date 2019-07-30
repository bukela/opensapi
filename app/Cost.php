<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    public function project() {

        return $this->belongsTo(Project::class);

    }

    public function category() {

        return $this->belongsTo(Category::class);

    }

    public function image() {

        return $this->morphOne(File::class, 'file');

    }
}
