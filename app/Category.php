<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','project_id','approved_for_category','direct_cost'];

    protected $appends = ['total_categories'];


    function getTotalCategoriesAttribute() {
        return $this->approved_for_category + $this->approved_for_category_private;
    }

    public function project() {

        // return $this->belongsToMany(Project::class)->withPivot('approved_for_category');
        return $this->belongsTo(Project::class);
        
    }

    public function costs() {
        return $this->hasMany(Cost::class);
    }

    public function getNameAttribute($value) {

        return ucwords($value);

    }
}
