<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Property;
use Auth;
use Session;
use Carbon\Carbon;
use App\Notification;
use App\Bill;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
        Session::put('current-page', 'financial-reports');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'financial';
        
        $notification->message = Auth::user()->name.' opens financials page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);  
       

        $collections = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
        ->select('*',DB::raw('sum(amt_paid) as `total_collections`'),DB::raw('YEAR(payment_created) year'),DB::raw('MONTH(payment_created) month'))
        ->where('property_id_foreign', Session::get('property_id'))
        
       ->groupBy(DB::raw('YEAR(payment_created)'), DB::raw('MONTH(payment_created)'))
        
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
       ->get();

       
       $expenses = DB::table('payable_request')
        ->join('payable_entry', 'entry_id', 'payable_entry.id')
        ->select('*',DB::raw('sum(amt) as `total_expenses`'),DB::raw('YEAR(released_at) year'),DB::raw('MONTH(released_at) month'))
        ->where('payable_request.status', 'released')
        ->where('payable_entry.property_id_foreign', Session::get('property_id'))
         
       ->groupBy(DB::raw('YEAR(released_at)'), DB::raw('MONTH(released_at)'))
        
       ->orderBy('year', 'desc')
       ->orderBy('month', 'desc')
      ->get();

    //   $incomes = DB::table('contracts')
    //   ->leftJoin('units', 'unit_id_foreign', 'unit_id')
    //   ->leftJoin('payments', 'tenant_id_foreign', 'payment_tenant_id')
    //   ->leftJoin('payable_entry', 'units.property_id_foreign', 'payable_entry.property_id_foreign')
    //   ->leftJoin('payable_request', 'payable_entry.id', 'payable_request.entry_id')
    //   ->select('*',DB::raw('sum(payments.amt_paid) as `total_collections`'),DB::raw('sum(payable_request.amt) as `total_expenses`'),DB::raw('YEAR(payment_created) year'),DB::raw('MONTH(payment_created) month'))
    //   ->where('payable_entry.property_id_foreign', Session::get('property_id'))
    //   ->whereNotNull('released_at')
    //  ->groupBy(DB::raw('YEAR(payment_created)'), DB::raw('MONTH(payment_created)'))
      
    //   ->orderBy('year', 'desc')
    //   ->orderBy('month', 'desc')
    //  ->get();
    
        return view('webapp.financials.index', compact(
            'expenses',
            'collections',   
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
