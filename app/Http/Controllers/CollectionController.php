<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;
use App\Charts\DashboardChart;
use App\Unit, App\Owner, App\Tenant, App\User, App\Payment, App\Bill;
use Carbon\Carbon;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;
use App\Property;
use App\Contract;
use Session;
use App\Notification;
use App\OccupancyRate;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function delinquents()
    {
        $delinquents = Tenant::leftJoin('bills', 'tenant_id','bill_tenant_id')
        ->leftJoin('payments', 'bill_id','payment_bill_id')
      ->leftJoin('contracts', 'tenant_id', 'tenant_id_foreign')
    
      ->leftJoin('units', 'unit_id_foreign', 'unit_id')
        ->selectRaw('*,sum(amount) - IFNULL(sum(payments.amt_paid),0) as balance, contracts.status as contract_status')
        ->where('property_id_foreign',Session::get('property_id'))
        ->groupBy('tenant_id')
        ->orderBy('balance', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        return view('webapp.collections.delinquents', compact('delinquents'));
    }

    public function index(Request $request, $property_id)
    {

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' opens collections page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $search = $request->search;

        Session::put(Auth::user()->id.'date', $search);

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            if($search  === null){

                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_unit_id', 'unit_id_foreign')
                
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->groupBy('payment_id')
                ->orderBy('ar_no', 'desc')
               ->get()
                ->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->payment_created)->timestamp;
                });
            }else{
            
                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_unit_id', 'unit_id_foreign')
              
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->where('payment_created', $search)
                ->groupBy('payment_id')
                ->orderBy('ar_no', 'desc')
               ->get()
                ->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->payment_created)->timestamp;
                });
    
           
            }
        }else{
            if($search  === null){

                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
                ->join('tenants', 'bill_tenant_id', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->groupBy('payment_id')
                ->orderBy('ar_no', 'desc')
               ->get()
                ->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->payment_created)->timestamp;
                });
            }else{
            
                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
                ->join('tenants', 'bill_tenant_id', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->where('payment_created', $search)
                ->groupBy('payment_id')
                ->orderBy('ar_no', 'desc')
               ->get()
                ->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->payment_created)->timestamp;
                });
    
           
            }
        }



        $property = Property::findOrFail($property_id);

       return view('webapp.collections.index', compact('collections', 'property'));
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
    public function store(Request $request, $property_id, $tenant_id){ 

        $pending_contract = Tenant::findOrFail($tenant_id)->contracts->where('status', 'pending');

        $no_of_payments = (int) $request->no_of_payments; 

         $payment_ctr = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
        ->where('property_id_foreign',Session::get('property_id'))
        ->max('ar_no') + 1;


        //add all the payment to the database.
        for($i = 1; $i<$no_of_payments; $i++){
             $explode = explode("-", $request->input('bill_no'.$i));
            DB::table('payments')->insert(
                [
                    'payment_tenant_id' => $tenant_id, 
                    'payment_bill_no' => $explode[0], 
                    'payment_bill_id' => $explode[1],
                    'amt_paid' => $request->input('amt_paid'.$i),
                    'payment_created' => $request->payment_created,
                    'ar_no' => $payment_ctr,
                    'bank_name' => $request->input('bank_name'.$i),
                    'form' => $request->input('form'.$i),
                    'check_no' => $request->input('cheque_no'.$i),
                    'date_deposited' => $request->date_deposited,
                    'created_at' => Carbon::now(),
                ]
           );
        }

        //do the action below if the tenant status is pending.
        if($pending_contract->count() > 0){
            DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('tenant_id_foreign', $tenant_id)
            ->where('units.status', 'reserved')
            ->update(
                [
                    'units.status' => 'occupied'
                ]
            );

            DB::table('contracts')
            ->where('tenant_id_foreign', $tenant_id)
            ->where('contracts.status', 'pending')
            ->update(
                [
                    'contracts.status' => 'active'
                ]
            );
                      

          
        $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

        $occupied_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'occupied')->count();

        $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

        $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);

        if($current_occupancy_rate !== $new_occupancy_rate){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }

            //retrieve all the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $property = Property::findOrFail(Session::get('property_id'));

             //retrieve all the unit information
            // $unit  = Unit::findOrFail($request->unit_tenant_id);

            //assign the value of tenant and unit information to variable data
            $data = array(
                'email' => $tenant->email_address,
                'name' => $tenant->first_name,
                'property' => Session::get('property_name'),
                'mobile' => $tenant->contact_no,
                'unit' => ' ',
                'movein_at' => ' ',
                'moveout_at' => ' ', 
            );

            if($tenant->email_address !== null){
                //send welcome email to the tenant

                Mail::send('webapp.tenants.user-generated-mail', $data, function($message) use ($data){
                $message->to($data['email']);
                $message->bcc('customercare@thepropertymanager.online');
                $message->subject('Welcome Tenant');
            });
            }

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'tenant';
            $notification->isOpen = '1';
            $notification->message = Auth::user()->name. ' moves in '. $tenant->first_name.' '.$tenant->last_name.'.';
            $notification->save();
                        
             Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
           
        }

        $tenant = Tenant::findOrFail($tenant_id);
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' records '. ($no_of_payments-1) .' payment/s made by '.$tenant->first_name.' '.$tenant->last_name.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
    
        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', ($i-1).' payment is recorded. Please use the HAND WITH DOLLAR BUTTON to add remittance for the owner.');
 

            
        
        
   
    }

    public function collect_unit_payment(Request $request, $property_id, $home_id){ 

        $no_of_payments = (int) $request->no_of_payments; 

         $payment_ctr = DB::table('units')
        ->join('payments', 'unit_id', 'payment_unit_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('ar_no') + 1;

        //add all the payment to the database.
        for($i = 1; $i<$no_of_payments; $i++){
             $explode = explode("-", $request->input('bill_no'.$i));
            DB::table('payments')->insert(
                [
                    'payment_unit_id' => $home_id, 
                    'payment_bill_no' => $explode[0], 
                    'payment_bill_id' => $explode[1],
                    'amt_paid' => $request->input('amt_paid'.$i),
                    'payment_created' => $request->payment_created,
                    'ar_no' => $payment_ctr,
                    'bank_name' => $request->input('bank_name'.$i),
                    'form' => $request->input('form'.$i),
                    'check_no' => $request->input('cheque_no'.$i),
                    'date_deposited' => $request->date_deposited,
                    'created_at' => Carbon::now(),
                ]
           );
        }

        $unit = Unit::findOrFail($home_id);
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' records '. ($no_of_payments-1) .' payment/s made by '.$unit->unit_no.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
    
            return redirect('/property/'.$property_id.'/unit/'.$home_id.'#payments')->with('success', ($i-1).' Payment is added successfully.');
 

            
        
        
   
    }

    public function export($property_id, $tenant_id, $payment_id, $payment_created){

        $tenant = Tenant::findOrFail($tenant_id);

        $room_id = Tenant::findOrFail($tenant_id)->contracts()->first()->unit_id_foreign;

        $current_room = Unit::findOrFail($room_id)->unit_no;

       $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
      ->where('bill_tenant_id', $tenant_id)
      ->where('payment_created', $payment_created)
      ->groupBy('payment_id')
      ->orderBy('ar_no', 'desc')
     ->get();



            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

        $payment = Payment::findOrFail($payment_id);
        
        $data = [
                    'tenant' => $tenant->first_name.' '.$tenant->last_name ,
                    'current_room' => $current_room,
                    'collections' => $collections,
                    'balance' => $balance,
                    'payment_date' => $payment->payment_created,
                    'payment_ar' => $payment->ar_no
                ];

            
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' exports '.$tenant->first_name.' '.$tenant->last_name.' payments.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $pdf = \PDF::loadView('webapp.collections.export', $data)->setPaper('a5', 'portrait');
  
        return $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-ar'.'.pdf');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($unit_id, $tenant_id, $payment_id)
    {

        if(Auth::user()->status === 'unregistered')
             return view('layouts.arsha.unregistered'); 

         else
             $payment = DB::table('units')
             ->join('tenants', 'unit_id', 'unit_tenant_id')
             ->join('payments', 'tenant_id', 'payment_tenant_id')
             ->where('payment_id', $payment_id)
             ->where('amt_paid','>',0)
            ->get();

         return view('treasury.show-payment', compact('payment'));
        
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
    public function destroy($property_id, $tenant_id, $payment_id)
    {

        $payment = Payment::findOrFail($payment_id);

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' deletes payment made by '.$tenant->first_name.' '.$tenant->last_name.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $bill = Payment::findOrFail($payment_id);
        $bill->payment_status = 'deleted';
        $bill->save();

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#payments')->with('success', ' Payment is deleted successfully.');
        }else{
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', ' Payment is deleted successfully.');
        }
    }

}
