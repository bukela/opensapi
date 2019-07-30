<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\Category;
use App\Narrative;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
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
        return view('admin.categories.create');
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
        // $cat->direct_cost == 'on' ? $cat->direct_cost = 1 : $cat->direct_cost = 0;
        $cat->project_id = $request->project_id;
        $cat->approved_for_category = $request->approved_for_category;
        $cat->approved_for_category_private = $request->approved_for_category_private;

        $cat->save();

        $log = new LogController();
        $log->createLog("kreirana kategorija : $cat->name, za projekt : ".$cat->project->title, 'kategorija');

        $project = Project::findOrFail($request->project_id);
        $project->approved_funds = $project->categories->sum('approved_for_category') + $project->categories->sum('approved_for_category_private');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->save();

        // return redirect()->back();
        return redirect('/admin/project/edit/categories/'.$request->project_id)->with('status', ['type' => 'success', 'message' => __('Category created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        return view('admin.categories.edit', compact('cat'));

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
        
        // $request->validate([
        //     'name' => 'required',
        //     // 'direct_cost' => 'required|sometimes',
        //     // 'approved_for_category' => 'numeric|nullable',
        //     'approved_for_category' => 'numeric|nullable'
        // ]);
       
        // for($i = 0; $i < count($request->category_id); $i++) {
            
        //             $cat = Category::findOrFail($request->category_id[$i]);
        //             $cat->approved_for_category = $request->approved_for_category[$i];
        //             $cat->name = $request->name[$i];
        //             $cat->save();
                
        //     }
        $cat = Category::findOrFail($id);
        $cat->approved_for_category = $request->approved_for_category;
        $cat->approved_for_category_private = $request->approved_for_category_private;
        $cat->name = $request->name;
        // $cat->direct_cost == 'on' ? $cat->direct_cost = 1 : $cat->direct_cost = 0;
        $cat->direct_cost = $request->direct_cost;
        $cat->save();

        $log = new LogController();
        $log->createLog("izmenjena kategorija : $cat->name, za projekt : ".$cat->project->title, 'kategorija');

        $project = Project::findOrFail($cat->project_id);
        $project->approved_funds = $project->categories->sum('approved_for_category') + $project->categories->sum('approved_for_category_private');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->save();
        
        return redirect(route('admin.project-cat.update',$cat->project_id))->with('status', ['type' => 'success', 'message' => __('Category updated successfully')]);
        // return redirect()->with('status', ['type' => 'success', 'message' => 'Categories updated successfully.']);
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
        $cat->delete();
        $cat->costs()->delete();

        $log = new LogController();
        $log->createLog("obrisana kategorija : $cat->name, za projekt : ".$cat->project->title, 'kategorija');
        
        $project->approved_funds = $project->categories->sum('approved_for_category');
        $project->spent_funds = $project->costs->sum('spent');
        $project->remaining_funds = $project->approved_funds - $project->spent_funds;
        $project->save();

        $narrative = Narrative::findOrFail($project->narrative->id);
        $narrative->project_funds = $project->approved_funds;
        $narrative->save();
        
        return redirect()->back();
    }
}
