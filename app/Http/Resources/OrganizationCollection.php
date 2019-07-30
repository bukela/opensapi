<?php

namespace App\Http\Resources;

use App\Detail;
use Illuminate\Http\Resources\Json\Resource;

class OrganizationCollection extends Resource
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
            'moderator' => $this->moderator,
            'active' => $this->active,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => isset($this->avatar) ? asset('uploads/avatars/'.$this->avatar) : null,
            'details' => new DetailResource($this->detail),
            'href' => [
                'link' => route('users.show',$this->id)
            ]
        ];
    }
}
