<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PublicationCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'active' => $this->active == 1 ? true : false,
            'file' => isset($this->file) ? asset('/uploads/publications/'.$this->file->filename) : [],
            'created' => $this->created_at->format('d. M Y.'),
            'slug' => $this->slug,
            'href' => [
                'link' => route('publications.show',$this->id)
            ]
        ];
    }
}
