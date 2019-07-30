<?php

namespace App\Http\Controllers\Api;

use App\Project;
use App\Category;
use App\Narrative;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NewCategoryResource;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    // public function __construct() {

    //     $this->middleware('organization-only')->except('index', 'show');
    // }
    
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $cat = new Category;
        $cat->name = $request->name;
        $cat->direct_cost = $request->direct_cost;
        // $cat->direct_cost == 'true' ? $cat->direct_cost = 1 : $cat->direct_cost = 0;
        $cat->project_id = $request->project_id;
        $cat->approved_for_category = $request->approved_for_category;
        $cat->approved_for_category_private = $request->approved_for_category_private;

        $cat->save();

        $project = Project::findOrFail($request->project_id);
        $project->approved_funds = $project->categories->sum('approved_for_category') + $project->categories->sum('approved_for_category_private');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->save();

        return response([
            'data' => 'Category '.$cat->name.' created',
            'project_id' => $cat->project_id
            
        ], RESPONSE::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat = Category::find($id);
        // return new CategoryResource($cat);
        return new NewCategoryResource($cat);
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
    public function update(CategoryRequest $request, $id)
    {

        // for($i = 0; $i < count($request->category_id); $i++) {
            
        //             $cat = Category::findOrFail($request->category_id[$i]);
        //             $cat->approved_for_category = $request->approved_for_category[$i];
        //             $cat->name = $request->name[$i];
        //             $cat->update();
        //     }
        $cat = Category::findOrFail($id);
        $cat->approved_for_category = $request->approved_for_category;
        $cat->approved_for_category_private = $request->approved_for_category_private;
        $cat->name = $request->name;
        // $cat->direct_cost == 'true' ? $cat->direct_cost = 1 : $cat->direct_cost = 0;
        $cat->direct_cost = $request->direct_cost;
        $cat->save();

        $project = Project::findOrFail($cat->project_id);
        $project->approved_funds = $project->categories->sum('approved_for_category') + $project->categories->sum('approved_for_category_private');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->save();

        return response(['message' => 'category updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Category::findOrFail($id);
        $project = Project::findOrFail($cat->project_id);
        $cat->costs()->delete();
        $cat->delete();
        
        
        $project->approved_funds = $project->categories->sum('approved_for_category');
        $project->spent_funds = $project->costs->sum('spent');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->save();

        return response(['data' => 'Category '.$cat->name.' deleted']);
    }
}
