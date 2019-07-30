<?php

namespace App\Http\Controllers\Admin;

use App\Detail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailRequest;

class DetailController extends Controller
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
        return view('admin.details.create');
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

        return redirect()->route('admin.organizations.index')->with('status', ['type' => 'success', 'message' => __('Details created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        //
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

        return redirect()->route('admin.organizations.index')->with('status', ['type' => 'success', 'message' => __('Details updated successfully')]);
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
