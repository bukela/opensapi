<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserCollection extends Resource
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
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active,
            'moderator' => $this->moderator,
            'role_id' => $this->role_id,
            'role' => $this->role->name,
            'avatar' => isset($this->avatar) ? asset('uploads/avatars/'.$this->avatar) : null
        ];
    }
}
