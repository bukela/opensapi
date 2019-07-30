<?php

namespace App\Http\Resources;

use App\Http\Resources\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'active' => $this->active == 1 ? true : false,
            'featured' => isset($this->featured) ? asset('uploads/featured/'.$this->featured) : null,
            'description' => $this->content,
            'start_date' => $this->start_date ? $this->start_date : 'N/A',
            // 'start_date' => $this->start_date ? date('d.M Y', strtotime($this->start_date)) : 'N/A',
            'end_date' => $this->end_date ? $this->end_date : 'N/A',
            // 'end_date' => $this->end_date ? date('d.M Y', strtotime($this->end_date)) : 'N/A',
            // 'flyer' => isset($this->images) ? $this->images : null,
            'images' => FileResource::collection($this->images),
            'slug' => $this->slug
        ];
    }
}
