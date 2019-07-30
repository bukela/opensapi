<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class EventCollection extends Resource
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
            'slug' => $this->slug,
            'active' => $this->active == 1 ? true : false,
            'description' => $this->content,
            'featured' => isset($this->featured) ? asset('uploads/featured/'.$this->featured) : null,
            'images' => FileResource::collection($this->images),
            'start_date' => $this->start_date ? date('d. M Y.', strtotime($this->start_date)) : 'N/A',
            'end_date' => $this->end_date ? date('d. M Y.', strtotime($this->end_date)) : 'N/A',
            'href' => [
                'link' => route('events.show',$this->id)
            ]
        ];
    }
}
