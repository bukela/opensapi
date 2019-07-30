<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CostResource extends JsonResource
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
            'category_id' => $this->category_id,
            'project_id' => $this->project_id,
            'description' => $this->description,
            // 'approved' => $this->approved == 1 ? 'approved' : 'not approved',
            'status' => $this->status,
            'note' => $this->note,
            'spent' => $this->spent,
            'document' => $this->image ? asset('uploads/documents/'.$this->image['filename']) : null,
            'document_name' => $this->image ? $this->image['filename'] : null
        ];
    }
}
