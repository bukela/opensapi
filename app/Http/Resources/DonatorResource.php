<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonatorResource extends JsonResource
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
            'moderator' => $this->moderator,
            'active' => $this->active,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => isset($this->avatar) ? asset('uploads/avatars/'.$this->avatar) : null,
            'decription' => $this->description
        ];
    }
}
