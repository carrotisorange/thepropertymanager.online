<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use App\Property;
use App\Tenant;
use App\Unit;
use App\Bill;
use Session;
use App\Mail\SendBillAlertToTenant;
use Illuminate\Support\Facades\Mail;
use App\Contract;
use App\Owner;
use App\Notification;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' opens bills page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing'){

          
            
        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            $bills = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('bill_id', 'desc')
            ->groupBy('bill_id')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->start)->timestamp;
            });
            
       
        }else{
            $bills = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('bill_id', 'desc')
            ->groupBy('bill_id')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->start)->timestamp;
            });
        }

            $property = Property::findOrFail(Session::get('property_id'));
    
            return view('webapp.bills.index', compact('bills', 'property'));
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

    public function post_bills_rent(Request $request, $property_id)
    {

    $updated_start = $request->start;
    $updated_end = $request->end;


  $active_tenants = DB::table('contracts')
  ->join('units', 'unit_id_foreign', 'unit_id')
  ->join('tenants', 'tenant_id_foreign', 'tenant_id')
  ->select('*', 'contracts.rent as contract_rent')
  ->where('property_id_foreign', Session::get('property_id'))
  ->where('contracts.status', 'active')
  ->get();


   //get the number of last added bills

   if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
    $current_bill_no = DB::table('units')
    ->join('bills', 'unit_id', 'bill_unit_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->max('bill_no') + 1;

}else{
    $current_bill_no = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
    ->join('bills', 'tenant_id', 'bill_tenant_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->max('bill_no') + 1;
}     
   $property = Property::findOrFail(Session::get('property_id'));

    return view('webapp.bills.add-rental-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end', 'property'))->with('success', 'Changes saved.');

    }

    public function post_bills_condodues(Request $request, $property_id)
    {

    $updated_start = $request->start;
    $updated_end = $request->end;


   $active_tenants = DB::table('contracts')
  ->join('units', 'unit_id_foreign', 'unit_id')
  ->join('tenants', 'tenant_id_foreign', 'tenant_id')
  ->select('*', 'contracts.rent as contract_rent')
  ->where('property_id_foreign', Session::get('property_id'))
  ->where('contracts.status', 'active')
  ->get();

//   $active_tenants = DB::table('certificates')
//   ->join('units', 'unit_id_foreign', 'unit_id')
//   ->join('owners', 'owner_id_foreign', 'owner_id')
//   ->where('property_id_foreign', Session::get('property_id'))
//   ->get();


   //get the number of last added bills

   if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
    $current_bill_no = DB::table('units')
    ->join('bills', 'unit_id', 'bill_unit_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->max('bill_no') + 1;

}else{
    $current_bill_no = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
    ->join('bills', 'tenant_id', 'bill_tenant_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->max('bill_no') + 1;
}     

   $property = Property::findOrFail(Session::get('property_id'));

    return view('webapp.bills.add-condodues-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end', 'property'))->with('success', 'Changes saved.');

    }

    public function post_bills_electric(Request $request, $property_id)
    {
    
    $updated_start = $request->start;
    $updated_end = $request->end;
    $electric_rate_kwh = $request->electric_rate_kwh;

    $active_tenants = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->where('contracts.status', 'active')
    ->get();

   //get the number of last added bills

   if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
    $current_bill_no = DB::table('units')
    ->join('bills', 'unit_id', 'bill_unit_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->max('bill_no') + 1;

}else{
    $current_bill_no = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
    ->join('bills', 'tenant_id', 'bill_tenant_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->max('bill_no') + 1;
}     

   DB::table('users')
   ->where('id', Auth::user()->id)
   ->update([
        'electric_rate_kwh' => $request->electric_rate_kwh
   ]);

   $property = Property::findOrFail($property_id);

    return view('webapp.bills.add-electric-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end', 'electric_rate_kwh', 'property'))->with('success', 'Changes saved.');


       
    }

    public function post_bills_water(Request $request, $property_id)
    {

        $updated_start = $request->start;
        $updated_end = $request->end;
        $water_rate_cum = $request->water_rate_cum;
    
    
        $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->get();
    
       //get the number of last added bills

       if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
        $current_bill_no = DB::table('units')
        ->join('bills', 'unit_id', 'bill_unit_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('bill_no') + 1;

    }else{
        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('bills', 'tenant_id', 'bill_tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('bill_no') + 1;
    }     
    
       DB::table('users')
       ->where('id', Auth::user()->id)
       ->update([
            'water_rate_cum' => $request->water_rate_cum
       ]);

       $property = Property::findOrFail($property_id);
    
        return view('webapp.bills.add-water-bill', compact('property','active_tenants','current_bill_no', 'updated_start', 'updated_end', 'water_rate_cum'))->with('success', 'Changes saved.');
    

      
    }

    public function post_bills_surcharge(Request $request, $property_id)
    {

        $updated_start = $request->start;
        $updated_end = $request->end;

        $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->get();
    
       //get the number of last added bills
       if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
        $current_bill_no = DB::table('units')
        ->join('bills', 'unit_id', 'bill_unit_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('bill_no') + 1;

    }else{
        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('bills', 'tenant_id', 'bill_tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('bill_no') + 1;
    }     


       $property = Property::findOrFail($property_id);
    
        return view('webapp.bills.add-surcharge-bill', compact('property','active_tenants','current_bill_no', 'updated_start', 'updated_end'))->with('success', 'Changes saved.');
    

      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function post_bill(Request $request, $property_id, $tenant_id)
    {

        $no_of_bills = $request->no_of_bills;
        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            $current_bill_no = DB::table('units')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
    
        }else{
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
        }     

        

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }else{
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }
        

    }

    public function post_tenant_bill(Request $request, $property_id, $tenant_id)
    {

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            $current_bill_no = DB::table('units')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
    
        }else{
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
        }     


        for($i = 1; $i<$request->no_of_bills; $i++){
            $bill = new Bill();
            $bill->bill_tenant_id = $tenant_id;
            $bill->bill_no = $current_bill_no++;
            $bill->date_posted = $request->date_posted;
            $bill->particular = $request->input('particular'.$i);
            $bill->start = $request->input('start'.$i);
            $bill->end = $request->input('end'.$i);
            $bill->amount = $request->input('amount'.$i);
            $bill->save();

            
            $tenant = Tenant::findOrFail($tenant_id);

            $property = Property::findOrFail($property_id);

            $data = array(
                'email' =>$tenant->email_address,
                'name' => $tenant->first_name,
                'property' => $property->name,
                'amt' => $request->input('amount'.$i),
                'desc' => $request->input('particular'.$i),
                'start' => $request->input('start'.$i),
                'end' => $request->input('end'.$i),
            );

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'bill';
            $notification->isOpen = '1';
            $notification->message = Auth::user()->name.' posts '.($request->no_of_bills-1).' bill/s to '.$tenant->first_name.' '.$tenant->last_name.'.';
            $notification->save();
    
             Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

    //     if($tenant->email_address !== null){
    //         //send welcome email to the tenant
    //         Mail::send('webapp.tenants.send-bill-alert', $data, function($message) use ($data){
    //         $message->to($data['email']);
    //         $message->subject('Bill Alert');
    //     });

    // }
        }
        
        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }else{
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }
    }

    public function post_unit_bill(Request $request, $property_id, $unit_id)
    {

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            $current_bill_no = DB::table('units')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
    
        }else{
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
        }     


        for($i = 1; $i<$request->no_of_bills; $i++){
            $bill = new Bill();
            $bill->bill_unit_id = $unit_id;
            $bill->bill_no = $current_bill_no++;
            $bill->date_posted = $request->date_posted;
            $bill->particular = $request->input('particular'.$i);
            $bill->start = $request->input('start'.$i);
            $bill->end = $request->input('end'.$i);
            $bill->amount = $request->input('amount'.$i);
            $bill->save();

            
            // $tenant = Tenant::findOrFail($tenant_id);

            // $data = array(
            //     'email' =>$tenant->email_address,
            //     'name' => $tenant->first_name,
            //     'property' => $property->name,
            //     'amt' => $request->input('amount'.$i),
            //     'desc' => $request->input('particular'.$i),
            //     'start' => $request->input('start'.$i),
            //     'end' => $request->input('end'.$i),
            // );

    //     if($tenant->email_address !== null){
    //         //send welcome email to the tenant
    //         Mail::send('webapp.tenants.send-bill-alert', $data, function($message) use ($data){
    //         $message->to($data['email']);
    //         $message->subject('Bill Alert');
    //     });

    // }
        }

        $unit = Unit::findOrFail($unit_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' posts'.($request->no_of_bills-1).' bill/s to '.$unit->unit_no;
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            return redirect('/property/'.Session::get('property_id').'/unit/'.$unit_id.'#bills')->with('success', ($i-1).' bill/s have been posted!');
    
    }

    public function store(Request $request, $property_id)
    {

        $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->select('*', 'contracts.rent as contract_rent')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->count();
        
        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            $current_bill_no = DB::table('units')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
    
        }else{
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
        }     
     
        
          $no_of_billed = 1;
            for($i = 1; $i<=$active_tenants; $i++){
               if($request->input('amount'.$i) > 0){
                $no_of_billed++;
                DB::table('bills')->insert(
                    [
                        'bill_no' => $current_bill_no++,
                        'bill_tenant_id' => $request->input('bill_tenant_id'.$i),
                        'bill_unit_id' => $request->input('bill_unit_id'.$i),
                        'date_posted' => $request->date_posted,
                        'start' => $request->input('start'.$i),
                        'end' => $request->input('end'.$i),
                        'particular' => $request->input('particular'.$i),
                        'amount' =>  $request->input('amount'.$i)
                    ]);
                    
                    if($request->input('particular'.$i) === 'Electric'){
                        $contract =  Contract::find($request->input('contract_id'.$i));
                        $contract->initial_electric =  $request->input('current_reading'.$i);
                        $contract->save();
                    }

                    if($request->input('particular'.$i) === 'Water'){
                        $contract =  Contract::find($request->input('contract_id'.$i));
                        $contract->initial_water =  $request->input('current_reading'.$i);
                        $contract->save();
                    }

                    // $tenant = Tenant::findOrFail($request->input('tenant_id'.$i));

                    // $property = Property::findOrFail($property_id);

                    // $data = array(
                    //     'email' =>$tenant->email_address,
                    //     'name' => $tenant->first_name,
                    //     'property' => $property->name,
                    //     'amt' => $request->input('amount'.$i),
                    //     'desc' => $request->input('particular'.$i),
                    //     'start' => $request->input('start'.$i),
                    //     'end' => $request->input('end'.$i),
                    // );
        
            //     if($tenant->email_address !== null){
            //         //send welcome email to the tenant
            //         Mail::send('webapp.tenants.send-bill-alert', $data, function($message) use ($data){
            //         $message->to($data['email']);
            //         $message->subject('Bill Alert');
            //     });

            // }

                    if($request->particular1 === 'Water'){
                        DB::table('contracts')
                        ->where('contract_id', $request->input('contract_id'.$i))
                        ->update(
                                    [
                                        
                                        'initial_water' => $request->input('current_reading'.$i),
                                    ]
                                );
                    }elseif($request->particular1 === 'Electricity'){
                        DB::table('contracts')
                        ->where('contract_id', $request->input('contract_id'.$i)) 
                        ->update(
                                    [
                                        
                                        'initial_electric' => $request->input('contract_id'.$i),
                                    ]
                                );
                    }

                 
               }
            }

            
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name. 'posts '.($no_of_billed-1).' '.$request->particular1.'.';
        $notification->save();
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            return redirect('/property/'.$request->property_id.'/bills')->with('success', ($no_of_billed-1).' '.$request->particular1.' bills have been posted!');
        
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
    public function edit_tenant_bills($property_id, $tenant_id)
    {

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){
            
            //get the tenant information
              $tenant = Tenant::findOrFail($tenant_id);

            $property = Property::findOrFail($property_id);
    
            //get the number of last added bills
   
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;

             $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->join('tenants', 'bill_tenant_id', 'tenant_id')
            ->join('contracts', 'tenant_id', 'tenant_id_foreign')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_tenant_id', $tenant_id)
            // ->where('bill_status', '<>', 'deleted')
            ->groupBy('bill_no')
            ->orderBy('bill_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();

            $deleted_bills = DB::table('bills')->where('bill_tenant_id', $tenant_id)->where('bill_status','<>', NULL)->sum('amount');

            if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                return view('webapp.bills.edit', compact('current_bill_no','tenant', 'balance', 'property'));  
            }else{
                return view('webapp.bills.edit_tenant_bills', compact('current_bill_no','tenant', 'balance', 'property','deleted_bills'));  
            }

        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    public function edit_occupant_bills($property_id, $unit_id)
    {

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){
      
            $unit = Unit::findOrFail($unit_id);

            $property = Property::findOrFail($property_id);
    
            //get the number of last added bills
   
            if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                $current_bill_no = DB::table('units')
                ->join('bills', 'unit_id', 'bill_unit_id')
                ->where('property_id_foreign', Session::get('property_id'))
                ->max('bill_no') + 1;
        
            }else{
                $current_bill_no = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->join('bills', 'tenant_id', 'bill_tenant_id')
                ->where('property_id_foreign', Session::get('property_id'))
                ->max('bill_no') + 1;
            }     

           
            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_unit_id', $unit_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();
          
                return view('webapp.bills.edit_occupant_bills', compact('current_bill_no','unit', 'balance', 'property'));  
          
        }else{
            return view('layouts.arsha.unregistered');
        }
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

    public function post_edited_bills(Request $request, $property_id, $tenant_id){

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){


            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->join('tenants', 'bill_tenant_id', 'tenant_id')
            ->join('contracts', 'tenant_id', 'tenant_id_foreign')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_tenant_id', $tenant_id)
            // ->where('bill_status', '<>', 'deleted')
            ->groupBy('bill_no')
            ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();



            for ($i=1; $i <= $balance->count(); $i++) { 
                 $bill = Bill::find( $request->input('billing_id_ctr'.$i));
                  $bill->start = $request->input('start_ctr'.$i);
                  $bill->end = $request->input('end_ctr'.$i);
                  $bill->particular = $request->input('particular_ctr'.$i);
                  $bill->amount = $request->input('amount_ctr'.$i);
                 $bill->save();
               }

               DB::table('users')
               ->where('id', Auth::user()->id)
               ->orWhere('lower_access_user_id',Auth::user()->id )
               ->update(
                       [
                           'note' => $request->note,
                       ]
                   );

                   $tenant = Tenant::findOrFail($tenant_id);

                    $notification = new Notification();
                    $notification->user_id_foreign = Auth::user()->id;
                    $notification->property_id_foreign = Session::get('property_id');
                    $notification->type = 'bill';
                    $notification->isOpen = '1';
                    $notification->message = Auth::user()->name.' updates '.$tenant->first_name.' '.$tenant->last_name.' bills.';
                    $notification->save();

                     Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
             
                    return back()->with('success','Changes saved.');
           
        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    
    public function update_occupant_bills(Request $request, $property_id, $unit_id){


        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){


            $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_unit_id', $unit_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();
             

            for ($i=1; $i <= $bills->count(); $i++) { 
                 $bill = Bill::find($request->input('billing_id_ctr'.$i));
                  $bill->start = $request->input('start_ctr'.$i);
                  $bill->end = $request->input('end_ctr'.$i);
                  $bill->amount = $request->input('amount_ctr'.$i);
                 $bill->save();
               }

               DB::table('users')
               ->where('id', Auth::user()->id)
               ->orWhere('lower_access_user_id',Auth::user()->id )
               ->update(
                       [
                           'note' => $request->note,
                       ]
                   );

            $unit = Unit::findOrFail($unit_id);
                   
            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'bill';
            $notification->isOpen = '1';
            $notification->message = Auth::user()->name.' updates '.$unit->unit_no.' bills.';
            $notification->save();
                        
             Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
          
                    return redirect('/property/'.$property_id.'/unit/'.$unit_id.'#bills')->with('success','Changes saved.');
           
           
        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($property_id,$tenant_id, $billing_id)
    {

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' deletes '. $tenant->first_name.' '.$tenant->last_name.' bills.';
        $notification->save();
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        
         $bill = Bill::findOrFail($billing_id);
         $bill->bill_status = 'deleted';
         $bill->save();

        return back()->with('success', 'Bill deleted successfully.');
    }

    public function export($property_id,$tenant_id)
    {

        $tenant = Tenant::findOrFail($tenant_id);

        $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $deleted_bills = DB::table('bills')->where('bill_tenant_id', $tenant_id)->where('bill_status','<>', NULL)->sum('amount');

        $room_id = Tenant::findOrFail($tenant_id)->contracts()->first()->unit_id_foreign;

        $current_room = Unit::findOrFail($room_id)->unit_no;

        $data = [
            'tenant' => $tenant->first_name.' '.$tenant->last_name ,
            'bills' => $bills,
            'deleted_bills' => $deleted_bills,
            'current_room' => $current_room,
        ];

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' exports '.$tenant->first_name.' '.$tenant->last_name.' bills.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);


        $pdf = \PDF::loadView('webapp.bills.soa', $data)->setPaper('a5', 'portrait');

    
                    
      
        return $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-soa'.'.pdf');
    }

    public function export_occupant_bills($property_id,$unit_id)
    {
        
         $bills = Bill::leftJoin('payments', 'bills.bill_no', '=', 'payments.payment_bill_no')
        ->join('units', 'bill_unit_id', 'unit_id')
        ->selectRaw('*, bills.amount - IFNULL(sum(payments.amt_paid),0) as balance')
        ->where('unit_id', $unit_id)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $unit_no = Unit::findOrFail($unit_id)->unit_no;

        $tenant_id = Unit::findOrFail($unit_id)->contracts()->first()->tenant_id_foreign;

        $occupant = Tenant::findOrFail($tenant_id);

        $data = [
            'occupant' => $occupant->first_name.' '.$occupant->last_name,
            'bills' => $bills,
            'unit' => $unit_no,
        ];

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->message = Auth::user()->name.' updates '.$unit_no.' bills.';
        $notification->save();


        $pdf = \PDF::loadView('webapp.bills.soa-unit', $data)->setPaper('a5', 'portrait');
        return $pdf->download(Carbon::now().'-'.$unit_no.'-soa'.'.pdf');
    }
    
    public function restore_bill($property_id, $billing_id)
    {
        $bill = Bill::findOrFail($billing_id);
        $bill->bill_status = NULL;
        $bill->save();

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' restores bill '. $billing_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return back()->with('success', 'Bill restored successfully.');
    }


    public function destroy_bill_from_bills_page($property_id, $billing_id)
    {
        $bill = Bill::findOrFail($billing_id);
        $bill->bill_status = 'deleted';
        $bill->save();

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' archives bill '. $billing_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return back()->with('success', 'Bill archived successfully.');
    }
   
}