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
use App\User;
use Carbon\Carbon;
use Hash;
use App\Remittance;

class OwnerAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request, $user_id, $owner_id){

        Session::put('current-page', 'dashboard');

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

    
    public function update_profile(Request $request, $user_id, $owner_id){

        if(($user_id == Auth::user()->id)){
          
        if($request->password === null){


            DB::table('users')
            ->where('id', $user_id)
            ->update(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'updated_at' => Carbon::now()
                      
                    ]
                );
            
            DB::table('owners')
            ->where('owner_id', $owner_id)
            ->update([
                'mobile'=> $request->contact_no
            ]);

            
           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'user';
           
           $notification->message = Auth::user()->name. ' updates his profile.';
           $notification->save();


           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return back()->with('success', 'Changes saved.');
        }else{
            DB::table('users')
            ->where('id', $user_id)
            ->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'updated_at' => Carbon::now(),
                ]
                );
            
                DB::table('owners')
                ->where('owner_id', $owner_id)
                ->update([
                    'mobile'=> $request->contact_no
                ]);

                
           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'user';
           
           $notification->message = Auth::user()->name. ' updates his password.';
           $notification->save();

  
           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));
            
                if(Auth::user()->user_type != 'manager'){
                    Auth::logout();
                    return redirect('/login')->with('success', 'New password has been saved!');
                }else{
                    return back()->with('success', 'Changes saved.');
                }
            
          
        } 

            return view('webapp.tenant_access.profile', compact('tenant','user'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    
    public function room($user_id, $owner_id){

        Session::put('current-page', 'rooms');

        $rooms = DB::table('certificates')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
    
        ->where('owner_id_foreign', $owner_id)
        ->get();

       $owner = Owner::findOrFail($owner_id);

       
       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'room';
       
       $notification->message = Auth::user()->name. ' checks his rooms.';
       $notification->save();


       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

      return view('webapp.owner_access.rooms', compact('rooms', 'owner'));
  }

  public function remittance($user_id, $owner_id){

    Session::put('current-page', 'remittances');

    $remittances = DB::table('units')
    ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
    ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
    ->join('owners', 'owner_id_foreign', 'owner_id')
    ->select('*', 'remittances.created_at as dateRemitted')
    ->where('owner_id',$owner_id)
    ->get();

    $owner = Owner::findOrFail($owner_id);

   $notification = new Notification();
   $notification->user_id_foreign = Auth::user()->id;
   $notification->property_id_foreign = Session::get('property_id');
   $notification->type = 'remittance';
   
   $notification->message = Auth::user()->name. ' checks his remittances.';
   $notification->save();


   Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

  return view('webapp.owner_access.remittances', compact('remittances', 'owner'));
}

public function financial($user_id, $owner_id){

    Session::put('current-page', 'financials');

    $owner = Owner::findOrFail($owner_id);

     $remittances = DB::table('units')
        ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
        ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->where('owner_id',$owner_id)
        ->groupBy('remittance_id')
        ->get();

       $bills = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->leftJoin('contracts', 'bill_tenant_id', 'tenant_id_foreign')
        ->leftJoin('certificates', 'contracts.unit_id_foreign', 'certificates.unit_id_foreign')
        ->leftJoin('units', 'contracts.unit_id_foreign', 'unit_id')
        ->where('owner_id_foreign', $owner_id)
        ->limit(1)
        ->get('contracts.rent');

      $expenses = DB::table('units')
        ->join('expenses', 'unit_id', 'expenses.unit_id_foreign')
        ->join('certificates', 'expenses.unit_id_foreign', 'certificates.unit_id_foreign')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->selectRaw('*, IFNULL(sum(expense_amt),0) as total_expenses')
        ->where('owner_id',$owner_id)
        ->groupBy('remittance_id_foreign')
        ->get();

   $notification = new Notification();
   $notification->user_id_foreign = Auth::user()->id;
   $notification->property_id_foreign = Session::get('property_id');
   $notification->type = 'financial';
   
   $notification->message = Auth::user()->name. ' checks his financials.';
   $notification->save();

   Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

  return view('webapp.owner_access.financials', compact('owner', 'bills', 'expenses', 'remittances'));
}

public function contracts($user_id, $owner_id, $room_id){

    Session::put('current-page', 'rooms');

   $contracts = Unit::findOrFail($room_id)->contracts;

   $room = Unit::findOrFail($room_id);

   $owner = Owner::findOrFail($owner_id);

  $notification = new Notification();
  $notification->user_id_foreign = Auth::user()->id;
  $notification->property_id_foreign = Session::get('property_id');
  $notification->type = 'contract';
  
  $notification->message = Auth::user()->name. ' checks his contracts in room'. $room->unit_no;
  $notification->save();

  Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

 return view('webapp.owner_access.contracts', compact('owner', 'contracts', 'room'));
}

public function expense($user_id, $owner_id, $remittance_id){

    Session::put('current-page', 'remittances');

     $expenses = DB::table('units')
    ->join('expenses', 'unit_id', 'expenses.unit_id_foreign')
    ->join('certificates', 'expenses.unit_id_foreign', 'certificates.unit_id_foreign')
    ->select('*', 'expenses.created_at as dateCreated')
    ->where('remittance_id_foreign',$remittance_id)
    ->orderBy('expenses.created_at')
    ->get();

     $remittance = Remittance::findOrFail($remittance_id);

    $owner = Owner::findOrFail($owner_id);

   $notification = new Notification();
   $notification->user_id_foreign = Auth::user()->id;
   $notification->property_id_foreign = Session::get('property_id');
   $notification->type = 'expense';
   
   $notification->message = Auth::user()->name. ' checks his expenses.';
   $notification->save();


   Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

  return view('webapp.owner_access.expenses', compact('expenses', 'owner', 'remittance'));
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

    Session::put('current-page', 'concerns');

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

public function profile($user_id, $owner_id){

    if(($user_id == Auth::user()->id)){

        $user = User::findOrFail($user_id);

        $owner = Owner::findOrFail($owner_id);

        
       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'user';
       
       $notification->message = Auth::user()->name. ' checks his profile.';
       $notification->save();

       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

        return view('webapp.owner_access.profile', compact('owner','user'));
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
