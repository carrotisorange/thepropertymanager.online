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
        //
    }

    public function action(Request $request, $property_id, $room_id, $tenant_id, $contract_id, $balance)
    {
       $contract = Contract::findOrFail($contract_id);

        if($request->contract_option == 'edit'){
            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id.'/edit');
        }elseif($request->contract_option == 'terminate'){
            if($contract->terminated_at == NULL){
                if($balance>0){
                    return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'/#contracts/')->with('danger', 'Cannot terminate the contract due to the pending balance.');
                }else{
                    return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id.'/preterminate');
                }
            }

        }elseif($request->contract_option == 'moveout'){
                if($balance>0){
                    return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'/#contracts/')->with('danger', 'Tenant cannot be moved out due to the pending balance.');
                }else{
                    if($contract->status!='inactive'){
                        return redirect('/property/'.$request->property_id.'/room/'.$room_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id.'/moveout');
                    }
                }
           
        }elseif($request->contract_option == 'delete'){
            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id.'/delete');
        }elseif($request->contract_option == 'transfer'){
            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id.'/create/transfer');
        }
        

        
    }

    public function create_transfer_room($property_id, $tenant_id, $contract_id){
        $units = Property::findOrFail(Session::get('property_id'))

        ->units()->whereIn('status',['vacant'])
        ->get();        
        

        $buildings = Property::findOrFail(Session::get('property_id'))
        ->units()
        ->whereIn('status',['vacant'])
        ->select('building', 'status', DB::raw('count(*) as count'))
        ->groupBy('building')
        ->orderBy('building', 'asc')
        ->get('building', 'status','count');

        $tenant = Tenant::findOrFail($tenant_id);

        $contract = Contract::findOrFail($contract_id);

        return view('webapp.contracts.create-transfer-room', compact('units', 'buildings', 'tenant', 'contract'));
    }

    public function store_transfer_room(Request $request, $property_id, $tenant_id, $contract_id){

       $current_contract = Contract::findOrFail($contract_id);

       $new_contract_id = Uuid::generate()->string;

       //make the current contract inactive
       DB::table('contracts')->where('contract_id', $contract_id)
       ->update([
        'status' => 'inactive'
       ]);

       //change the status of the new contract to occupied
       DB::table('units')->where('unit_id', $request->room_id)
       ->update([
        'status'=> 'occupied'          
       ]);

       //change the status of the old contract to vacant
       DB::table('units')->where('unit_id', $current_contract->unit_id)
        ->update([
            'status'=> 'vacant'
        ]);

       DB::table('contracts')->insert([
       'contract_id' => $new_contract_id,
       'unit_id_foreign' => $request->room_id,
       'tenant_id_foreign' => $current_contract->tenant_id_foreign,
       'movein_at' => $current_contract->movein_at,
       'moveout_at' => $current_contract->moveout_at,
       'number_of_months' => $current_contract->number_of_months,
       'term' => $current_contract->term,
       'rent' => $current_contract->rent,
       'discount' => $current_contract->discount,
       'status' => $current_contract->status,
       'referrer_id_foreign' => $current_contract->referrer_id_foreign,
       'form_of_interaction' => $current_contract->form_of_interaction,
       'created_at' => Carbon::now(),
       ]);

       $new_contract = Contract::findOrFail($new_contract_id);
       $tenant = Tenant::findOrFail($current_contract->tenant_id_foreign);
       $room = Unit::findOrFail($current_contract->unit_id_foreign);

       $notification = new Notification();
       $notification->user_id_foreign = Auth::user()->id;
       $notification->property_id_foreign = Session::get('property_id');
       $notification->type = 'contract';
       $notification->message = Auth::user()->name. ' adds new contract for '.$tenant->first_name.' in
       '.$room->unit_no.'.';
       $notification->save();

    

        return redirect('/property/'.Session::get('property_id').'/tenant/'.$current_contract->tenant_id_foreign.'/#contracts')->with('success',
        'Contract"s room has been transferred successfully!');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $unit_id, $tenant_id)
    {
        Session::put('current-page', 'tenants');

        $room = Unit::findOrFail($unit_id);

        $tenant = Tenant::findOrFail($tenant_id);

        $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->join('roles', 'role_id_foreign', 'role_id')
        ->select('*', 'properties.name as property')
        ->where('lower_access_user_id', Auth::user()->id)
        ->orWhere('id', Auth::user()->id)  
        ->orderBy('users.name')
        ->get();

        return view('webapp.contracts.create', compact('tenant','room','users'));

        // $property_bills = DB::table('particulars')
        // ->join('property_bills', 'particular_id', 'particular_id_foreign')
        // ->where('property_id_foreign', Session::get('property_id'))
        // ->orderBy('particular', 'asc')
        // ->get();

        // $request->validate([
        //     'unit_id' => 'required'
        // ]);

        //  $unit = Unit::findOrFail($request->unit_id);

        // $tenant = Tenant::findOrFail($tenant_id);

        // $users = DB::table('users_properties_relations')
        // ->join('properties', 'property_id_foreign', 'property_id')
        // ->join('users', 'user_id_foreign', 'id')
        // ->select('*', 'properties.name as property')
        // ->where('lower_access_user_id', Auth::user()->id)
        // ->orWhere('id', Auth::user()->id)  
        // ->orderBy('users.name')
        // ->get();

        // if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
        //     $current_bill_no = DB::table('units')
        //     ->join('bills', 'unit_id', 'bill_unit_id')
        //     ->where('property_id_foreign', Session::get('property_id'))
        //     ->max('bill_no') + 1;
    
        // }else{
        //     $current_bill_no = DB::table('contracts')
        //     ->join('units', 'unit_id_foreign', 'unit_id')
        //     ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        //     ->join('bills', 'tenant_id', 'bill_tenant_id')
        //     ->where('property_id_foreign', Session::get('property_id'))
        //     ->max('bill_no') + 1;
        // }     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $unit_id, $tenant_id)
    {
        $request->validate([
            'form_of_interaction' => ['required'],
            'movein_at' => ['required'],
            'moveout_at' => ['required'],
            'number_of_months' => ['required'],
            'discount' => ['required'],
            'term' => ['required'],
            'rent' => ['required'],
            'refferr_id_foreign' => []
        ]);

        $contract_id = Uuid::generate()->string;

        DB::table('contracts')->insert([
            'contract_id' => $contract_id,
            'unit_id_foreign' => $unit_id,
            'tenant_id_foreign' => $tenant_id,
            'movein_at' => $request->movein_at,
            'moveout_at' => $request->moveout_at,
            'number_of_months' => $request->number_of_months,
            'term' => $request->term,
            'rent' => $request->rent,
            'discount' => $request->discount,
            'referrer_id_foreign' => $request->referrer_id_foreign,
            'form_of_interaction' => $request->form_of_interaction,
            'created_at' => Carbon::now(),
        ]);

        //get the last added bill no of the property
        // $current_bill_no = DB::table('contracts')
        // ->join('units', 'unit_id_foreign', 'unit_id')
        // ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        // ->join('bills', 'tenant_id', 'bill_tenant_id')
        // ->where('property_id_foreign', Session::get('property_id'))
        // ->max('bill_no') + 1;   

            //get the last added bill no of the property
            $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;

        //post the rental bill
        Bill::create([
            'bill_no' => $current_bill_no,
            'bill_tenant_id' => $tenant_id,
            'date_posted' => $request->movein_at,
            'particular_id_foreign' => '1',
            'amount'=> $request->rent,
            'start' => $request->movein_at, 
            'end' => Carbon::parse($request->movein_at)->addMonth(1),
        ]);

        //post the advanced rent
        Bill::create([
            'bill_no' => $current_bill_no+1,
            'bill_tenant_id' => $tenant_id,
            'date_posted' => $request->movein_at,
            'particular_id_foreign' => '17',
            'amount'=> $request->rent,
            'start' => $request->movein_at, 
            'end' => $request->moveout_at
        ]);

          if(Session::get('property_type') !== 5){
            Unit::where('unit_id', $unit_id)
                ->update([
                'status' => 'reserved'
            ]);

          }else{ 
            Unit::where('unit_id', $unit_id)
            ->update([
            'status' => 'occupied'
            ]);

            Contract::where('contract_id', $contract_id)
            ->update([
            'status' => 'active'
            ]);
          }
    

        $contract = Contract::findOrFail($contract_id);
        $tenant = Tenant::findOrFail($tenant_id);
        $unit = Unit::findOrFail($unit_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'contract';
        $notification->message = Auth::user()->name. ' adds new contract for '.$tenant->first_name.' in '.$unit->unit_no.'.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail($property_id)->unseen_notifications);

          if(Session::get('property_type') !== 5){
  return
  redirect('/property/'.Session::get('property_id').'/room/'.$unit_id.'/tenant/'.$tenant_id.'/contract/'.$contract->contract_id.'/create/bill')->with('success',
  'Contract is added successfully.');
          }else{
  return
  redirect('/property/'.Session::get('property_id').'/room/'.$unit_id.'/#tenants')->with('success',
  'Contract is added successfully.');
          }

      
    }
    
    public function contract_room_select($property_id){
        return $property_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $tenant_id, $contract_id)
    {
        Session::put('current-page', 'rooms');

        //  $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        // ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        // ->where('bill_tenant_id', $tenant_id)
        // ->where('bill_status', '<>', 'deleted')
        // ->groupBy('bill_id')
        // ->orderBy('bill_no', 'desc')
        // ->havingRaw('balance > 0')
        // ->get();

        $balance = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->where('bill_status', NULL)
        ->havingRaw('balance > 0')
        ->get();
       
        $tenant = Tenant::findOrFail($tenant_id);

        $contract = Contract::findOrFail($contract_id);

        $property = Property::findOrFail($property_id);

        return view('webapp.contracts.show', compact('contract', 'property', 'balance', 'tenant'));
    }

    // public function moveout_get(Request $request, $property_id, $tenant_id, $contract_id){

    //     Session::put('current-page', 'rooms');

    //     $tenant = Tenant::findOrFail($tenant_id);

    //     $contract = Contract::findOrFail($contract_id);

    //     $property = Property::findOrFail($property_id);

    //     return view('webapp.contracts.moveout', compact('tenant', 'property', 'contract'));
    // }

    public function moveout_get(Request $request, $property_id, $unit_id, $tenant_id, $contract_id){


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
                'status' => 'dirty',
                'updated_at' => Carbon::now()
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
                //     $message->bcc(['landleybernardo@thepropertymanager.online','thepropertymanagernoreply@gmail.com']);
                //     $message->subject('Contract Termination');
                // });
                // }
        
                $notification = new Notification();
                $notification->user_id_foreign = Auth::user()->id;
                $notification->property_id_foreign = Session::get('property_id');
                $notification->type = 'contract';
                
                $notification->message = Auth::user()->name.' moves out '.$tenant->first_name.' '.$tenant->last_name.'.';
                $notification->save();
                            
                 Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

                 $pdf = \PDF::loadView('webapp.tenants.gatepass', $data)
                 ->setPaper('a5', 'portrait');
         
                // $pdf->setPaper('L');
                 $pdf->output();
                 $canvas = $pdf->getDomPDF()->getCanvas();
                 $height = $canvas->get_height();
                 $width = $canvas->get_width();
                 $canvas->set_opacity(.1,"Multiply");
                 $canvas->page_text($width/5, $height/2, Session::get('property_name'), null,
                  28, array(0,0,0),2,2,0);
                 return $pdf->stream();

            // $pdf = \PDF::loadView('webapp.tenants.gatepass', $data)->setPaper('a4', 'portrait');
      
            //  return $pdf->download($tenant->first_name.' '.$tenant->last_name.'.pdf');
    
        //return redirect('/units/'.$request->unit_tenant_id.'/tenants/'.$request->tenant_id)->with('success','tenant has been moved out!');
    }


    public function preterminate_post(Request $request, $property_id, $tenant_id, $contract_id){

        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
            $current_bill_no = DB::table('units')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->where('bills.property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;
    
        }else{
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('bills.property_id_foreign', Session::get('property_id'))
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
            // $message->to($data['email']);
            $message->bcc(['landleybernardo@thepropertymanager.online','thepropertymanagernoreply@gmail.com']);
            $message->subject('Contract Termination');
        });
        }

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'contract';
        
        $notification->message = Auth::user()->name.' terminates '.$tenant->first_name.' '.$tenant->last_name.' contract.';
        $notification->save();
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id)->with('success', 'Contract terminated successfully. Continue with the moveout.');
    }

    public function preterminate($property_id, $tenant_id, $contract_id)
    {

        Session::put('current-page', 'rooms');

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

            $previous_contract = Contract::findOrFail($contract_id);
            $previous_contract->status = 'inactive';
            $previous_contract->moveout_reason = 'End of contract';
            $previous_contract->form_of_interaction = 'Renewal';
            $previous_contract->save();

            $tenant =Tenant::findOrFail($tenant_id);
        
            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'contract';
            
            $notification->message = Auth::user()->name.' extends '.$tenant->first_name.' '.$tenant->last_name.' contract.';
            $notification->save();
                        
            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
      

        return redirect('/property/'.Session::get('property_id').'/tenant/'.$tenant_id.'#contracts')->with('success', 'Contract is extended successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id, $tenant_id, $contract_id)
    {

        Session::put('current-page', 'rooms');

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

        Session::put('current-page', 'dashboard');

        $tenants_to_watch_out = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->select('*', 'contracts.status as contract_status' )
->where('property_id_foreign', Session::get('property_id'))
->where('contracts.status','<>', 'inactive')
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
        '
        ' => $tenant->email_address,
        'name' => $tenant->first_name,
        'property' => $property->name,
        'unit' => $unit->unit_no,
        'moveout_at'  => $contract->moveout_at,
        'days_before_moveout' => $diffInDays
    );


    Mail::send('webapp.tenants.send-contract-alert-mail', $data, function($message) use ($data){
        $message->to($data['email']);
        $message->bcc(['thepropertymanagernoreply@gmail.com']);
        $message->subject('Contract Termination Alert');

    });

    $tenant =Tenant::findOrFail($tenant_id);
        
    $notification = new Notification();
    $notification->user_id_foreign = Auth::user()->id;
    $notification->property_id_foreign = Session::get('property_id');
    $notification->type = 'contract';
    
    $notification->message = Auth::user()->name.' sends notice to expire contract to '.$tenant->first_name.' '.$tenant->last_name.'.';
    $notification->save();
                
    Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

    return back()->with('success', 'Email is sent to '.$tenant->first_name.' '.$unit->unit_no);

}

    public function update(Request $request, $property_id, $tenant_id, $contract_id)
    {
       DB::table('contracts')
       ->where('contract_id', $contract_id)
       ->update([
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
       
       $notification->message = Auth::user()->name.' updates '.$tenant->first_name.' '.$tenant->last_name.' contract.';
       $notification->save();
                   
       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

       return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'/contract/'.$contract_id)->with('success', 'Changes saved.');
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
        
        $notification->message = Auth::user()->name.' deletes '.$tenant->first_name.' '.$tenant->last_name.' contract.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $contract = Contract::findOrFail($contract_id);

        DB::table('units')
        ->where('unit_id', $contract->unit_id_foreign)
        ->update([
            'status' => 'vacant'
        ]);

        DB::table('contracts')
        ->where('contract_id', $contract_id)
        ->delete();

    
        

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#contracts')->with('success', 'Contract deleted successfully.');
    }
}
