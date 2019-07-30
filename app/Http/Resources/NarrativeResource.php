<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NarrativeResource extends JsonResource
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
            'organization_name' => $this->organization_name,
            'project_title' => $this->project_title,
            'contract_number' => $this->contract_number,
            'project_value' => $this->project_value,
            'application_area' => $this->application_area,
            'authorized_person' => $this->authorized_person,
            'coordinator' => $this->coordinator,
            'short_description' => $this->short_description,
            'accomplished_goals' => $this->accomplished_goals,
            'goal_explanation' => $this->goal_explanation,
            'expected_results' => $this->expected_results,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'target_group_direct' => $this->target_group_direct,
            'target_group_indirect' => $this->target_group_indirect,
            'other' => $this->other,
        ];
    }
}
