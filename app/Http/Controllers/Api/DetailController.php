<?php

namespace App\Http\Controllers\Api;

use App\Detail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailRequest;
use App\Http\Resources\DetailResource;

class DetailController extends Controller
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
        return DetailResource::collection(Detail::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetailRequest $request)
    {
        // dd($request);
        $detail = new Detail;

        $detail->phone = $request->phone;
        $detail->address = $request->address;
        $detail->bank_account = $request->bank_account;
        $detail->pib = $request->pib;
        $detail->description = $request->description;
        $detail->user_id = $request->user_id;

        $detail->save();

        return response(['message' => 'details created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        return new DetailResource($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = Detail::findOrFail($id);
        return view('admin.details.edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $detail = Detail::findOrFail($id);
        $detail->phone = $request->phone;
        $detail->address = $request->address;
        $detail->bank_account = $request->bank_account;
        $detail->pib = $request->pib;
        $detail->description = $request->description;
        

        $detail->update();

        return response(['message' => 'details updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = Detail::findOrFail($id);

        $detail->delete();


    }
}
