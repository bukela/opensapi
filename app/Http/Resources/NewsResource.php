<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\FileResource;
use App\Http\Resources\FileNewsResource;
use Illuminate\Http\Resources\Json\Resource;

class NewsResource extends Resource
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
            'description' => $this->body,
            'featured' => isset($this->featured) ? asset('/uploads/featured/'.$this->featured) : null,
            'images' => FileResourceNews::collection($this->images),
            // 'image' => new FileResourceNews($this->image),
            // 'created' => $this->created_at,
            'slug' => $this->slug
        ];
    }
}
