<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\Resource;

class ProjectCollection extends Resource
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
            'organization_id' => $this->organization_id,
            // 'organization_name' => User::where('id', $this->organization_id)->first()->name,
            'donator_id' => $this->donator_id,
            // 'donator_name' => User::where('id', $this->donator_id)->first()->name,
            'description' => $this->description,
            'href' =>  [
                'link' => route('projects.show', $this->id)
            ]

        ];
    }
}
