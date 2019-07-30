<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public function organization() {

        return $this->belongsTo(User::class);
        
    }
}
