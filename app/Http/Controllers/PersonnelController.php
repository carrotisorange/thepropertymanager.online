<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB, Auth;
use App\Property;
use Carbon\Carbon;
use Session;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('current-page', 'employees');

     $employees = DB::table('users_properties_relations')
               ->join('properties', 'property_id_foreign', 'property_id')
               ->join('users', 'user_id_foreign', 'id')
               ->select('*', 'properties.name as property')
               ->where('lower_access_user_id', Auth::user()->id)
               ->orWhere('id', Auth::user()->id)  
               ->get();

       $personnels = Property::findOrFail(Session::get('property_id'))->personnels;

       return view('webapp.personnels.index', compact('personnels', 'employees'));
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

        return back()->with('success',  'Personnel added successfully.');
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
    public function destroy($property_id, $personnel_id)
    {
        DB::table('personnels')->where('personnel_id', $personnel_id)->delete();

        return back()->with('success', 'Personnel has been deleted!');
    }
}
