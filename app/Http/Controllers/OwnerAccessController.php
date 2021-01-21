<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Notification;
use Auth;
use App\Owner;
use App\Property;
use DB;
use App\Bill;
use App\Unit;

class OwnerAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request, $user_id, $owner_id){

        if($request->property_id === null){
            Session::put('property_id', Session::get('property_id'));
            Session::put('mobile', Session::get('mobile'));
        }else{
            Session::put('property_id', $request->property_id);
            Session::put('mobile', $request->mobile);
        }

        if(($user_id == Auth::user()->id)){

            $owner = Owner::findOrFail($owner_id);

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'owner';
           
            $notification->message = Auth::user()->name. ' accesses his owner portal.';
            $notification->save();


            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return view('webapp.owner_access.index', compact('owner'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      
      
       
    }

    
    public function room($user_id, $owner_id){

        $rooms = DB::table('certificates')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
    
        ->where('owner_id_foreign', $owner_id)
        ->get();

       $owner = Owner::findOrFail($owner_id);

       
       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'concern';
      
       $notification->message = Auth::user()->name. ' checks his contracts.';
       $notification->save();


       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

      return view('webapp.owner_access.contracts', compact('rooms', 'owner'));
  }

  public function bill($user_id, $owner_id){

    if(($user_id == Auth::user()->id)){

        // $unit_id = Owner::findOrFail($owner_id)->units()->orderBy('unit_id', 'desc')->first()->unit_id;

        // $tenant_id = Unit::findOrFail($unit_id)->contracts()->orderBy('tenant_id_foreign', 'desc')->first()->tenant_id_foreign   ;

        // $bills = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        // ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        // ->where('bill_tenant_id', $tenant_id)
        // ->groupBy('bill_id')
        // ->orderBy('bill_no', 'desc')
        // ->havingRaw('balance > 0')
        // ->get();

        $bills = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->leftJoin('contracts', 'bill_tenant_id', 'tenant_id_foreign')
        ->leftJoin('certificates', 'contracts.unit_id_foreign', 'certificates.unit_id_foreign')
        ->leftJoin('units', 'contracts.unit_id_foreign', 'unit_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('owner_id_foreign', $owner_id)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        //->havingRaw('balance > 0')
        ->get();

       $owner = Owner::findOrFail($owner_id);

       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'bill';
      
       $notification->message = Auth::user()->name. ' checks his bills.';
       $notification->save();

       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));


        return view('webapp.owner_access.bills', compact('bills','owner'));
     }else{
         return view('layouts.arsha.unregistered');
     }
  

   
}

public function payment($user_id, $owner_id){

    if(($user_id == Auth::user()->id)){

        // $bills = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        // ->leftJoin('contracts', 'bill_tenant_id', 'tenant_id_foreign')
        // ->leftJoin('certificates', 'contracts.unit_id_foreign', 'certificates.unit_id_foreign')
        // ->leftJoin('units', 'contracts.unit_id_foreign', 'unit_id')
        // ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        // ->where('owner_id_foreign', $owner_id)
        // ->groupBy('bill_id')
        // ->orderBy('bill_no', 'desc')
        // //->havingRaw('balance > 0')
        // ->get();

         $payments = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->leftJoin('contracts', 'bill_tenant_id', 'tenant_id_foreign')
        ->leftJoin('certificates', 'contracts.unit_id_foreign', 'certificates.unit_id_foreign')
        ->leftJoin('units', 'contracts.unit_id_foreign', 'unit_id')
        ->where('owner_id_foreign', $owner_id)
        ->groupBy('payment_id')
        ->orderBy('ar_no', 'desc')
       ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->payment_created)->timestamp;
        });


       $owner = Owner::findOrFail($owner_id);

       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'payment';
      
       $notification->message = Auth::user()->name. ' checks his payments.';
       $notification->save();


       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));


        return view('webapp.owner_access.payments', compact('payments','owner'));
     }else{
         return view('layouts.arsha.unregistered');
     }
  

   
}

public function concern($user_id, $owner_id){

    if(($user_id == Auth::user()->id)){

         $concerns = DB::table('concerns')
       ->leftJoin('contracts', 'concern_tenant_id', 'contracts.tenant_id_foreign')
       ->leftJoin('certificates', 'contracts.unit_id_foreign', 'certificates.unit_id_foreign')
        ->leftJoin('users', 'concern_user_id', 'id')
        ->select('*', 'concerns.status as concern_status')
        ->where('owner_id_foreign', $owner_id)
        ->orderBy('concern_id', 'desc')
        ->get();

       $owner = Owner::findOrFail($owner_id);
        
       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'concern';
      
       $notification->message = Auth::user()->name. ' checks his concerns.';
       $notification->save();


       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

        return view('webapp.owner_access.concerns', compact('concerns','owner'));
     }else{
         return view('layouts.arsha.unregistered');
     }
  

   
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
