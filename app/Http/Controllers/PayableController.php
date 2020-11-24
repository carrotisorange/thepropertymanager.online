<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Property;
use Carbon\Carbon;
use Session;

class PayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
        
        if( auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'ap'){

            $entry = DB::table('payable_entry')
            ->where('property_id_foreign', $property_id)
            ->orderBy('created_at', 'desc')
            ->get();
     
            $pending = DB::table('payable_request')
            ->where('property_id_foreign', $property_id)
            ->where('status', 'pending')
            ->get();
     
            $approved = DB::table('payable_request')
            ->where('property_id_foreign', $property_id)
            ->where('status', 'approved')
            ->get();
     
     
            $released = DB::table('payable_request')
            ->where('property_id_foreign', $property_id)
            ->where('status', 'released')
            ->get();
     
             $expense_report = DB::table('payable_request')
             ->where('property_id_foreign', $property_id)
            ->where('status', 'released')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->updated_at)->format('M d Y');
            });
     
     
            $declined = DB::table('payable_request')
            ->where('property_id_foreign', $property_id)
            ->where('status', 'declined')
            ->get();

            $property = Property::findOrFail($property_id);
     
             return view('webapp.payables.payables', compact('entry','pending','approved','declined','released','expense_report', 'property'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $no_of_entry = (int) $request->no_of_entry;

        for($i = 1; $i<$no_of_entry; $i++){
            DB::table('payable_entry')->insert(
                [
                    'payable_entry' =>  $request->input('payable_entry'.$i),
                    'payable_entry_desc' => $request->input('payable_entry_desc'.$i),
                    'property_id_foreign' => $request->property_id,
                    'created_at' => Carbon::now(),
                ]);
        }
    
        return back()->with('success', 'new entry has been saved!');
    }

    public function request(Request $request){

        $no_of_request = (int) $request->no_of_request;

        $current_payable_no = DB::table('payable_request')
        ->where('property_id_foreign',Session::get('property_id'))
        ->max('no') + 1;
   
       for($i = 1; $i<$no_of_request; $i++){
           DB::table('payable_request')->insert(
               [
                   'no' => $current_payable_no++,
                   'entry' =>  $request->input('entry'.$i),
                   'amt' =>  $request->input('amt'.$i),
                   'note' =>  $request->input('note'.$i),
                   'status' => 'pending',
                   'property_id_foreign' => $request->property_id,
                   'requested_by' => Auth::user()->name,
                   'created_at' => Carbon::now(),

               ]);
       }
   
   
       return redirect('property/'.Session::get('property_id').'/payables#payables/')->with('success', 'request has been sent!');
    }

    public function approve(Request $request,  $property_id, $payable_id){
        
        DB::table('payable_request')
        ->where('id', $payable_id)
        ->update(
                    [
                        'status' => 'approved',
                        'updated_at' => Carbon::now(),
                        'approved_by' => Auth::user()->name,
                    ]
                );

    return redirect('property/'.Session::get('property_id').'/payables#approved/')->with('success', 'request has been approved!');
    }

    public function decline(Request $request , $property_id, $payable_id){

        DB::table('payable_request')
        ->where('id', $payable_id)
        ->update(
                    [
                        'status' => 'declined',
                        'updated_at' => Carbon::now(),
                    ]
                );

    return redirect('/property/'.$property_id.'/payables#declined/')->with('success', 'request has been declined!');
    }

    public function release(Request $request, $property_id, $payable_id){
        
        DB::table('payable_request')
        ->where('id', $payable_id)
        ->update(
                    [
                        'status' => 'released',
                        'updated_at' => Carbon::now(),
                    ]
                );

    return redirect('/property/'.$property_id.'/payables#released/')->with('success', 'request has been released!');
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
