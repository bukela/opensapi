<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_for_category = $this->approved_for_category + $this->approved_for_category_private;
        $total_spent = $this->costs->sum('spent_private') + $this->costs->sum('spent_donator');
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'name' => $this->name,
            'type' => $this->direct_cost == 1 ? 'direct' : 'indirect',
            'approved_for_category' => number_format($this->approved_for_category, 2,".",""),
            'approved_for_category_private' => number_format($this->approved_for_category_private, 2,".",""),
            'approved_for_category_total' => number_format($total_for_category, 2,".",""),
            'spent_for_category_donator' => number_format($this->costs->sum('spent_donator'), 2,".",""),
            'spent_for_category_private' => number_format($this->costs->sum('spent_private'), 2,".",""),
            'remain_for_category_donator' => number_format($this->approved_for_category - $this->costs->sum('spent_donator'), 2,".",""),
            'remain_for_category_private' => number_format($this->approved_for_category_private - $this->costs->sum('spent_private'), 2,".",""),
            'total_spent_for_category' => number_format($this->costs->sum('spent_private') + $this->costs->sum('spent_donator'), 2,".",""),
            'total_remain_for_category' => number_format($total_for_category - $total_spent, 2,".",""),
            'total_spent_percent' => $total_for_category > 0 ? round($total_spent / $total_for_category * 100, 2).' %' : 'n/a',
            'donator_spent_percent' => $this->approved_for_category > 0 ? round($this->costs->sum('spent_donator') / $this->approved_for_category * 100, 2).' %' : 'n/a',
            'private_spent_percent' => $total_for_category > 0 ? round($this->costs->sum('spent_private') / $total_for_category * 100, 2).' %' : 'n/a'
        ];
    }
}
