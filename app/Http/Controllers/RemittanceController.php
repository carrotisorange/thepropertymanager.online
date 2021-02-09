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


class RemittanceController extends Controller
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
        $notification->type = 'remittance';
        
        $notification->message = Auth::user()->name.' opens remittances page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $rooms = Property::findOrFail(Session::get('property_id'))->units->where('status', '<>', 'deleted');

         $remittances = DB::table('units')
        ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
        ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->select('*', 'remittances.created_at as dateRemitted')
        ->where('isRemitted', 'pending')
        ->where('property_id_foreign',Session::get('property_id'))
        ->get();

        return view('webapp.remittances.index', compact('rooms', 'remittances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $tenant_id, $payment_id)
    {
         $rooms = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->select('*', 'contracts.rent as contract_rent')
        ->where('tenant_id_foreign', $tenant_id)
        ->get();

        $remittance_info = DB::table('bills')
        ->join('payments', 'bill_id', 'payment_bill_id')
        ->where('payment_id', $payment_id)
        ->get();

        $tenant = Tenant::findOrFail($tenant_id);

        return view('webapp.remittances.create', compact('rooms', 'remittance_info', 'tenant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
    public function edit(Remittance $remittance)
    {
        //
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
        $remittance = Remittance::findOrFail($remittance_id);
        $remittance->dateRemitted = $request->dateRemitted;
        $remittance->isRemitted = 'remitted';
        $remittance->save();

        return back()->with('success', 'Remittance is updated successfully!');
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
