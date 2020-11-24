<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB, Auth, Carbon\Carbon;
use App\Property;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
        $events = DB::table('calendars')
        ->where('property', Auth::user()->property)
        ->get();

        $property = Property::findOrFail($property_id);

        return view('webapp.calendar.calendar', compact('events', 'property'));
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
        DB::table('calendars')
        ->insert(
            [
                'event_name' => $request->event_name,
                'property' => Auth::user()->property,
                'created_at' => Carbon::now(),
                'property_id_foreign' => $requet->property_id,
            ]
        );

        return back()->with('success', 'event has been saved!');
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
