<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use App\Property;
use App\Tenant;
use App\Unit;
use App\Billing;
use Session;
use App\Mail\SendBillAlertToTenant;
use Illuminate\Support\Facades\Mail;
use App\Contract;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing'){

            $bills = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('billings', 'tenant_id', 'billing_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('billing_id', 'desc')
            ->groupBy('billing_id')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->billing_start)->timestamp;
            });

            $property = Property::findOrFail(Session::get('property_id'));
    
            return view('webapp.bills.bills', compact('bills', 'property'));
        }else{
            return view('website.unregistered');
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

    $updated_billing_start = $request->billing_start;
    $updated_billing_end = $request->billing_end;


  $active_tenants = DB::table('contracts')
  ->join('units', 'unit_id_foreign', 'unit_id')
  ->join('tenants', 'tenant_id_foreign', 'tenant_id')
  ->select('*', 'contracts.rent as contract_rent')
  ->where('property_id_foreign', Session::get('property_id'))
  ->where('contracts.status', 'active')
  ->get();


   //get the number of last added bills

   $current_bill_no = DB::table('contracts')
   ->join('units', 'unit_id_foreign', 'unit_id')
   ->join('tenants', 'tenant_id_foreign', 'tenant_id')
   ->join('billings', 'tenant_id', 'billing_tenant_id')
   ->where('property_id_foreign',  Session::get('property_id'))
   ->max('billing_no') + 1;

   $property = Property::findOrFail($property_id);

    return view('webapp.bills.add-rental-bill', compact('active_tenants','current_bill_no', 'updated_billing_start', 'updated_billing_end', 'property'))->with('success', 'changes have been saved!');

    }

    public function post_bills_electric(Request $request, $property_id)
    {
    
    $updated_billing_start = $request->billing_start;
    $updated_billing_end = $request->billing_end;
    $electric_rate_kwh = $request->electric_rate_kwh;

    $active_tenants = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->where('contracts.status', 'active')
    ->get();

   //get the number of last added bills

   $current_bill_no = DB::table('contracts')
   ->join('units', 'unit_id_foreign', 'unit_id')
   ->join('tenants', 'tenant_id_foreign', 'tenant_id')
   ->join('billings', 'tenant_id', 'billing_tenant_id')
   ->where('property_id_foreign',  Session::get('property_id'))
   ->max('billing_no') + 1;

   DB::table('users')
   ->where('id', Auth::user()->id)
   ->update([
        'electric_rate_kwh' => $request->electric_rate_kwh
   ]);

   $property = Property::findOrFail($property_id);

    return view('webapp.bills.add-electric-bill', compact('active_tenants','current_bill_no', 'updated_billing_start', 'updated_billing_end', 'electric_rate_kwh', 'property'))->with('success', 'changes have been saved!');


       
    }

    public function post_bills_water(Request $request, $property_id)
    {

        $updated_billing_start = $request->billing_start;
        $updated_billing_end = $request->billing_end;
        $water_rate_cum = $request->water_rate_cum;
    
    
        $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->get();
    
       //get the number of last added bills

       $current_bill_no = DB::table('contracts')
       ->join('units', 'unit_id_foreign', 'unit_id')
       ->join('tenants', 'tenant_id_foreign', 'tenant_id')
       ->join('billings', 'tenant_id', 'billing_tenant_id')
       ->where('property_id_foreign',  Session::get('property_id'))
       ->max('billing_no') + 1;
    
       DB::table('users')
       ->where('id', Auth::user()->id)
       ->update([
            'water_rate_cum' => $request->water_rate_cum
       ]);

       $property = Property::findOrFail($property_id);
    
        return view('webapp.bills.add-water-bill', compact('property','active_tenants','current_bill_no', 'updated_billing_start', 'updated_billing_end', 'water_rate_cum'))->with('success', 'changes have been saved!');
    

      
    }

    public function post_bills_surcharge(Request $request, $property_id)
    {

        $updated_billing_start = $request->billing_start;
        $updated_billing_end = $request->billing_end;

        $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->get();
    
       //get the number of last added bills

       $current_bill_no = DB::table('contracts')
       ->join('units', 'unit_id_foreign', 'unit_id')
       ->join('tenants', 'tenant_id_foreign', 'tenant_id')
       ->join('billings', 'tenant_id', 'billing_tenant_id')
       ->where('property_id_foreign',  Session::get('property_id'))
       ->max('billing_no') + 1;


       $property = Property::findOrFail($property_id);
    
        return view('webapp.bills.add-surcharge-bill', compact('property','active_tenants','current_bill_no', 'updated_billing_start', 'updated_billing_end'))->with('success', 'changes have been saved!');
    

      
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

        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('billing_no') + 1;

        for ($i=1; $i < $no_of_bills; $i++) { 
            $bill = new Billing();
            $bill->billing_tenant_id = $tenant_id;
            $bill->billing_no = $current_bill_no++;
            $bill->billing_date = $request->billing_date;
            $bill->billing_desc = $request->input('billing_desc'.$i);
            $bill->billing_start = $request->input('billing_start'.$i);
            $bill->billing_end = $request->input('billing_end'.$i);
            $bill->billing_amt = $request->input('billing_amt'.$i);
            $bill->save();

        }

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', ($i-1).' bills have been posted!');

    }

    public function post_tenant_bill(Request $request, $property_id, $tenant_id)
    {

        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('billing_no') + 1;


        for($i = 1; $i<$request->no_of_bills; $i++){
            $bill = new Billing();
            $bill->billing_tenant_id = $tenant_id;
            $bill->billing_no = $current_bill_no++;
            $bill->billing_date = $request->billing_date;
            $bill->billing_desc = $request->input('billing_desc'.$i);
            $bill->billing_start = $request->input('billing_start'.$i);
            $bill->billing_end = $request->input('billing_end'.$i);
            $bill->billing_amt = $request->input('billing_amt'.$i);
            $bill->save();

            
            $tenant = Tenant::findOrFail($tenant_id);

            $property = Property::findOrFail($property_id);

            $data = array(
                'email' =>$tenant->email_address,
                'name' => $tenant->first_name,
                'property' => $property->name,
                'amt' => $request->input('billing_amt'.$i),
                'desc' => $request->input('billing_desc'.$i),
                'start' => $request->input('billing_start'.$i),
                'end' => $request->input('billing_end'.$i),
            );

    //     if($tenant->email_address !== null){
    //         //send welcome email to the tenant
    //         Mail::send('webapp.tenants.send-bill-alert', $data, function($message) use ($data){
    //         $message->to($data['email']);
    //         $message->subject('Bill Alert');
    //     });

    // }
        }
        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', ($i-1).' bills have been posted!');
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

         $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('billing_no') + 1;
        
          $no_of_billed = 1;
            for($i = 1; $i<=$active_tenants; $i++){
               if($request->input('billing_amt'.$i) > 0){
                $no_of_billed++;
                DB::table('billings')->insert(
                    [
                        'billing_no' => $current_bill_no++,
                        'billing_tenant_id' => $request->input('billing_tenant_id'.$i),
                        'billing_date' => $request->billing_date,
                        'billing_start' => $request->input('billing_start'.$i),
                        'billing_end' => $request->input('billing_end'.$i),
                        'billing_desc' => $request->input('billing_desc'.$i),
                        'billing_amt' =>  $request->input('billing_amt'.$i)
                    ]);
                    
                    if($request->input('billing_desc'.$i) === 'Electric'){
                        $contract =  Contract::find($request->input('contract_id'.$i));
                        $contract->initial_electric =  $request->input('current_reading'.$i);
                        $contract->save();
                    }

                    if($request->input('billing_desc'.$i) === 'Water'){
                        $contract =  Contract::find($request->input('contract_id'.$i));
                        $contract->initial_water =  $request->input('current_reading'.$i);
                        $contract->save();
                    }

                    $tenant = Tenant::findOrFail($request->input('tenant_id'.$i));

                    $property = Property::findOrFail($property_id);

                    $data = array(
                        'email' =>$tenant->email_address,
                        'name' => $tenant->first_name,
                        'property' => $property->name,
                        'amt' => $request->input('billing_amt'.$i),
                        'desc' => $request->input('billing_desc'.$i),
                        'start' => $request->input('billing_start'.$i),
                        'end' => $request->input('billing_end'.$i),
                    );
        
            //     if($tenant->email_address !== null){
            //         //send welcome email to the tenant
            //         Mail::send('webapp.tenants.send-bill-alert', $data, function($message) use ($data){
            //         $message->to($data['email']);
            //         $message->subject('Bill Alert');
            //     });

            // }

                    if($request->billing_desc1 === 'Water'){
                        DB::table('tenants')
                        ->where('tenant_id', $request->input('billing_tenant_id'.$i))
                        ->where('tenant_status', 'active')
                       
                        ->update(
                                    [
                                        
                                        'previous_water_reading' => $request->input('current_reading'.$i),
                                    ]
                                );
                    }elseif($request->billing_desc1 === 'Electricity'){
                        DB::table('tenants')
                        ->where('tenant_id', $request->input('billing_tenant_id'.$i))
                        ->where('tenant_status', 'active')
                        
                        ->update(
                                    [
                                        
                                        'previous_electric_reading' => $request->input('current_reading'.$i),
                                    ]
                                );
                    }

                    DB::table('tenants')
                    ->where('tenant_id', $request->input('billing_tenant_id'.$i))
                    ->where('tenant_status', 'active')
                    ->where('tenants_note', 'new')
                    ->update(
                                [
                                    'tenants_note' => ''
                                ]
                            );
               
               }
            }
            return redirect('/property/'.$request->property_id.'/bills')->with('success', ($no_of_billed-1).' '.$request->billing_desc1.' bills have been posted!');
        
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
    public function edit($property_id, $unit_id, $tenant_id)
    {

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){
            
            //get the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $room = Unit::findOrFail($unit_id);

            $property = Property::findOrFail($property_id);
    
            //get the number of last added bills
   
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('billings', 'tenant_id', 'billing_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('billing_no') + 1;

            $balance = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id') 
            ->selectRaw('* ,billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_no')
            ->orderBy('billing_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

            return view('webapp.bills.edit-billings', compact('current_bill_no','tenant', 'room', 'balance', 'property'));  
        }else{
            return view('website.unregistered');
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

    public function post_edited_bills(Request $request, $property_id, $unit_id, $tenant_id){

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){


            $balance = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id')
            ->selectRaw('*, billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_id')
            ->orderBy('billing_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();
        
        
            for ($i=1; $i <= $balance->count(); $i++) { 
                DB::table('billings')
                ->where('billing_id', $request->input('billing_id_ctr'.$i))
                ->update
                        (
                            [
                                'billing_start' => $request->input('billing_start_ctr'.$i),
                                'billing_end' => $request->input('billing_end_ctr'.$i),
                                'billing_amt' => $request->input('billing_amt_ctr'.$i),
                            ]
                        );
               }

               DB::table('users')
               ->where('property', Auth::user()->property)
               ->update(
                       [
                           'note' => $request->note,
                       ]
                   );
          
          
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success','changes have been saved!');
        }else{
            return view('website.unregistered');
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
        //  DB::table("billings")
        //  ->join('tenants', 'billing_tenant_id', 'tenant_id')
        //  ->join('units', 'unit_tenant_id', 'unit_id')
        // ->where('unit_property', Auth::user()->property)
        // // ->whereIn('billing_desc', ['Water', 'Electricity'])
        // ->where('billing_desc', 'Rent')
        // ->delete();

        DB::table('billings')->where('billing_id', $billing_id)->delete();
        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', 'bill has been deleted!');
    }


    public function destroy_bill_from_bills_page($property_id, $billing_id)
    {
        DB::table('billings')->where('billing_id', $billing_id)->delete();
        return back()->with('success', 'bill has been deleted!');
    }
   
}