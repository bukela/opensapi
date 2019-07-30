<?php

namespace App\Http\Controllers\Api;

use App\Project;
use App\Narrative;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return ProjectCollection::collection(Project::paginate(10));
        $search = $request->get('search');

        if(isset($search)) {

            
            return ProjectCollection::collection(Project::where('title', 'like', "%{$search}%")->paginate(10));

        } else {

            return ProjectCollection::collection(Project::orderBy('created_at', 'desc')->paginate(10));

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {



        $user = auth('api')->user();
        $project = new Project;
        $project->title = $request->title;
        $project->donator_id = $request->donator_id;
        // $project->approved_funds = $request->approved_funds;
        $project->description = $request->description;

        if ($user->role_id == 3) {
            $project->organization_id = $user->id;
        }

        if ($user->role_id == 4) {
            $id = $user->organizations->first()->id;
            $organization = User::findOrFail($id);
            $project->organization_id = $organization->id;
        }
        $project->save();

        $log = new LogController();
        // $log->createLog("created project named $project->title", 'project');
        $log->createLog("kreiran projekt : $project->title", 'projekt');

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
        $narrative->other = $request->other;

        $narrative->save();

        return response([
            'data' => new ProjectResource($project)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->title = $request->title;
        // $project->organization_id = $request->organization_id;
        $project->donator_id = $request->donator_id;
        $project->description = $request->description;

        $project->update();

        $log = new LogController();
        // $log->createLog("created project named $project->title", 'project');
        $log->createLog("izmenjen projekt : $project->title", 'projekt');

        return response(['data' => 'Project '.$project->title.' updated'],RESPONSE::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->costs()->delete();
        $project->categories()->delete();
        $project->delete();

        $log = new LogController();
        // $log->createLog("created project named $project->title", 'project');
        $log->createLog("obrisan projekt : $project->title", 'projekt');

        return response(['data' => 'Project '.$project->title.' deleted.']);
        
    }

    public function search(Request $request)
    {

        $search = $request->get('search');

        return ProjectCollection::collection(Project::where('title', 'like', "%{$search}%")->paginate(10));
        
        
    }
}
