<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewCostResource extends JsonResource
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
            'payment_date' => $this->payment_date ? date('Y-m-d', strtotime($this->payment_date)) : 'N/A',
            'payment_date_for_table' => $this->payment_date ? date('d.m.Y.', strtotime($this->payment_date)) : 'N/A',
            'invoice_number' => $this->invoice_number,
            'spent_donator' => $this->spent_donator,
            'spent_private' => $this->spent_private,
            'document' => $this->image ? asset('uploads/documents/'.$this->image['filename']) : null,
            'document_name' => $this->image ? $this->image['filename'] : null
        ];
    }
}
