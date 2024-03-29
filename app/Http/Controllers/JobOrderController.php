<?php

namespace App\Http\Controllers;

use App\JobOrder;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Property;
use App\Personnel;
use App\Concern;    
use App\Notification;
use Auth;

class JobOrderController extends Controller
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
        Session::put('current-page', 'job-orders');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'joborder';
        
        $notification->message = Auth::user()->name.' opens joborders page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

          $joborders = DB::table('job_orders')
        ->join('concerns', 'concern_id_foreign', 'concern_id')
        ->join('tenants', 'concern_tenant_id', 'tenant_id')
        ->join('personnels', 'personnel_id_foreign', 'personnel_id')
        ->select('*', 'job_orders.created_at as created_at', 'job_orders.status as joborder_status')

        ->where('property_id_foreign',  Session::get('property_id'))
        ->orderBy('job_orders.created_at', 'desc')
        ->get();

        return view('webapp.joborders.index', compact('joborders'));
    }

    public function inventory($property_id, $joborder_id){

        $personnels = Property::findOrFail($property_id)->personnels;

        $joborder = JobOrder::findOrFail($joborder_id);

        $personnel = DB::table('job_orders')
        ->join('personnels', 'personnel_id_foreign', 'personnel_id')
        ->select('*', 'job_orders.created_at as created_at', 'job_orders.status as joborder_status')

        ->where('property_id_foreign',  Session::get('property_id'))
        ->orderBy('job_orders.created_at', 'desc')
        ->get();

        
        return view('webapp.joborders.inventory', compact('joborder','personnel', 'personnels'));
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

        if($request->summary === null || $request->personnel_id_foreign === null){
            return back()->with('danger', 'Please select a personnel and provide the summary of the joborder.');
        }

        $joborder_id = DB::table('job_orders')->insertGetId(
            [
                'concern_id_foreign'=> $concern_id,
                'personnel_id_foreign' => $request->personnel_id_foreign,
                'summary' => $request->summary,
                'created_at' => $request->created_at
            ]
            );

            $personnel = Personnel::findOrFail($request->personnel_id_foreign);

            $concern = Concern::findOrFail($request->concern_id);

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'joborder';
            
            $notification->message =  Auth::user()->name.' files a job order and assigns it to '.$personnel->personnel_name.'.';
            $notification->save();

         return redirect('/property/'.$property_id.'/joborders')->with('success', 'job order has been filed!');
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
