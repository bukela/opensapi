<?php

namespace App\Http\Controllers;

use App\CostType;
use Illuminate\Http\Request;

class CostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costTypes = CostType::all()->toArray();
        $tree = $this->buildTree($costTypes);

        return $tree;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function show(CostType $costType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function edit(CostType $costType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostType $costType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostType $costType)
    {
        //
    }

    private function buildTree(array $elements, $parentId = 0) {
        $branch = array();
    
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
    
        return $branch;
    }
}
