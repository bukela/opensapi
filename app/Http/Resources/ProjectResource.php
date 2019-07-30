<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $remain_private = $this->categories->sum('approved_for_category_private') - $this->costs->sum('spent_private');
        $remain_donator = $this->categories-> sum('approved_for_category') - $this->costs->sum('spent_donator');
        $total_categories = $this->categories->sum('approved_for_category_private') + $this->categories->sum('approved_for_category');
        // added 10.06.2019.
        $total_private_approved = $this->categories->pluck('approved_for_category_private')->sum();
        $total_private_spent = $this->costs->pluck('spent_private')->sum();
        $total_private_remain = $total_private_approved - $total_private_spent;

        $total_donator_approved = $this->categories->pluck('approved_for_category')->sum();
        $total_donator_spent = $this->costs->pluck('spent_donator')->sum();
        $total_donator_remain = $total_donator_approved - $total_donator_spent;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'organization_id' => $this->organization_id,
            'organization_name' => User::where('id', $this->organization_id)->first()->name,
            'donator_id' => $this->donator_id,
            'donator_name' => User::where('id', $this->donator_id)->first()->name,
            'project_approved_private_categories' => number_format($this->categories->sum('approved_for_category_private'), 2,".",""),
            'project_approved_donator_categories' => number_format($this->categories->sum('approved_for_category'), 2,".",""),
            'project_spent_private' => number_format($this->costs->sum('spent_private'), 2,".",""),
            'project_spent_donator' => number_format($this->costs->sum('spent_donator'), 2,".",""),
            'project_remain_private' => number_format($remain_private, 2,".",""),
            'project_remain_donator' => number_format($remain_donator, 2,".",""),
            'project_spent_private_percent' => $total_categories > 0 ? round($this->costs->sum('spent_private') / $total_categories * 100, 2).' %' : 'n/a',
            'project_spent_donator_percent' => $this->categories->sum('approved_for_category') > 0 ? round($this->costs->sum('spent_donator') / $this->categories->sum('approved_for_category') * 100, 2).' %' : 'n/a',
            'approved_funds' => $this->approved_funds,
            'remaining_funds' => $this->remaining_funds,
            'spent_funds' => $this->spent_funds,
            'description' => $this->description,
            'categories' => NewCategoryResource::collection($this->categories),
            'costs' => NewCostResource::collection($this->costs),
            'narrative' => $this->narrative,
            //new values 10.06.2019.
            'total_private_planned' => number_format($total_private_approved, 2,".",""),
            'total_private_spent' => number_format($total_private_spent, 2,".",""),
            'total_private_remain' => number_format($total_private_remain, 2,".",""),
            'total_private_spent_percent' => isset($total_private_remain) && !empty($total_private_remain) ? round(100 - $total_private_remain * 100 / $total_private_approved, 2).' %' : '',

            'total_donator_planned' => number_format($total_donator_approved, 2,".",""),
            'total_donator_spent' => number_format($total_donator_spent, 2,".",""),
            'total_donator_remain' => number_format($total_donator_remain, 2,".",""),
            'total_donator_spent_percent' => isset($total_donator_remain) && !empty($total_donator_remain) ? round(100 - $total_donator_remain * 100 / $total_donator_approved, 2).' %' : '',

        ];
    }
}
