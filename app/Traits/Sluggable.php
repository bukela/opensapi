<?php

namespace App\Traits;

trait Sluggable
{
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function($model) {
            $to = self::$sluggable['to'];
            $from = self::$sluggable['from'];
            
            $string = '';
            
            foreach($from as $field) {
                $string .= str_replace('/', '-', $model->{$field}) . ' ';
            }
            
            $slug = str_slug($string);
            $count = self::where('id', '!=', $model->id)->whereRaw("{$to} RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            
            $slug = $count ? $slug . '-' . $count : $slug;
            $model->{$to} = $slug;
        });
    }
}