<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NewsCollection extends Resource
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
            'active' => $this->active == 1 ? true : false,
            'images' => FileResourceNews::collection($this->images),
            'featured' => isset($this->featured) ? asset('/uploads/featured/'.$this->featured) : null,
            // 'images' => isset($this->image->filename) ? asset('/uploads/news/'.$this->image->filename) : [],
            'description' => $this->body,
            'created' => $this->created_at->format('d-M-Y'),
            'slug' => $this->slug,
            'href' => [
                'link' => route('news.show',$this->id)
            ]
        ];
    }
}
