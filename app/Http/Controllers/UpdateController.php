<?php

namespace App\Http\Controllers;

use App\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }
    
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
        $request->validate([
            'link' => 'required',
            'description' => 'required',
            'feature' => 'required',
        ]);

        $update = new Update();
        $update->link = $request->link;
        $update->description = $request->description;
        $update->feature = $request->feature;
        $update->save();

        return back()->with('success', 'Update posted successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Updates  $updates
     * @return \Illuminate\Http\Response
     */
    public function show(Updates $updates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Updates  $updates
     * @return \Illuminate\Http\Response
     */
    public function edit(Updates $updates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Updates  $updates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Updates $updates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Updates  $updates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Updates $updates)
    {
        //
    }
}
