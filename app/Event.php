<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'content', 'flyer', 'start_date', 'end_date', 'featured'];

    public function images() {
        return $this->morphMany(File::class, 'file');
    }

    public function setSlugAttribute($value) {

        if (static::whereSlug($slug = str_slug($value))->exists()) {
    
            $slug = $this->incrementSlug($slug);
        }
    
        $this->attributes['slug'] = $slug;
    }
    
    
    public function incrementSlug($slug) {
    
        $original = $slug;
    
        $count = 1;
    
        while (static::whereSlug($slug)->exists()) {
    
            $slug = "{$original}-" . $count++;
        }
    
        return $slug;
    
    }
    // protected $dates = [
    //     'start_date', 'end_date'
    // ];

    // public function getStartDateAttribute($value) {

    //     return date("d-m-Y", strtotime($value));
        
    // }

    // public function getEndDateAttribute($value) {

    //     return date("d-m-Y", strtotime($value));
        
    // }
}
