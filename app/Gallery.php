<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'decsription', 'slug', 'slide'];

    public function slides() 
    {
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
}
