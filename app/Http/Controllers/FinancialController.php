<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Property;
use Auth;
use Session;
use Carbon\Carbon;
use App\Notification;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'financial';
        
        $notification->message = Auth::user()->name.' opens financials page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);


        $collection_rate_1 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->endOfMonth())
->where('property_id_foreign', Session::get('property_id'))
->sum('amt_paid');


$collection_rate_2 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonth()->endOfMonth())
 ->where('property_id_foreign',Session::get('property_id'))
->sum('amt_paid');



$collection_rate_3 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(2)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

$collection_rate_4 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(3)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

$collection_rate_5 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(4)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

 $collection_rate_6 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(5)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');



$expenses_1 = DB::table('payable_request')
 ->join('users', 'requester_id', 'users.id')
 ->join('payable_entry', 'entry_id', 'payable_entry.id')
 ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->firstOfMonth())
->where('released_at', '<=', Carbon::now()->endOfMonth())
->sum('amt');

$expenses_2 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonth()->endOfMonth())
->sum('amt');

$expenses_3 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
->sum('amt');

$expenses_4 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
->sum('amt');

$expenses_5 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
->sum('amt');

$expenses_6 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
->sum('amt');



        $property = Property::findOrFail($property_id);
    
        return view('webapp.financials.financials', compact(
            'property',
            'collection_rate_6',
            'collection_rate_5',
            'collection_rate_4',
            'collection_rate_3',
            'collection_rate_2',
            'collection_rate_1',
             'expenses_6',
            'expenses_5',
            'expenses_4',
            'expenses_3',
            'expenses_2',
            'expenses_1',
        ));
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
