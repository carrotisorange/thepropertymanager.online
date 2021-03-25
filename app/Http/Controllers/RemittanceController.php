<?php

namespace App\Http\Controllers;

use App\Remittance;
use Illuminate\Http\Request;
use App\Bill;
use Session;
use App\Property;
use Uuid;
use DB;
use App\Notification;
use Auth;
use App\Tenant;
use App\Expense;
use Carbon\Carbon;
use App\Contract;
use App\Unit;
use App\Owner;
use App\Room;
use App\Payment;

class RemittanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('current-page', 'remittances');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'remittance';
        
        $notification->message = Auth::user()->name.' opens remittances page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $rooms = Property::findOrFail(Session::get('property_id'))->units->where('status', '<>', 'deleted');

         $all_remittances = DB::table('units')
        ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
        ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->select('*', 'remittances.created_at as prepared_at')
        ->where('property_id_foreign',Session::get('property_id'))
        ->orderBy('remittances.created_at')
        ->get();

         $pending_remittances = DB::table('units')
        ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
        ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->select('*', 'remittances.created_at as prepared_at')
        ->where('property_id_foreign',Session::get('property_id'))
        ->whereNull('remitted_at')
        ->orderBy('remittances.created_at')
        ->get();

         $deposited_remittances = DB::table('units')
        ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
        ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->select('*', 'remittances.created_at as prepared_at')
        ->where('property_id_foreign',Session::get('property_id'))
        ->whereNotNull('remitted_at')
        ->orderBy('remittances.created_at')
        ->get();

        return view('webapp.remittances.index', compact('rooms', 'all_remittances', 'pending_remittances', 'deposited_remittances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id,$unit_id, $contract_id, $tenant_id, $bill_id, $payment_id)
    {

        Session::put('current-page', 'remittances');

        $owner_id = Unit::findOrFail($unit_id)->certificates()->orderBy('created_at', 'desc')->first()->owner_id_foreign;

        $owner_info = Owner::findOrFail($owner_id);

        $room_info = Unit::findOrFail($unit_id);

        $amount_collected = Bill::findOrFail($bill_id)->payments->sum('amt_paid');

        $payment_info = Payment::findOrFail($payment_id);

        $bill_info = Bill::findOrFail($bill_id);

        $contract_info = Contract::findOrFail($contract_id);

        $tenant_info = Tenant::findOrFail($tenant_id);

        return view('webapp.remittances.create', compact('owner_info', 'room_info', 'amount_collected', 'bill_info', 'tenant_info', 'payment_info', 'contract_info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request, $property_id,$unit_id, $contract_id, $tenant_id, $bill_id, $payment_id){
        
        $bill_info = Bill::findOrFail($bill_id);

        $remittance_id = Uuid::generate()->string;

       DB::table('remittances')->insert([
            'remittance_id' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'amt_remitted' => $request->amount_to_be_remitted,
            'particular' => 'rent',
            'prepared_by' => Auth::user()->name,
            'start_at' => $bill_info->start,
            'end_at' => $bill_info->end,
            'created_at' => $request->date,
            'cv_number' => $request->cv_number,
            'check_number' => $request->check_number.'-'.$request->bank
        ]);

        //mgmt fee
        if($request->mgmt_fee_amt>0){
            DB::table('expenses')->insert([
                'expense_id' => Uuid::generate()->string,
                'remittance_id_foreign' => $remittance_id,
                'unit_id_foreign' => $unit_id,
                'expense_particular' => 'Mgmt Fee - '.$request->mgmt_fee_desc,
                'expense_amt' => $request->mgmt_fee_amt,
                'created_at' => $request->date,
            ]);
        }
       
         //purchased_amt
         if($request->purchased_amt>0){
            DB::table('expenses')->insert([
                'expense_id' => Uuid::generate()->string,
                'remittance_id_foreign' => $remittance_id,
                'unit_id_foreign' => $unit_id,
                'expense_particular' => 'Purchases - '.$request->purchased_desc,
                'expense_amt' => $request->purchased_amt,
                'created_at' => $request->date,
            ]);
            }

         //contractor_and_transformer_desc
         if($request->contractor_and_transformer_amt>0){
            DB::table('expenses')->insert([
                'expense_id' => Uuid::generate()->string,
                'remittance_id_foreign' => $remittance_id,
                'unit_id_foreign' => $unit_id,
                'expense_particular' => 'Contractor/Transformer - '.$request->contractor_and_transformer_desc,
                'expense_amt' => $request->contractor_and_transformer_amt,
                'created_at' => $request->date,
            ]);
            }

         //cable_amt
         if($request->cable_amt>0){
            DB::table('expenses')->insert([
                'expense_id' => Uuid::generate()->string,
                'remittance_id_foreign' => $remittance_id,
                'unit_id_foreign' => $unit_id,
                'expense_particular' => 'Cable - '.$request->cable_desc,
                'expense_amt' => $request->cable_amt,
                'created_at' => $request->date,
            ]);
            }
    
             //general_cleaning_amt
        if($request->general_cleaning_amt>0){
            DB::table('expenses')->insert([
                'expense_id' => Uuid::generate()->string,
                'remittance_id_foreign' => $remittance_id,
                'unit_id_foreign' => $unit_id,
                'expense_particular' => 'General Cleaning - '.$request->general_cleaning_desc,
                'expense_amt' => $request->general_cleaning_amt,
                'created_at' => $request->date,
            ]);
            }

        //laundry_amt
        if($request->purchased_amt>0){
        DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Laundry - '.$request->laundry_desc,
            'expense_amt' => $request->laundry_amt,
            'created_at' => $request->date,
        ]);
        }

        //real_property_tax_amt
        if($request->real_property_tax_amt>0){
        DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Real Property Tax - '.$request->real_property_tax_desc,
            'expense_amt' => $request->real_property_tax_amt,
            'created_at' => $request->date,
        ]);
        }

         //bladder_tank
         if($request->bladder_tank_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Bladder Tank - '.$request->bladder_tank_desc,
            'expense_amt' => $request->bladder_tank_amt,
            'created_at' => $request->date,
        ]);
         }

         //pest_control
         if($request->pest_control_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Pest Control - '.$request->pest_control_desc,
            'expense_amt' => $request->pest_control_amt,
            'created_at' => $request->date,
        ]);
         }

         //water_desc
         if($request->water_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Water - '.$request->water_desc,
            'expense_amt' => $request->water_amt,
            'created_at' => $request->date,
        ]);
         }

         //electric_desc
         if($request->electric_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Electric - '.$request->electric_desc,
            'expense_amt' => $request->electric_amt,
            'created_at' => $request->date,
        ]);
         }

         //surcharge_desc
         if($request->surcharge_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Surcharge - '.$request->surcharge_desc,
            'expense_amt' => $request->surcharge_amt,
            'created_at' => $request->date,
        ]);
         }

         //building_insurance
         if($request->building_insurance_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Building Insurance - '.$request->building_insurance_desc,
            'expense_amt' => $request->building_insurance_amt,
            'created_at' => $request->date,
        ]);
         }

         //condo_dues
         if($request->condo_dues_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Condo Dues - '.$request->condo_dues_desc,
            'expense_amt' => $request->condo_dues_amt,
            'created_at' => $request->date,
        ]);
         }

         //unpaid_balances
         if($request->unpaid_balances_amt>0){
         DB::table('expenses')->insert([
            'expense_id' => Uuid::generate()->string,
            'remittance_id_foreign' => $remittance_id,
            'unit_id_foreign' => $unit_id,
            'expense_particular' => 'Unpaid Balance - '.$request->unpaid_balances_desc,
            'expense_amt' => $request->unpaid_balances_amt,
            'created_at' => $request->date,
        ]);
        }
        return back()->with('success', 'Remittance prepared successfully.');
        

     }

    public function asd(Request $request)
    {
        
       $no_of_bills = $request->no_of_bills;

       $remittance_id = Uuid::generate()->string;
       $total_expenses = 0;

        DB::table('remittances')->insertGetId([
        'remittance_id' => $remittance_id,
        'isRemitted' => 'pending',
        'unit_id_foreign' => $request->unit_id,
        'amt_remitted' => $request->amt,
        'start' => $request->start,
        'end' => $request->end,
        'particular' => $request->particular,
        'created_at' => Carbon::now(),
        
    ]);

    for ($i=1; $i < $no_of_bills; $i++) { 
        $expense = new Expense();
        $expense->expense_id = Uuid::generate()->string;
        $expense->unit_id_foreign = $request->unit_id;
        $expense->remittance_id_foreign = $remittance_id;
        $expense->expense_particular = $request->input('particular'.$i);
        $expense->expense_amt = $request->input('amount'.$i);
        $expense->save();

        $total_expenses = $request->input('amount'.$i) + $total_expenses;
    }

        $remittance = Remittance::findOrFail($remittance_id);
        $remittance->amt_remitted = $request->amt-$total_expenses;
        $remittance->save();

        return back()->with('success', 'Remittance is created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $room_id, $remittance_id)
    {

        Session::put('current-page', 'remittances');

        $remittance = DB::table('units')
        ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
        ->select('*', 'remittances.created_at as dateRemitted')
        ->where('remittance_id',$remittance_id)
        ->get();
     
        return view('webapp.remittances.show', compact('remittance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function edit(Remittance $remittance, $property_id, $room_id,$remittance_id)
    {
        $remittance = Remittance::findOrFail($remittance_id);

        $room = Unit::findOrFail($room_id);

        return view('webapp.remittances.edit', compact('remittance', 'room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $remittance_id)
    {
        DB::table('remittances')
        ->where('remittance_id', $remittance_id)
        ->update(
            [
                'remitted_at' => $request->remitted_at,
            ]
        );

        return back()->with('success', 'Remittance is updated successfully!');
    }

    public function rooms_remittances($property_id){
        
        Session::put('current-page', 'rooms');

        $units = Property::findOrFail($property_id)->units;

        return view('webapp.remittances.rooms_remittances', compact('units'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remittance $remittance)
    {
        //
    }
}
