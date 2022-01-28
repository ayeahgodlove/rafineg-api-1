<?php

namespace App\Http\Controllers;

use App\Models\NjangiGroup;
use Illuminate\Http\Request;

class NjangiGroupController extends Controller
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
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'minimum_savings' => 'integer|nullable',
            'maximum_savings' => 'integer|nullabe',
        ]);

        NjangiGroup::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NjangiGroup  $njangiGroup
     * @return \Illuminate\Http\Response
     */
    public function show(NjangiGroup $njangiGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NjangiGroup  $njangiGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(NjangiGroup $njangiGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NjangiGroup  $njangiGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NjangiGroup $njangiGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NjangiGroup  $njangiGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(NjangiGroup $njangiGroup)
    {
        //
    }
}