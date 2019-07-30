<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'project_id' => $this->project_id,
            'name' => $this->name,
            'type' => $this->direct_cost == 1 ? 'direct' : 'indirect',
            'approved_for_category' => $this->approved_for_category,
            'total_spent_for_category' => $this->costs->sum('spent'),
            'total_remain_for_category' => $this->approved_for_category - $this->costs->sum('spent'),
            'total_spent_percent' => $this->approved_for_category > 0 ? round($this->costs->sum('spent') / $this->approved_for_category * 100, 2).' %' : 'n/a'
        ];
    }
}
