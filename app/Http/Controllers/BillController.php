<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use Str;
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
use Uuid;
use App\Notif;

class BillController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Bill::onlyTrashed()->get();

        // $search = $request->search;

        Session::put('current-page', 'bulk-billing');

        // Session::put(Auth::user()->id.'date', $search);

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

        if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 5 ||
        auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 3){
            if(Session::get('property_type') === '5' || Session::get('property_type') === '1' || Session::get('property_type') === '6' ){ 
                $bills = DB::table('bills')
                ->leftJoin('tenants', 'tenant_id', 'bill_tenant_id')
                ->join('units', 'unit_id', 'bill_unit_id')

                ->join('particulars','particular_id_foreign', 'particular_id')
                ->where('bills.property_id_foreign', Session::get('property_id'))
                ->whereNull('deleted_at')
    
                ->orderBy('date_posted', 'desc')
                ->groupBy('bill_id')
                ->paginate(5);

                $count_bills=Bill::where('property_id_foreign', Session::get('property_id'))->count();
               
            }else{
                $bills = DB::table('bills')
                ->leftJoin('tenants', 'tenant_id', 'bill_tenant_id')
                ->join('units', 'unit_id', 'bill_unit_id')
                
                ->join('particulars','particular_id_foreign', 'particular_id')
                ->where('bills.property_id_foreign', Session::get('property_id'))
               
                ->whereNull('deleted_at')
                ->orderBy('date_posted', 'desc')
                ->groupBy('bill_id')
                  ->paginate(5);

                     $count_bills=Bill::where('property_id_foreign', Session::get('property_id'))->count();
            }    
 
            return view('webapp.bills.index', compact('bills', 'property_bills', 'count_bills'));
        }else{
            return view('layouts.arsha.unregistered');
        }
          

       
    }

    public function create_tenant_bill($property_id, $tenant_id){
        
        $particulars = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        $rooms = DB::table('contracts')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->select('*', 'contracts.status as contract_status', 'contracts.term as contract_term')
        ->where('tenant_id', $tenant_id)
        ->orderBy('contracts.created_at', 'desc')
        ->get();

         $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
          ->join('particulars','particular_id_foreign', 'particular_id')
          ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
          ->where('bill_tenant_id', $tenant_id)
          ->groupBy('bill_id')
          ->orderBy('bill_no', 'desc')
          // ->havingRaw('balance > 0')
          ->get();

        $tenant = Tenant::findOrFail($tenant_id);

        return view('webapp.bills.create-tenant-bill', compact('particulars','bills','tenant', 'rooms'));
    }

    public function store_tenant_bill(Request $request, $property_id, $tenant_id){

        $request->validate([
            'particular_id_foreign' => 'required',
            'amount' => 'required',
            'start' => 'required',
            'end' => 'required',
            'bill_unit_id' => 'required',
         ]);
 
           //get the last added bill no of the property
          $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
          ->max('bill_no') + 1;


         if($request->particular_id_foreign === '18'){
         $bill_amount = $request->amount * -1;
         }else{
         $bill_amount = $request->amount;
         }

 
          //post the additional bill
          Bill::create([
             'bill_no' => $current_bill_no,
             'bill_tenant_id' => $tenant_id,
             'date_posted' => Carbon::now(),
             'particular_id_foreign' => $request->particular_id_foreign,
             'amount'=> $bill_amount,
             'start' => $request->start, 
             'end' => $request->end,
             'property_id_foreign' => Session::get('property_id'),
             'bill_unit_id' => $request->bill_unit_id
         ]);

        $particulars = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        $bills = Bill::join('particulars','particular_id_foreign', 'particular_id')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->get();

        $tenant = Tenant::findOrFail($tenant_id);

        return back()->with('success', 'Bill is created successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $room_id, $tenant_id, $contract_id)
    {
        $room = Unit::findOrFail($room_id);
        $tenant = Tenant::findOrFail($tenant_id);
        $contract = Contract::findOrFail($contract_id);

        $bills = Bill::join('particulars','particular_id_foreign', 'particular_id')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->get();

        $particulars = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        return view('webapp.bills.create', compact('room', 'tenant', 'contract', 'bills', 'particulars'));
    }

    public function filter(Request $request){

        Session::put('current-page', 'bulk-billing');

        $particular = Particular::findOrFail($request->particular);

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
 
         if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 3){
            if(Session::get('property_type') === '5' || Session::get('property_type') === '1' || Session::get('property_type') === '6' ){
               
                 $bills = DB::table('bills')
                 ->leftJoin('tenants', 'tenant_id', 'bill_tenant_id')
                 ->join('units', 'unit_id', 'bill_unit_id')

                 ->join('particulars','particular_id_foreign', 'particular_id')
                 ->where('bills.property_id_foreign', Session::get('property_id'))
                 ->whereNull('deleted_at')
                 ->orderBy('date_posted', 'desc')
                 ->groupBy('bill_id')
                 ->paginate(5);
     

                $count_bills=Bill::where('property_id_foreign', Session::get('property_id'))->count();
            }else{
                $bills = DB::table('contracts')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('bills', 'unit_id', 'bill_unit_id')
                    ->join('particulars','particular_id_foreign', 'particular_id')
                    ->where('bills.property_id_foreign', Session::get('property_id'))
                    ->where('particular_id_foreign', $request->particular)
                        ->whereNull('deleted_at')
                    ->orderBy('date_posted', 'desc')
                    ->groupBy('bill_id')
                 
                    ->paginate(5);

                    $count_bills=Bill::where('property_id_foreign', Session::get('property_id'))->count();
            } 
             return view('webapp.bills.index', compact('bills', 'property_bills','particular','count_bills'));
         }else{
             return view('layouts.arsha.unregistered');
         }
    }

    public function create_bulk(Request $request,$property_id, $particular_id){
        
        $property_bill = PropertyBill::findOrFail($request->particular_id);

        $particular = Particular::findOrFail($property_bill->particular_id_foreign);

        //$batch_no = Uuid::generate()->string;
        $batch_no = Str::random(8);

        //get all the active tenants
         DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'active')
        ->update([
            'contracts.bill_batch_no' => $batch_no
        ]);

           //get all the active tenants
        DB::table('contracts')
           ->join('units', 'unit_id_foreign', 'unit_id')
           ->join('tenants', 'tenant_id_foreign', 'tenant_id')
           ->where('property_id_foreign', Session::get('property_id'))
           ->where('contracts.status', 'active')
           ->update([
           'tenants.bill_batch_no' => $batch_no
           ]);

        $bill_count = Contract::where('bill_batch_no', $batch_no)->get();

        //get the last added bill no of the property
        $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
        ->whereNull('deleted_at')
        ->max('bill_no') + 1;

        for ($i=$bill_count->min('unit_id_foreign'); $i<=$bill_count->max('unit_id_foreign'); $i++) {

        if (Tenant::where('bill_batch_no', $batch_no)->where('tenant_id', $i)->exists()) {
          $tenant = Tenant::where('bill_batch_no', $batch_no)->findOrFail($i);

        //pre-store bills
            Bill::create([
                'batch_no' => $batch_no,
                'bill_no' => $current_bill_no++,
                'bill_tenant_id' => $tenant->tenant_id,
                'date_posted' => Carbon::now(),
                'particular_id_foreign' => $particular->particular_id,
                'amount'=> '0',
                'start' => Carbon::now()->startOfMonth(), 
                'end' => Carbon::now()->endOfMonth(), 
                'property_id_foreign' => Session::get('property_id')
            ]);
        }
        }

        return redirect('/property/'.Session::get('property_id').'/create/bill/'.$particular->particular_id.'/batch/'.$batch_no.'/show');
    }

    public function show_bulk($property_id, $particular_id, $batch_no){

        //fetch all the bills with the specified batch no
        // return $bills = DB::table('contracts')
        // ->join('units', 'unit_id_foreign', 'unit_id')
        // ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        // ->join('bills', 'tenant_id', 'bill_tenant_id')
        // ->where('batch_no', $batch_no)
        // ->whereNull('bills.deleted_at')
        // ->groupBy('bill_id')
        // ->orderBy('unit_id')
        // ->count();
           $bills =  DB::table('contracts')
          ->join('units', 'unit_id_foreign', 'unit_id')
          ->join('tenants', 'tenant_id_foreign', 'tenant_id')
          ->join('bills', 'tenant_id', 'bill_tenant_id')
          ->where('bills.property_id_foreign', Session::get('property_id'))
          ->where('contracts.status', 'active')
          ->whereNull('bills.deleted_at')
          ->where('tenants.bill_batch_no', $batch_no)
          ->groupBy('contract_id')
          ->get();

        //get the info of the selected particular
        $particular = Particular::findOrFail($particular_id);

        //get the current electric/water rate
        $electricity_rate = DB::table('property_bills')
        ->where('particular_id_foreign',$particular_id)
        ->where('property_id_foreign', $property_id)
        ->get();

        //get the batch no
        $batch_no = $batch_no;

        return view('webapp.bills.show-bulk',compact('bills', 'particular','batch_no','electricity_rate'));
    }

    public function options_bulk($property_id, $particular_id, $batch_no){

        $particular = Particular::findOrFail($particular_id);
        
        $batch_no = $batch_no;

         $rate = DB::table('property_bills')
         ->where('particular_id_foreign',$particular_id)
         ->where('property_id_foreign', $property_id)
         ->get();

        return view('webapp.bills.options-bulk', compact('particular', 'batch_no','rate'));
    }

    public function update_options_bulk(Request $request, $property_id, $particular_id, $batch_no){

        if($request->start){
            DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('bills.property_id_foreign', Session::get('property_id'))
            ->where('batch_no', $batch_no)
            ->update([
                'start' => $request->start,
            ]);
        }

        if($request->end){
            DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('bills.property_id_foreign', Session::get('property_id'))
            ->where('batch_no', $batch_no)
            ->update([
                'end' => $request->end,
            ]);
        }

        if($request->amount){
            DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('bills', 'tenant_id', 'bill_tenant_id')
            ->where('bills.property_id_foreign', Session::get('property_id'))
            ->where('batch_no', $batch_no)
            ->update([
                'amount' => $request->amount,
            ]);
        }


         //execute if the particular is electricity
          if($particular_id === '3'){
          DB::table('contracts')
          ->join('units', 'unit_id_foreign', 'unit_id')
          ->join('tenants', 'tenant_id_foreign', 'tenant_id')
          ->join('bills', 'tenant_id', 'bill_tenant_id')
          ->where('bills.property_id_foreign', Session::get('property_id'))
          ->where('batch_no', $batch_no)
          ->update([
          'electricity_rate' => $request->electricity_rate,
          ]);

          DB::table('property_bills')
          ->where('property_id_foreign', Session::get('property_id'))
          ->where('particular_id_foreign', $particular_id)
          ->update(
              [
                'rate' => $request->electricity_rate
              ]
              );
          //execute if the particular is water    
          }elseif($particular_id === '2'){
               DB::table('contracts')
               ->join('units', 'unit_id_foreign', 'unit_id')
               ->join('tenants', 'tenant_id_foreign', 'tenant_id')
               ->join('bills', 'tenant_id', 'bill_tenant_id')
               ->where('bills.property_id_foreign', Session::get('property_id'))
               ->where('batch_no', $batch_no)
               ->update([
               'electricity_rate' => $request->water_rate,
               ]);

               DB::table('property_bills')
               ->where('property_id_foreign', Session::get('property_id'))
               ->where('particular_id_foreign', $particular_id)
               ->update(
               [
               'rate' => $request->water_rate
               ]
               );
          }
          

        $bills = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('bills', 'tenant_id', 'bill_tenant_id')
        ->where('bills.property_id_foreign', Session::get('property_id'))
        ->where('batch_no', $batch_no)
        ->get();

        $particular = Particular::findOrFail($particular_id);

             $electricity_rate = DB::table('property_bills')
             ->where('particular_id_foreign',$particular_id)
             ->where('property_id_foreign', $property_id)
             ->get();

        $batch_no = $batch_no;

        return view('webapp.bills.show-bulk',compact('bills', 'particular','batch_no','electricity_rate'));

    }

    

    public function store_bulk_bills(Request $request, $property_id, $particular_id, $batch_no){

        //get the info of the selected particular
        $particular = Particular::findOrFail($particular_id);

        $bills = Bill::where('batch_no', $batch_no)->get();
        
            //execute if the particular is rent
            if($particular_id == '1'){
                //create the bills
                for ($i=$bills->min('bill_no'); $i<=$bills->max('bill_no'); $i++) {
                    //check if the bill exists
                    // if (Bill::where('bill_id', $request->input('bill_id'.$i))->exists()){
                        //update the selected bill
                        Bill::where('bill_id', $request->input('bill_id'.$i))
                        ->update([
                               'amount' => $request->input('rent'.$i),
                               'start' => $request->input('start'.$i),
                               'end' => $request->input('end'.$i),
                               'date_posted' => Carbon::now(),
                               'bill_unit_id' => $request->input('room_id'.$i),
                            ]);
                    // }
                }
            //execute if the particular is water
            }elseif($particular_id == '2'){
            //create the bills
            for ($i=$bills->min('bill_no'); $i<=$bills->max('bill_no'); $i++) {
                //check if the bill exists
                // if (Bill::where('bill_id', $request->input('bill_id'.$i))->exists()){
                //update the selected bill
                Bill::where('bill_id', $request->input('bill_id'.$i))
                ->update([
                'amount' => $request->input('amount'.$i),
                'start' => $request->input('start'.$i),
                'end' => $request->input('end'.$i),
                'date_posted' => Carbon::now(),
                'prev_water_reading' => $request->input('water_previous_reading'.$i),
                'curr_water_reading' => $request->input('water_current_reading'.$i),
                'water_rate' => $request->water_rate,
                'bill_unit_id' => $request->input('room_id'.$i),
                ]);
                // }
                }
                //execute if the particular is electricity
                }elseif($particular_id == '3'){
                for ($i=$bills->min('bill_no'); $i<=$bills->max('bill_no'); $i++) {
                    //check if the bill exists
                    // if (Bill::where('bill_id', $request->input('bill_id'.$i))->exists()){
                        //update the selected bill
                        Bill::where('bill_id', $request->input('bill_id'.$i))
                        ->update([
                                'amount' => $request->input('amount'.$i),
                                'start' => $request->input('start'.$i),
                                'end' => $request->input('end'.$i),
                                'date_posted' => Carbon::now(),
                                'prev_electricity_reading' => $request->input('elecricity_previous_reading'.$i),
                                'curr_electricity_reading' => $request->input('elecricity_current_reading'.$i),
                                'electricity_rate' => $request->electricity_rate,
                                'bill_unit_id' => $request->input('room_id'.$i),
                        ]);
                        // }
                }
            //execute if the particular is not electricity nor water
            }else{
                for ($i=$bills->min('bill_no'); $i<=$bills->max('bill_no'); $i++) {
                //check if bill exists
                    // if (Bill::where('bill_id', $request->input('bill_id'.$i))->exists()){
                        //update the selected bill
                        Bill::where('bill_id', $request->input('bill_id'.$i))
                        ->update([
                                'amount' => $request->input('amount'.$i),
                                'start' => $request->input('start'.$i),
                                'end' => $request->input('end'.$i),
                                'date_posted' => Carbon::now(),
                                'bill_unit_id' => $request->input('room_id'.$i),
                        ]);
                    // }
                }
            }
          
      
    

       //delete bills with 0 values
          Bill::where('amount', 0)
         ->delete();

         $batch_no = $batch_no;

        return redirect('/property/'.Session::get('property_id').'/bills')->with('success', ($bills->count()).' '.$particular->particular.' bills have been posted!');

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

   if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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

   if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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

   if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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

       if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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
       if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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
        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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

        

        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
            return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }else{
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }
        

    }

    public function post_tenant_bill(Request $request, $property_id, $tenant_id)
    {

        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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
            $bill->bill_tenant_id = $tenant_id;
            $bill->bill_no = $current_bill_no++;
            $bill->date_posted = $request->date_posted;
            $bill->particular_id_foreign = $request->input('particular'.$i);
            $bill->start = $request->input('start'.$i);
            $bill->end = $request->input('end'.$i);
            if($request->particular1 === 18){
                $bill->amount = $request->input('amount'.$i) * -1;
            }else{
                $bill->amount = $request->input('amount'.$i);
            }
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
        
        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
            return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }else{
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#bills')->with('success', ($i-1).' bill created successfully.');
        }
    }

    public function post_unit_bill(Request $request, $property_id, $unit_id)
    {
 
        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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
            $bill->particular_id_foreign = $particular->particular_id;
            $bill->particular = $particular->particular;
          
            $bill->start = $request->input('start'.$i);
            $bill->end = $request->input('end'.$i);
            if($request->particular1 === '18'){
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

    public function store(Request $request, $property_id, $unit_id, $tenant_id)
    {
        $request->validate([
           'particular_id_foreign' => 'required',
           'amount' => 'required',
           'start' => 'required',
           'end' => 'required'
        ]);

          //get the last added bill no of the property
          $current_bill_no = DB::table('contracts')
          ->join('units', 'unit_id_foreign', 'unit_id')
          ->join('tenants', 'tenant_id_foreign', 'tenant_id')
          ->join('bills', 'tenant_id', 'bill_tenant_id')
          ->where('property_id_foreign', Session::get('property_id'))
          ->max('bill_no') + 1;   

         //post the additional bill
         Bill::create([
            'bill_no' => $current_bill_no,
            'bill_tenant_id' => $tenant_id,
            'date_posted' => Carbon::now(),
            'particular_id_foreign' => $request->particular_id_foreign,
            'amount'=> $request->amount,
            'start' => $request->start, 
            'end' => $request->start
        ]);

        return back()->with('success', 'Bill is posted successfully!');

        // $active_tenants = DB::table('contracts')
        // ->join('units', 'unit_id_foreign', 'unit_id')
        // ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        // ->select('*', 'contracts.rent as contract_rent')
        // ->where('property_id_foreign', Session::get('property_id'))
        // ->where('contracts.status', 'active')
        // ->count();
        
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
     
        
        //   $no_of_billed = 1;
        //     for($i = 1; $i<=$active_tenants; $i++){
        //        if($request->input('amount'.$i) > 0){
        //         $no_of_billed++;
        //         DB::table('bills')->insert(
        //             [
        //                 'bill_no' => $current_bill_no++,
        //                 'bill_tenant_id' => $request->input('bill_tenant_id'.$i),
        //                 'bill_unit_id' => $request->input('bill_unit_id'.$i),
        //                 'date_posted' => $request->date_posted,
        //                 'start' => $request->input('start'.$i),
        //                 'end' => $request->input('end'.$i),
        //                 'particular' => $request->input('particular'.$i),
        //                 'amount' =>  $request->input('amount'.$i)
        //             ]);
                    
        //             if($request->input('particular'.$i) === 'Electric'){
        //                 $contract =  Contract::find($request->input('contract_id'.$i));
        //                 $contract->initial_electric =  $request->input('current_reading'.$i);
        //                 $contract->save();
        //             }

        //             if($request->input('particular'.$i) === 'Water'){
        //                 $contract =  Contract::find($request->input('contract_id'.$i));
        //                 $contract->initial_water =  $request->input('current_reading'.$i);
        //                 $contract->save();
        //             }

                 

        //             if($request->particular1 === 'Water'){
        //                 DB::table('contracts')
        //                 ->where('contract_id', $request->input('contract_id'.$i))
        //                 ->update(
        //                             [
                                        
        //                                 'initial_water' => $request->input('current_reading'.$i),
        //                             ]
        //                         );
        //             }elseif($request->particular1 === 'Electricity'){
        //                 DB::table('contracts')
        //                 ->where('contract_id', $request->input('contract_id'.$i)) 
        //                 ->update(
        //                             [
                                        
        //                                 'initial_electric' => $request->input('contract_id'.$i),
        //                             ]
        //                         );
        //             }

                 
        //        }
        //     }

            
        // $notification = new Notification();
        // $notification->user_id_foreign = Auth::user()->id;
        // $notification->property_id_foreign = Session::get('property_id');
        // $notification->type = 'bill';
        
        // $notification->message = Auth::user()->name. 'posts '.($no_of_billed-1).' '.$request->particular1.'.';
        // $notification->save();
                    
        //  Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

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

    public function bulk_update(Request $request, $particular_id){
        return $request->all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_tenant_bills($property_id, $tenant_id)
    {

        if(auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 1){
            
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

            if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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

        if(auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 1 ){
      
            $unit = Unit::findOrFail($unit_id);

            $property = Property::findOrFail($property_id);
    
            //get the number of last added bills
   
            if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
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

        if(auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 1){
           
             $bills = Tenant::findOrFail($tenant_id)->bills->count();

            // for ($i=1; $i <= $bills; $i++) { 
            //      $bill = Bill::find( $request->input('billing_id_ctr'.$i));
            //       $bill->start = $request->input('start_ctr'.$i);
            //       $bill->end = $request->input('end_ctr'.$i);
            //       $bill->particular_id_foreign = $request->input('particular_ctr'.$i);
            //       $bill->amount = $request->input('amount_ctr'.$i);
            //      $bill->save();
            //    }

               DB::table('properties')
               ->where('property_id', Session::get('property_id'))
               ->update(
                       [
                           'footer_message' => $request->note,
                       ]
                   );

                   Session::put('footer_message', $request->note);

                //    $tenant = Tenant::findOrFail($tenant_id);

                //     $notification = new Notification();
                //     $notification->user_id_foreign = Auth::user()->id;
                //     $notification->property_id_foreign = Session::get('property_id');
                //     $notification->type = 'bill';
                    
                //     $notification->message = Auth::user()->name.' updates '.$tenant->first_name.' '.$tenant->last_name.' bills.';
                //     $notification->save();

                     Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
             
                    return back()->with('success','Changes saved.');
           
        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    
    public function update_occupant_bills(Request $request, $property_id, $unit_id){


        if(auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 1 ){


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
    public function destroy($bill_id)
    {
        $bill = Bill::findOrFail($bill_id);

        
        $notification = new Notif();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'bill';
        $notification->amount = $bill->amount;
        $notification->message = Auth::user()->name.' deletes bill # '. $bill->bill_no;
        $notification->save();
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

       
         Bill::find($bill_id)->delete();

        return back()->with('success', 'Bill # '.$bill->bill_no.' is deleted successfully.');
    }

    public function export($property_id,$tenant_id)
    {
       $tenant = Tenant::findOrFail($tenant_id);

        $current_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->where('particular_id_foreign', '1')
        ->whereYear('start', Carbon::now()->year)
        ->whereMonth('start', Carbon::now()->month)
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $previous_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_tenant_id', $tenant_id)
        ->whereBetween('start',[Carbon::now()->startOfMonth()->subMonth(100),Carbon::now()->startOfMonth()->subMonth(1)])
        ->where('particular_id_foreign', '1')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();
        
        $previous_surcharges = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bills.property_id_foreign', Session::get('property_id'))
        ->where('bill_tenant_id', $tenant_id)
         ->whereBetween('start',[Carbon::now()->startOfMonth()->subMonth(100),Carbon::now()->startOfMonth()->subMonth(1)])
        ->where('particular_id_foreign', '16')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
        ->get();
        

        $other_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bills.property_id_foreign', Session::get('property_id'))
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('bill_id')
        ->where('particular_id_foreign','!=', '1')
        ->where('particular_id_foreign','!=', '16')
        ->where('particular_id_foreign','!=', '18')
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
        ->where('start', '>=', Carbon::now()->subMonth()->firstOfMonth())
        ->where('particular_id_foreign', '1')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance != 0')
        ->get();

        $previous_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_unit_id', $unit_id)
        ->where('start', '<', Carbon::now()->subMonth()->firstOfMonth())
        ->where('particular_id_foreign', '1')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance != 0')
        ->get();
      
        $previous_surcharges = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_unit_id', $unit_id)
        //->where('start', '<', Carbon::now()->subMonth()->firstOfMonth())
        ->where('particular_id_foreign', '16')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance != 0')
        ->get();

        $other_bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
        ->where('bill_unit_id', $unit_id)
        ->where('particular_id_foreign','!=', '1')
        ->where('particular_id_foreign','!=', '16')
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance != 0')
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
     
        $notification->message = Auth::user()->name.' archives bill '. $billing_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return back()->with('success', 'Bill archived successfully.');
    }
   
}
