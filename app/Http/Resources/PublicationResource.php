<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
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
            'file' => isset($this->file) ? asset('/uploads/publications/'.$this->file->filename) : [],
            'created' => $this->created_at->format('d-M-Y'),
        ];
    }
}
