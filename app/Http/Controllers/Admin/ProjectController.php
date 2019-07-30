<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Donator;
use App\Project;
use App\Category;
use App\Narrative;
use App\Organization;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', false);
        $order = $request->get('order', 'title');
        $sort = $request->get('sort', 'asc');

        $projects = Project::join('users', 'projects.organization_id', '=', 'users.id')->orderBy($order, $sort)->select('projects.*')->paginate(10);
        
        return view('admin.projects.index', compact('projects', 'filter', 'order', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = User::whereHas('role', function($q){
            $q->where('name', 'organization');
        })->get();

        // $organizations = Organization::all();

        $donators = User::whereHas('role', function($q){
            $q->where('name', 'donator');
        })->get();
        // $donators = Donator::all();

        $categories = Category::all();

        return view('admin.projects.create', compact('organizations', 'donators', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {

        $project = new Project;
        $project->title = $request->title;
        $project->organization_id = $request->organization_id;
        $project->donator_id = $request->donator_id;
        $project->approved_funds = $request->approved_funds;
        $project->description = $request->description;
        $project->save();

        $narrative = new Narrative;

        $narrative->project_id = $project->id;
        $narrative->organization_name = $project->organization->name;
        $narrative->project_title = $project->title;
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
        //new fields
        $narrative->difference_planned_involved = $request->difference_planned_involved;
        $narrative->user_selection_method = $request->user_selection_method;
        $narrative->project_realisation_problems = $request->project_realisation_problems;
        $narrative->project_realisation_partners = $request->project_realisation_partners;
        $narrative->project_promotion = $request->project_promotion;
        $narrative->other = $request->other;

        $narrative->save();
        
// dd($request);
        // $combined = array_combine($request->category_id,$request->approved_for_category);
        // // dd($combined);
        // foreach ($combined as $cat => $funds) {

        //         $project->categories()->attach($cat,['approved_for_category' => $funds]);

        // }
        // $project->categories()->attach($request->category_id,['approved_for_category' => $request->approved_for_category]);

        $log = new LogController();
        // $log->createLog("created project named $project->title", 'project');
        $log->createLog("kreiran projekt : $project->title", 'projekt');

        return redirect(route('admin.projects.index'))
            ->with('status', ['type' => 'success', 'message' => __('Project created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('costs','categories')->findOrFail($id);

        return view('admin.reports.report', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $project = Project::with('categories')->findOrFail($id);
        $organizations = User::whereHas('role', function($q){
            $q->where('name', 'organization');
        })->get();

        // $organizations = Organization::all();

        $donators = User::whereHas('role', function($q){
            $q->where('name', 'donator');
        })->get();

        // $categories = Category::all();

        return view('admin.projects.edit', compact('organizations','donators','project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->title = $request->title;
        $project->organization_id = $request->organization_id;
        $project->donator_id = $request->donator_id;
        $project->description = $request->description;
        
        // for($i = 0; $i < count($request->category_id); $i++) {
        
        //         $cat = Category::findOrFail($request->category_id[$i]);
        //         $cat->approved_for_category = $request->approved_for_category[$i];
        //         $cat->name = $request->name[$i];
        //         $cat->update();
        // }

        $project->save();

        // $sync_data = [];
        //     for($i = 0; $i < count($request->category_id); $i++) {
        //         $sync_data[$request->category_id[$i]] = ['approved_for_category' => $request->approved_for_category[$i]];
        //     }

        // $project->categories()->sync($sync_data);


        $log = new LogController();
        // $log->createLog("edited project named $project->title", 'project');
        $log->createLog("izmenjen projekt : $project->title", 'projekt');

        return redirect(route('admin.projects.index'))->with('status', ['type' => 'success', 'message' => __('Project updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->costs()->delete();
        $project->categories()->delete();
        $project->delete();


        $log = new LogController();
        // $log->createLog("deleted project named $project->title", 'project');
        $log->createLog("obrisan projekt : $project->title", 'projekt');

        return redirect(route('admin.projects.index'))->with('status', ['type' => 'success', 'message' => __('Project deleted successfully')]);;
    }

    public function categories($id) {
        $project = Project::findOrFail($id);
        return view('admin.projects.cat-edit', compact('project'));
    }

    public function search(Request $request)
    {

        // $projects = Project::where('title', 'like', "%{$request->search}%")
        //     ->paginate(20);

        $projects = Project::whereHas('donator', function ($query) use ($request) {
            $query->where('name' ,'like', "%{$request->search}%");
        })
        ->orWhereHas('organization', function ($query) use ($request) {
            $query->where('name' ,'like', "%{$request->search}%");
        })
        ->orWhere('title', 'like', "%{$request->search}%")
        ->paginate(20);
        


        $filter = $request->get('filter', false);
        $order = $request->get('order', 'name');
        $sort = $request->get('sort', 'asc');
        
        return view('admin.projects.index', compact('projects','filter','order','sort'));
    }

    public function pdf($id) {
        
        $project = Project::with('costs','categories')->findOrFail($id);
        // dd($project);
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.reports.pdf_report', compact('project'));
        // dd($pdf);
        return $pdf->download('report_'.$project->title.'.pdf');
    }
}
