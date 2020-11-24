<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB, Auth;
use App\Property;
use Carbon\Carbon;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {

       $personnels = Property::findOrFail($property_id)->personnels;

       $property = Property::findOrFail($property_id);

       return view('webapp.personnels.personnels', compact('personnels', 'property'));
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
    public function store(Request $request, $property_id)
    {
        DB::table('personnels')->insert([
            'personnel_name' => $request->personnel_name,
            'personnel_contact_no' => $request->personnel_contact_no,
            'personnel_availability' => 'open',
            'personnel_type' => $request->personnel_type,
            'property_id_foreign' => $property_id,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('success',  'new personnel has been saved!');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
