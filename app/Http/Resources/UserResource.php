<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active == 1 ? true : false,
            'moderator' => $this->moderator == 1 ? true : false,
            'description' => $this->description,
            'role_id' => $this->role_id,
            'role' => $this->role->name,
            'avatar' => isset($this->avatar) ? asset('uploads/avatars/'.$this->avatar) : null,
            'created_at' => $this->created_at->format('d-M-Y'),
            // 'organizations' => OrganizationResourceId::collection($this->organizations),
            // 'users' => UserResourceId::collection($this->donator_users),
            // 'projects' => ProjectResource::collection($this->projects),
        ];
    }
}
