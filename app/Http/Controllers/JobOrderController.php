<?php

namespace App\Http\Controllers;

use App\JobOrder;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Property;

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $joborders = DB::table('job_orders')
        ->join('concerns', 'concern_id_foreign', 'concern_id')
        ->join('tenants', 'concern_tenant_id', 'tenant_id')
        ->join('personnels', 'personnel_id_foreign', 'personnel_id')

        ->where('property_id_foreign',  Session::get('property_id'))
        ->orderBy('job_orders.created_at', 'desc')
        ->get();

        $property = Property::findOrFail(Session::get('property_id'));

        return view('webapp.joborders.joborders', compact('joborders', 'property'));
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
    public function store(Request $request, $property_id, $concern_id)
    {

        $request->validate([
            'summary' => 'required',
            'personnel_id_foreign' => 'required'
        ]);

        $joborder_id = DB::table('job_orders')->insertGetId(
            [
                'concern_id_foreign'=> $concern_id,
                'personnel_id_foreign' => $request->personnel_id_foreign,
                'summary' => $request->summary,
                'created_at' => $request->created_at
            ]
            );

         return redirect('/property/'.$property_id.'/concern/'.$concern_id.'/joborder/'.$joborder_id)->with('success', 'new issue has been posted!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function show(JobOrder $jobOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOrder $jobOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOrder $jobOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOrder $jobOrder)
    {
        //
    }
}
