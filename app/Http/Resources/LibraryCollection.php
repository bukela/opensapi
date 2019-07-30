<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LibraryCollection extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'active' => $this->active == 1 ? true : false, 
            'file' => isset($this->file) ? asset('/uploads/libraries/'.$this->file->filename) : [],
        ];
    }
}
