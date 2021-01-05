<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;
use App\Unit;
use App\Property;
use DB;
use App\Tenant;
use Auth;
use Uuid;
use Carbon\Carbon;
use App\Bill;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Notification;
use App\OccupancyRate;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $property_id, $tenant_id)
    {

        $request->validate([
            'unit_id' => 'required'
        ]);

        $unit = Unit::findOrFail($request->unit_id);

        $tenant = Tenant::findOrFail($tenant_id);

        $property = Property::findOrFail($property_id);

        $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('lower_access_user_id', Auth::user()->id)
        ->orWhere('id', Auth::user()->id)  
        ->orderBy('users.name')
        ->get();

         $units = Property::findOrFail($property_id)
        ->units
        ->whereIn('status',['vacant', 'reserved']);

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

        return view('webapp.contracts.create', compact('tenant','unit', 'property', 'current_bill_no', 'users', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id,$unit_id,$tenant_id)
    {

        
        $no_of_bills = $request->no_of_items;

    
        if($no_of_bills === null){
          $status = 'active';
        }else{
          $status = 'pending';
        }

        
        $tenant_unique_id = Uuid::generate()->string;

            DB::table('contracts')->insert(
                    [
                        'contract_id' => Uuid::generate()->string,
                        'unit_id_foreign' => $unit_id,
                        'tenant_id_foreign' => $tenant_id,
                        'referrer_id_foreign' => $request->referrer_id,
                        'form_of_interaction' => $request->form_of_interaction,
                        'rent' => $request->rent,
                        'status' => $status,
                        'movein_at' => $request->movein_at,
                        'moveout_at' => $request->moveout_at,
                        'discount' => $request->discount,
                        'term' => $request->term,
                        'number_of_months' => $request->number_of_months,
                        'created_at' => $request->movein_at,
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


                    if($no_of_bills === null){
                        DB::table('units')
                        ->where('unit_id', $unit_id)
                        ->update(
                            [
                                'status' => 'occupied'
                            ]
                        );
                    }else{
                        DB::table('units')
                        ->where('unit_id', $unit_id)
                        ->update(
                            [
                                'status' => 'reserved'
                            ]
                        );
                    }
    

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
            
                    for ($i=1; $i < $no_of_bills; $i++) { 
                        $bill = new Bill();
                        $bill->bill_tenant_id = $tenant_id;
                        $bill->bill_no = $current_bill_no++;
                        $bill->date_posted = $request->movein_at;
                        $bill->particular = $request->input('particular'.$i);
                        $bill->start = $request->movein_at;
                        $bill->end = $request->moveout_at;
                        $bill->amount = $request->input('amount'.$i);
                        $bill->save();
                    }

                    $tenant = Tenant::findOrFail($tenant_id);
                    $unit = Unit::findOrFail($unit_id);

                    $notification = new Notification();
                    $notification->user_id_foreign = Auth::user()->id;
                    $notification->property_id_foreign = Session::get('property_id');
                    $notification->type = 'contract';
                    $notification->message = $tenant->first_name.' '.$tenant->last_name.' entered another contract in '.$unit->unit_no.'.';
                    $notification->save();
                    
                    Session::put('notifications', Property::findOrFail($property_id)->unseen_notifications);

            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'#contracts')->with('success', 'new contract has been added!');
       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $tenant_id, $contract_id)
    {

         $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $tenant = Tenant::findOrFail($tenant_id);

        $contract = Contract::findOrFail($contract_id);

        $property = Property::findOrFail($property_id);

        return view('webapp.contracts.show', compact('contract', 'property', 'balance', 'tenant'));
    }

    public function moveout_get(Request $request, $property_id, $tenant_id, $contract_id){

        $tenant = Tenant::findOrFail($tenant_id);

        $contract = Contract::findOrFail($contract_id);

        $property = Property::findOrFail($property_id);

        return view('webapp.contracts.moveout', compact('tenant', 'property', 'contract'));
    }

    public function moveout_post(Request $request, $property_id, $unit_id, $tenant_id, $contract_id){      

        $tenant = Tenant::findOrFail($tenant_id);

        $unit = Unit::findOrFail($unit_id);

         DB::table('contracts')
        ->where('contract_id', $contract_id)
        ->update([
            'status' => 'inactive',
        ]);

        $no_of_active_tenants_in_the_unit = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->where('unit_id', $unit_id)
        ->where('contracts.status', 'active')
        ->count();

        if($no_of_active_tenants_in_the_unit <= 0){
            DB::table('units')
            ->where('unit_id', $unit_id)
            ->update([
                'status' => 'dirty'
            ]);
        }

        //update the occupancy rate
               
        $units = DB::table('units')->where('property_id_foreign', Session::get('property_id'))->where('status','<>','deleted')->count();

        $occupied_units = DB::table('units')->where('property_id_foreign', Session::get('property_id'))->where('status', 'occupied')->count();
  
        DB::table('occupancy_rate')
              ->insert(
                          [
                              'occupancy_rate' => ($occupied_units/$units) * 100,
                              'property_id_foreign' => Session::get('property_id'),
                             'occupancy_date' => Carbon::now(),'created_at' => Carbon::now(),
                          ]
                      );


                      $property = Property::findOrFail(Session::get('property_id'));
             
                     $contract = Contract::findOrFail($contract_id);

                      $unit = Unit::findOrFail($unit_id);

                      $data = array(
                        'email' => $tenant->email_address,
                        'tenant' => $tenant->first_name.' '.$tenant->last_name,
                        'property' => $property->name,
                        'unit' => $unit->building.' '.$unit->unit_no,
                        'actual_moveout_at' => $contract->actual_moveout_at,
                    );
        
                // if($tenant->email_address !== null){
                //     //send welcome email to the tenant
        
                //     Mail::send('webapp.tenants.send-request-moveout-mail', $data, function($message) use ($data){
                //     $message->to($data['email']);
                //     $message->bcc(['landleybernardo@thepropertymanager.online','customercare@thepropertymanager.online']);
                //     $message->subject('Contract Termination');
                // });
                // }
        
                $notification = new Notification();
                $notification->user_id_foreign = Auth::user()->id;
                $notification->property_id_foreign = Session::get('property_id');
                $notification->type = 'contract';
                $notification->message = $tenant->first_name.' '.$tenant->last_name.' has been moved out of the property! ';
                $notification->save();
                            
                 Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

            $pdf = \PDF::loadView('webapp.tenants.gatepass', $data)->setPaper('a4', 'portrait');
      
             return $pdf->download($tenant->first_name.' '.$tenant->last_name.'.pdf');
    
        //return redirect('/units/'.$request->unit_tenant_id.'/tenants/'.$request->tenant_id)->with('success','tenant has been moved out!');
    }


    public function preterminate_post(Request $request, $property_id, $tenant_id, $contract_id){

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
        
        $no_of_charges = (int) $request->no_of_charges; 

        $contract = Contract::findOrFail($contract_id);

        DB::table('contracts')
        ->where('contract_id', $contract_id)
        ->update(
            [
                'terminated_at' => Carbon::now(),
                'moveout_reason' => $request->moveout_reason,
                'actual_moveout_at' => $request->actual_moveout_at,
                'status' => 'preparing to moveout'
            ]
        );


        DB::table('units')
        ->where('unit_id', $contract->unit_id_foreign)
        ->update([
            'status' => 'vacant'
        ]);


        //get the number of last added bills


        for($i = 1; $i<$no_of_charges; $i++){
            DB::table('bills')->insert(
                [
                    'bill_tenant_id' => $tenant_id,
                    'bill_no' => $current_bill_no++,
                    'date_posted' => $request->actual_moveout_at,
                    'particular' =>  $request->input('particular'.$i),
                    'amount' =>  $request->input('amount'.$i)
                ]);
        }
         $tenant = Tenant::findOrFail($tenant_id);

         $property = Property::findOrFail(Session::get('property_id'));

         $contract = Contract::findOrFail($contract_id);
            // $unit = Unit::findOrFail($unit_id);

         
            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('amount - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('bill_tenant_id', $tenant->tenant_id)
            ->havingRaw('balance > 0')
            ->get();

            $data = array(
                'email' => $tenant->email_address,
                'name' => $tenant->first_name,
                'property' => $property->name,
                'balance' => $balance,
                'reason' => $contract->moveout_reason,
                'actual_moveout_at' => $contract->actual_moveout_at,
            );

        if($tenant->email_address !== null){
            //send welcome email to the tenant

            Mail::send('webapp.tenants.send-request-moveout-mail', $data, function($message) use ($data){
            $message->to($data['email']);
            $message->bcc(['landleybernardo@thepropertymanager.online','customercare@thepropertymanager.online']);
            $message->subject('Contract Termination');
        });
        }

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'contract';
        $notification->message = $tenant->first_name.' '.$tenant->last_name.' contract has been terminated! ';
        $notification->save();
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id)->with('success', 'Contract has been terminated! Continue with the moveout.');
    }

    public function preterminate($property_id, $tenant_id, $contract_id)
    {

        $contract = Contract::findOrFail($contract_id);

        $property = Property::findOrFail($property_id);

        $tenant = Tenant::findOrFail($tenant_id);

        return view('webapp.contracts.preterminate', compact('contract', 'property', 'tenant'));
    }

    public function extend($property_id, $tenant_id, $contract_id)
    {
        $contract = Contract::findOrFail($contract_id);

        $property = Property::findOrFail($property_id);

        $tenant = Tenant::findOrFail($tenant_id);

        return view('webapp.contracts.extend', compact('contract', 'property', 'tenant'));
    }

    public function extend_post(Request $request, $property_id, $tenant_id, $contract_id)
    {
        
        if($request->moveout_at > 5){
            $term = 'Long Term';
           }else{
            $term = 'Short Term';
           }
    

     $unit_id = Contract::findOrFail($contract_id)->unit_id_foreign;

     $rent = Unit::findOrFail($unit_id)->rent;

        // if($request->movein_at > 1 ){
        //     return back()->with('danger', 'The length of contract should be atleast 1 month.');
        // }
        DB::table('contracts')->insert(
            [
                'contract_id' => Uuid::generate()->string,
                'unit_id_foreign' => $unit_id,
                'tenant_id_foreign' => $tenant_id,
                'referrer_id_foreign' => $tenant_id,
                'form_of_interaction' => 'Renewal',
                'rent' => $rent,
                'status' => 'active',
                'movein_at' => $request->movein_at,
                'moveout_at' => Carbon::parse($request->movein_at)->addMonths($request->moveout_at),
                'discount' => 0,
                'term' => $term,
                'number_of_months' =>  $request->moveout_at,
                'created_at' => $request->movein_at,
            ]
        );

            if($request->no_of_charges > 0){
                DB::table('units')
                ->where('unit_id', $unit_id)
                ->update(
                    [
                        'status' => 'reserved'
                    ]
                );
            }else{
                DB::table('units')
                ->where('unit_id', $unit_id)
                ->update(
                    [
                        'status' => 'occupied'
                    ]
                );
            }

            $tenant =Tenant::findOrFail($tenant_id);
        
            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'contract';
            $notification->message = $tenant->first_name.' '.$tenant->last_name.' new contract has been added!';
            $notification->save();
                        
            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));
      

        return redirect('/property/'.Session::get('property_id').'/tenant/'.$tenant_id.'#contracts')->with('success', 'Contract has been extended!');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id, $tenant_id, $contract_id)
    {
        $contract = Contract::findOrFail($contract_id);

        $property = Property::findOrFail($property_id);

        $tenants = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
        ->where('property_id', $property_id)
        ->where('tenant_id','<>',$tenant_id)
        ->get();

        $units = Property::findOrFail($property_id)->units;

        $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('lower_access_user_id', Auth::user()->id)
        ->orWhere('id', Auth::user()->id)  
        ->orderBy('users.name')
        ->get();

        $tenant = Tenant::findOrFail($tenant_id);

        return view('webapp.contracts.edit', compact('contract', 'property', 'tenants', 'units', 'users', 'tenant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */

    public function expired()
    {
        $tenants_to_watch_out = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->select('*', 'contracts.status as contract_status' )
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->where('moveout_at', '<=', Carbon::now()->addMonth())
        ->orderBy('moveout_at', 'asc')
        ->get();

        return view('webapp.contracts.expired', compact('tenants_to_watch_out'));
    }


     //send notice for contract extension
public function send_contract_alert($property_id, $unit_id, $tenant_id, $contract_id){

    $tenant = Tenant::findOrFail($tenant_id);
    $unit  = Unit::findOrFail($unit_id);
    $property  = Property::findOrFail($property_id);
    $contract  = Contract::findOrFail($contract_id);

     $diffInDays =  number_format(Carbon::now()->DiffInDays(Carbon::parse($contract->moveout_at), false));

    $data = array(
        'email' => $tenant->email_address,
        'name' => $tenant->first_name,
        'property' => $property->name,
        'unit' => $unit->unit_no,
        'moveout_at'  => $contract->moveout_at,
        'days_before_moveout' => $diffInDays
    );


    Mail::send('webapp.tenants.send-contract-alert-mail', $data, function($message) use ($data){
        $message->to($data['email']);
        $message->bcc(['customercare@thepropertymanager.online']);
        $message->subject('Contract Termination Alert');

    });

    $tenant =Tenant::findOrFail($tenant_id);
        
    $notification = new Notification();
    $notification->user_id_foreign = Auth::user()->id;
    $notification->property_id_foreign = Session::get('property_id');
    $notification->type = 'contract';
    $notification->message = $tenant->first_name.' '.$tenant->last_name.' contract alert has been sent!';
    $notification->save();
                
    Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

    return back()->with('success', 'Email has been sent to '.$tenant->first_name.' '.$unit->unit_no);

}

    public function update(Request $request, $property_id, $tenant_id, $contract_id)
    {
       DB::table('contracts')
       ->where('contract_id', $contract_id)
       ->update([
            'tenant_id_foreign' => $request->tenant_id_foreign,
            'unit_id_foreign' => $request->unit_id_foreign,
            'referrer_id_foreign' => $request->referrer_id_foreign,
            'form_of_interaction' => $request->form_of_interaction,
            'rent' => $request->rent,
            'status' => $request->status,
            'movein_at' => $request->movein_at,
            'moveout_at' => $request->moveout_at,
            'number_of_months' => $request->number_of_months,
            'term' => $request->term,
            'terminated_at' => $request->terminated_at,
            'actual_moveout_at' => $request->actual_moveout_at,
            'moveout_reason' => $request->moveout_reason,
            'updated_at' => Carbon::now()
       ]);

       $tenant =Tenant::findOrFail($tenant_id);
           
       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'contract';
       $notification->message = $tenant->first_name.' '.$tenant->last_name.' contract has been updated!';
       $notification->save();
                   
       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

       return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id)->with('success', 'Contract added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($property_id, $tenant_id, $contract_id)
    {

        $tenant =Tenant::findOrFail($tenant_id);
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'contract';
        $notification->message = $tenant->first_name.' '.$tenant->last_name.' contract has been deleted!';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

        $contract = Contract::findOrFail($contract_id);

        DB::table('units')
        ->where('unit_id', $contract->unit_id_foreign)
        ->update([
            'status' => 'vacant'
        ]);

        DB::table('contracts')
        ->where('contract_id', $contract_id)
        ->delete();

    
        

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#contracts')->with('success', 'Contract has been deleted!');
    }
}
