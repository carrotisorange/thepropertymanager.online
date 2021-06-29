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
use App\Particular; 
use App\PropertyBill;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('current-page', 'bulk-billing');

        
       $property_bills = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        
        $notification->message = Auth::user()->name.' opens bills page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing'){

          
            
        // if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
        //     $bills = DB::table('contracts')
        //     ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        //     ->join('units', 'unit_id_foreign', 'unit_id')
        //     ->join('bills', 'unit_id', 'bill_unit_id')
        //     ->where('property_id_foreign', Session::get('property_id'))
        //     ->orderBy('bill_no', 'desc')
        //     ->groupBy('bill_id')
        //     ->get()
        //     ->groupBy(function($item) {
        //         return \Carbon\Carbon::parse($item->start)->timestamp;
        //     });
            
       
        // }else{
        //     $bills = DB::table('contracts')
        //     ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        //     ->join('units', 'unit_id_foreign', 'unit_id')
        //     ->join('bills', 'tenant_id', 'bill_tenant_id')
        //     ->where('property_id_foreign', Session::get('property_id'))
        //     ->orderBy('bill_no', 'desc')
        //     ->groupBy('bill_id')
        //     ->get()
            
        //     ->groupBy(function($item) {
        //         return \Carbon\Carbon::parse($item->start)->timestamp;
        //     });
        // }

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            $bills = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('bills', 'unit_id', 'bill_unit_id')
            ->join('particulars','particular_id_foreign', 'particular_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('date_posted', 'desc')
            ->groupBy('bill_id')
            ->get();
       
        }else{
            $bills = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->join('particulars','particular_id_foreign', 'particular_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('date_posted', 'desc')
            ->groupBy('bill_id')
            ->get();
        }
    
            return view('webapp.bills.index', compact('bills', 'property_bills'));
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

    public function filter(Request $request){

        Session::put('current-page', 'bulk-billing');

        $property_bills = DB::table('particulars')
         ->join('property_bills', 'particular_id', 'particular_id_foreign')
         ->where('property_id_foreign', Session::get('property_id'))
         ->orderBy('particular', 'asc')
         ->get();
 
         $notification = new Notification();
         $notification->user_id_foreign = Auth::user()->id;
         $notification->property_id_foreign = Session::get('property_id');
         $notification->type = 'bill';
         
         $notification->message = Auth::user()->name.' opens bills page.';
         $notification->save();
                     
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
 
         if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing'){

            if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                $bills = DB::table('contracts')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('bills', 'unit_id', 'bill_unit_id')
                ->join('particulars','particular_id_foreign', 'particular_id')
                ->where('particular_id_foreign', $request->particular)
                ->where('property_id_foreign', Session::get('property_id'))
                ->orderBy('date_posted', 'desc')
                ->groupBy('bill_id')
                ->get();
           
            }else{
                $bills = DB::table('contracts')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('bills', 'tenant_id', 'bill_tenant_id')
                ->join('particulars','particular_id_foreign', 'particular_id')
                ->where('particular_id_foreign', $request->particular)
                ->where('property_id_foreign', Session::get('property_id'))
                ->orderBy('date_posted', 'desc')
                ->groupBy('bill_id')
                ->get();
            }

       
     
             return view('webapp.bills.index', compact('bills', 'property_bills'));
         }else{
             return view('layouts.arsha.unregistered');
         }
    }

    public function create_bulk_bills(Request $request,$property_id, $bill_id){
    
        $updated_start = $request->start;
        $updated_end = $request->end;

        if($request->options == 'true'){
            if($request->bill_id == '2'){
                 DB::table('property_bills')
                ->where('particular_id_foreign', $bill_id)
                ->update(
                    [
                        'rate' => $request->water_rate
                    ]
                );
            }else{
                if($request->bill_id == '3'){
                     DB::table('property_bills')
                    ->where('particular_id_foreign', $bill_id)
                    ->update(
                        [
                            'rate' => $request->electric_rate
                        ]
                    );
            }
        }

        $particular = Particular::findOrFail($bill_id);

         $property_bill = PropertyBill::findOrFail($request->particular_id);
    
        }else{
       
            $selected_particular = explode("-", $request->particular_id);

             $particular_id = $selected_particular[0];
            $property_bill_id =  $selected_particular[1];
        
             $particular = Particular::findOrFail($particular_id);

            $property_bill = PropertyBill::findOrFail($property_bill_id);
        }
        

        $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->select('*', 'contracts.rent as contract_rent')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->orderBy('movein_at', 'desc')
        ->get();

        
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

        return view('webapp.bills.create.create-bulk', compact('active_tenants','current_bill_no','particular','property_bill','updated_start','updated_end'));


    }

    public function store_bulk_bills(Request $request){

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

        
        $particular = Particular::findOrFail($request->particular_id)->particular;
     
        
          $no_of_billed = 1;
            for($i = 1; $i<=$active_tenants; $i++){
               if($request->input('amount'.$i) > 0){
                $no_of_billed++;
                DB::table('bills')->insert(
                    [
                        'bill_no' => $current_bill_no++,
                        'bill_tenant_id' => $request->input('bill_tenant_id'.$i),
                        'bill_unit_id' => $request->input('bill_unit_id'.$i),
                        'date_posted' => Carbon::now(),
                        'start' => $request->input('start'.$i),
                        'end' => $request->input('end'.$i),
                        'particular' => $particular,
                        'particular_id_foreign' => $request->particular_id,
                        'amount' =>  $request->input('amount'.$i)
                    ]);
                    
                    if($request->particular_id == '3'){
                        $contract =  Contract::find($request->input('contract_id'.$i));
                        $contract->initial_electric =  $request->input('current_reading'.$i);
                        $contract->save();
                    }

                    if($request->particular_id == '2'){
                        $contract =  Contract::find($request->input('contract_id'.$i));
                        $contract->initial_water =  $request->input('current_reading'.$i);
                        $contract->save();
                    }

         
               }
            }

            
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        
        $notification->message = Auth::user()->name. 'posts '.($no_of_billed-1).' '.$request->particular1.'.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return redirect('/property/'.$request->property_id.'/bills')->with('success', ($no_of_billed-1).' '.$particular.' bills have been posted!');

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

$request->session()->now('success', 'Changes saved.');
  

    return view('webapp.bills.add-rental-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end'));

    }

    public function post_bills_condodues(Request $request, $property_id)
    {
        $buildings = Property::findOrFail(Session::get('property_id'))
        ->units()
        ->where('status','<>','deleted')
        ->select('building', DB::raw('count(*) as count'), 'condodues')
        ->groupBy('building')
        ->get('building','count', 'condodues');

    $updated_start = $request->start;
    $updated_end = $request->end;

    
    
    for($i=1; $i<=$buildings->count(); $i++){
        DB::table('units')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('building', $request->input('building'.$i))
        ->update([
             'condodues' => $request->input('condodues'.$i)
        ]);
        
    }


   $active_tenants = DB::table('contracts')
  ->join('units', 'unit_id_foreign', 'unit_id')
  ->join('tenants', 'tenant_id_foreign', 'tenant_id')
  ->select('*', 'contracts.rent as contract_rent')
  ->where('property_id_foreign', Session::get('property_id'))
//   ->where('contracts.status', 'active')
  ->orderBy('building')
  ->orderBy('unit_no')
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

//    $request->session()->now('success', 'Changes saved.');

    return view('webapp.bills.add-condodues-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end', 'buildings'));

    }

    public function post_bills_electric(Request $request, $property_id)
    {
    
    $updated_start = $request->start;
    $updated_end = $request->end;
    Session::put('electric_rate_kwh', $request->electric_rate_kwh);

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

DB::table('properties')
->where('property_id', Session::get('property_id'))
->update([
     'electric_rate_kwh' => Session::get('electric_rate_kwh')
]);

//    $request->session()->now('success', 'Changes saved.');

    return view('webapp.bills.add-electric-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end'));


       
    }

    public function post_bills_water(Request $request, $property_id)
    {

        $updated_start = $request->start;
        $updated_end = $request->end;
        Session::put('water_rate_cum', $request->water_rate_cum);
    
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

       DB::table('properties')
       ->where('property_id', Session::get('property_id'))
       ->update([
            'water_rate_cum' => Session::get('water_rate_cum')
       ]);

       
    //    $request->session()->now('success', 'Changes saved.');
    
        return view('webapp.bills.add-water-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end'));
    

      
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

    // $request->session()->now('success', 'Changes saved.');
    
        return view('webapp.bills.add-surcharge-bill', compact('active_tenants','current_bill_no', 'updated_start', 'updated_end'));
    

      
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

            if($request->input('particular'.$i) == '18'){
                $amount = $request->input('particular'.$i)*-1;
            }else{
                $amount = $request->input('particular'.$i);
            }

            $particular = Particular::findOrFail($request->input('particular'.$i));

            $bill = new Bill();
            $bill->bill_tenant_id = $tenant_id;
            $bill->bill_no = $current_bill_no++;
            $bill->date_posted = $request->date_posted;
            $bill->particular_id_foreign = $request->input('particular'.$i);
            $bill->start = $request->input('start'.$i);
            $bill->end = $request->input('end'.$i);
            $bill->amount = $amount;
            $bill->save();

            
            $tenant = Tenant::findOrFail($tenant_id);

            // $data = array(
            //     // 'email' =>$tenant->email_address,
            //     'name' => $tenant->first_name,
            //     'property' => $property->name,
            //     'amt' => $request->input('amount'.$i),
            //     'desc' => $request->input('particular'.$i),
            //     'start' => $request->input('start'.$i),
            //     'end' => $request->input('end'.$i),
            // );

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'bill';
            
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

            $particular = Particular::findOrFail($request->input('particular'.$i));

            $bill = new Bill();
            $bill->bill_unit_id = $unit_id;
            $bill->bill_no = $current_bill_no++;
            $bill->date_posted = $request->date_posted;
            $bill->particular_id_foreign = $particular->particular_id_foreign;
            $bill->particular = $particular->particular;
          
            $bill->start = $request->input('start'.$i);
            $bill->end = $request->input('end'.$i);
            if($request->particular1 == '18'){
                $bill->amount = $request->input('amount'.$i) * -1;
            }else{
                $bill->amount = $request->input('amount'.$i);
            }

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

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'admin'){
            
            //get the tenant information
              $tenant = Tenant::findOrFail($tenant_id);
    
            //get the number of last added bills
   
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;

            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->join('particulars','particular_id_foreign', 'particular_id')
          ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
          ->where('bill_tenant_id', $tenant_id)
          ->groupBy('bill_id')
          ->orderBy('bill_no', 'desc')
          // ->havingRaw('balance > 0')
          ->get();

          $property_bills = DB::table('particulars')
          ->join('property_bills', 'particular_id', 'particular_id_foreign')
          ->where('property_id_foreign', Session::get('property_id'))
          ->orderBy('particular', 'asc')
          ->get();

            if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                return view('webapp.bills.edit', compact('current_bill_no','tenant', 'balance', 'property'));  
            }else{
                return view('webapp.bills.edit_tenant_bills', compact('current_bill_no','tenant', 'balance','property_bills'));  
            }

        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    public function edit_occupant_bills($property_id, $unit_id)
    {

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'admin' ){
      
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
             ->havingRaw('balance > 0')
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

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'admin'){
           
             $bills = Tenant::findOrFail($tenant_id)->bills->count();

            for ($i=1; $i <= $bills; $i++) { 
                 $bill = Bill::find( $request->input('billing_id_ctr'.$i));
                  $bill->start = $request->input('start_ctr'.$i);
                  $bill->end = $request->input('end_ctr'.$i);
                  $bill->particular_id_foreign = $request->input('particular_ctr'.$i);
                  $bill->amount = $request->input('amount_ctr'.$i);
                 $bill->save();
               }

               DB::table('properties')
               ->where('property_id', Session::get('property_id'))
               ->update(
                       [
                           'footer_message' => $request->note,
                       ]
                   );

                   Session::put('footer_message', $request->note);

                   $tenant = Tenant::findOrFail($tenant_id);

                    $notification = new Notification();
                    $notification->user_id_foreign = Auth::user()->id;
                    $notification->property_id_foreign = Session::get('property_id');
                    $notification->type = 'bill';
                    
                    $notification->message = Auth::user()->name.' updates '.$tenant->first_name.' '.$tenant->last_name.' bills.';
                    $notification->save();

                     Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
             
                    return back()->with('success','Changes saved.');
           
        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    
    public function update_occupant_bills(Request $request, $property_id, $unit_id){


        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'admin' ){


            $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_unit_id', $unit_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();
             

            for ($i=1; $i <= $bills->count(); $i++) { 
                 $bill = Bill::find($request->input('billing_id_ctr'.$i));
                  $bill->start = $request->input('start_ctr'.$i);
                  $bill->end = $request->input('end_ctr'.$i);
                  $bill->amount = $request->input('amount_ctr'.$i);
                 $bill->save();
               }

               DB::table('properties')
               ->where('property_id', Session::get('property_id'))
               ->update(
                       [
                           'footer_message' => $request->note,
                       ]
                   );

                   Session::put('footer_message', $request->note);

            $unit = Unit::findOrFail($unit_id);
                   
            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'bill';
            
            $notification->message = Auth::user()->name.' updates '.$unit->unit_no.' bills.';
            $notification->save();
                        
             Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
          
             
             return back()->with('success','Changes saved.');
                    // return redirect('/property/'.$property_id.'/unit/'.$unit_id.'#bills')->with('success','Changes saved.');
           
           
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

        $current_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->where('start', '>', Carbon::now()->month())
        ->where('particular_id_foreign', '1')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $previous_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->where('start', '<=', Carbon::now()->subMonth()->firstOfMonth())
        ->where('particular_id_foreign', '1')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();
        
        
        $previous_surcharges = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->where('start', '<=', Carbon::now()->subMonth()->firstOfMonth())
        ->where('particular_id_foreign', '16')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $other_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('bill_id')
        ->where('particular_id_foreign','!=', ['1','16'])
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $room_id = Tenant::findOrFail($tenant_id)->contracts()->first()->unit_id_foreign;

        $current_room = Unit::findOrFail($room_id)->unit_no;

        $data = [
            'tenant' => $tenant->first_name.' '.$tenant->last_name ,
            'current_bills' => $current_bills,
            'previous_bills' => $previous_bills,
            'previous_surcharges'=>$previous_surcharges,
            'other_bills'=>$other_bills,
            'current_room' => $current_room,
        ];

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        
        $notification->message = Auth::user()->name.' exports '.$tenant->first_name.' '.$tenant->last_name.' bills.';
        $notification->save();

        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $pdf = \PDF::loadView('webapp.bills.soa', $data)
        ->setPaper('a5', 'portrait');

       // $pdf->setPaper('L');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();
        $canvas->set_opacity(.1,"Multiply");
        $canvas->page_text($width/5, $height/4 , Session::get('property_name'), null,
          28, array(0,0,0),5,0,0);
        return $pdf->stream();

        //return $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-soa'.'.pdf');
    }

    public function export_occupant_bills($property_id,$unit_id)
    {

        $current_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
      ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
      ->where('bill_unit_id', $unit_id)
      ->where('start', '=>', Carbon::now()->month())
      ->where('particular', 'Rent')
      ->groupBy('bill_id')
      ->orderBy('bill_no', 'desc')
      ->havingRaw('balance > 0')
      ->get();

        $previous_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
      ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
      ->where('bill_unit_id', $unit_id)
      ->where('start', '<=', Carbon::now()->subMonth()->firstOfMonth())
      ->where('particular', 'Rent')
      ->groupBy('bill_id')
      ->orderBy('bill_no', 'desc')
      ->havingRaw('balance > 0')
      ->get();
      
      
       $previous_surcharges = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
      ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
      ->where('bill_unit_id', $unit_id)
      ->where('start', '<=', Carbon::now()->subMonth()->firstOfMonth())
      ->where('particular', 'Surcharge')
      ->groupBy('bill_id')
      ->orderBy('bill_no', 'desc')
      ->havingRaw('balance > 0')
      ->get();

      $other_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
      ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
      ->where('bill_unit_id', $unit_id)
      ->where('particular','!=', ['Rent','Surcharge'])
      ->groupBy('bill_id')
      ->orderBy('bill_no', 'desc')
       ->havingRaw('balance > 0')
      ->get();


      $unit_no = Unit::findOrFail($unit_id)->unit_no;

      $tenant = DB::table('contracts')
      ->join('units', 'unit_id_foreign', 'unit_id')
      ->join('tenants', 'tenant_id_foreign', 'tenant_id')
      ->where('unit_id', $unit_id)
      ->get();

      $data = [
          'current_bills' => $current_bills,
          'previous_bills' => $previous_bills,
          'previous_surcharges'=>$previous_surcharges,
          'other_bills'=>$other_bills,
          'current_room' => $unit_no,
          'tenant' => $tenant
      ];

      $notification = new Notification();
      $notification->user_id_foreign = Auth::user()->id;
      $notification->property_id_foreign = Session::get('property_id');
      $notification->type = 'bill';
      $notification->message = Auth::user()->name.' updates '.$unit_no.' bills.';
      $notification->save();

       Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
       
      $pdf = \PDF::loadView('webapp.bills.soa-unit', $data)
      ->setPaper('a5', 'portrait');

      // $pdf->setPaper('L');
       $pdf->output();
       $canvas = $pdf->getDomPDF()->getCanvas();
       $height = $canvas->get_height();
       $width = $canvas->get_width();
       $canvas->set_opacity(.1,"Multiply");
       $canvas->page_text($width/5, $height/4 , Session::get('property_name'), null,
         28, array(0,0,0),5,0,0);
       return $pdf->stream();
    }
    
    public function action(Request $request, $property_id, $tenant_id, $bill_id)
    {
        if($request->bill_option == 'Debit memo'){
            return redirect('/property/'.$request->property_id.'/room/'.$room_id.'/contract/'.$contract_id.'/tenant/'.$tenant_id.'/bill/'.$bill_id.'/payment/'.$payment_id.'/remittance/create');
        }
    }

    public function restore_bill($property_id, $tenant_id, $billing_id)
    {
        $bill = Bill::findOrFail($billing_id);
        $bill->bill_status = NULL;
        $bill->save();

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        
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
        
        $notification->message = Auth::user()->name.' archives bill '. $billing_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return back()->with('success', 'Bill archived successfully.');
    }
   
}