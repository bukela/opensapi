<?php

namespace App;

use App\Traits\Sluggable;


use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    
    protected $fillable = ['title', 'body', 'slug', 'active', 'featured'];
    // use Sluggable;
    
    // protected static $sluggable = [
    //     'from' => ['title'],
    //     'to' => 'slug',
    // ];
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

    public function images(){

        return $this->morphMany(File::class, 'file');

    }
    // public function getRouteKey()
    // {
    //    return 'slug';
    // }
}
