<?php

namespace App\Http\Controllers\Admin;

use App\Narrative;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NarrativeRequest;

class NarrativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.narrative.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Narrative  $narrative
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $narrative = Narrative::findOrFail($id);
        return view('admin.narrative.show', compact('narrative')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Narrative  $narrative
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $narr = Narrative::findOrFail($id);

        return view('admin.narrative.edit', compact('narr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Narrative  $narrative
     * @return \Illuminate\Http\Response
     */
    public function update(NarrativeRequest $request, $id)
    {
        $narrative = Narrative::findOrFail($id);

        $narrative->contract_number = $request->contract_number;
        $narrative->project_value = $request->project_value;
        $narrative->application_area = $request->application_area;
        $narrative->authorized_person = $request->authorized_person;
        $narrative->coordinator = $request->coordinator;
        $narrative->short_description = $request->short_description;
        $narrative->accomplished_goals = $request->accomplished_goals;
        $narrative->goal_explanation = $request->goal_explanation;
        $narrative->expected_results = $request->expected_results;
        $narrative->start_date = $request->start_date;
        $narrative->end_date = $request->end_date;
        $narrative->target_group_direct = $request->target_group_direct;
        $narrative->target_group_indirect = $request->target_group_indirect;
        // new fields
        $narrative->difference_planned_involved = $request->difference_planned_involved;
        $narrative->user_selection_method = $request->user_selection_method;
        $narrative->project_realisation_problems = $request->project_realisation_problems;
        $narrative->project_realisation_partners = $request->project_realisation_partners;
        $narrative->project_promotion = $request->project_promotion;
        $narrative->other = $request->other;

        $narrative->update();

        return redirect(route('admin.projects.index'))->with('status', ['type' => 'success', 'message' => __('Narrative updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Narrative  $narrative
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $narrative = Narrative::findOrFail($id);
        $narrative->delete();

        return redirect(route('admin.projects.index'))->with('status', ['type' => 'success', 'message' => __('Narrative deleted successfully')]);

    }
}
