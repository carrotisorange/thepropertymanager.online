<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Property;
use Carbon\Carbon;
use Session;
use App\Notification;
use App\Payable;

class PayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
        Session::put('current-page', 'payables');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payable';
        
        $notification->message = Auth::user()->name.' opens payables page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        
        if( auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'ap'){
            $entry = DB::table('payable_entry')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('created_at', 'desc')
            ->get();

             $all = DB::table('payable_request')
            ->join('users', 'requester_id', 'users.id')
            ->join('payable_entry', 'entry_id', 'payable_entry.id')
            ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id', 'payable_request.status as payable_status')
           ->where('payable_entry.property_id_foreign', Session::get('property_id'))
           ->orderBy('requested_at', 'desc')
           ->get();
     
            $pending = DB::table('payable_request')
             ->join('users', 'requester_id', 'users.id')
             ->join('payable_entry', 'entry_id', 'payable_entry.id')
             ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id', 'payable_request.status as payable_status')
            ->where('payable_request.status', 'pending')
            ->where('payable_entry.property_id_foreign', Session::get('property_id'))
            ->orderBy('requested_at', 'desc')
            ->get();
     
            $approved = DB::table('payable_request')
             ->join('users', 'requester_id', 'users.id')
             ->join('payable_entry', 'entry_id', 'payable_entry.id')
             ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id', 'payable_request.status as payable_status')
            ->where('payable_request.status', 'approved')
            ->where('payable_entry.property_id_foreign', Session::get('property_id'))
            ->orderBy('requested_at', 'desc')
            ->get();

           $released = DB::table('payable_request')
           ->join('users', 'requester_id', 'users.id')
           ->join('payable_entry', 'entry_id', 'payable_entry.id')
           ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
          ->where('payable_request.status', 'released')
          ->where('payable_entry.property_id_foreign', Session::get('property_id'))
          ->orderBy('released_at', 'desc')
          ->get();
    
     
          $declined = DB::table('payable_request')
          ->join('users', 'requester_id', 'users.id')
          ->join('payable_entry', 'entry_id', 'payable_entry.id')
          ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
         ->where('payable_request.status', 'declined')
         ->where('payable_entry.property_id_foreign', Session::get('property_id'))
         ->orderBy('declined_at', 'desc')
         ->get();
     
             return view('webapp.payables.index', compact('entry','pending','approved','declined','released', 'all'));
         }else{
             return view('layouts.arsha.unregistered');
    }

}

public function action(Request $request, $property_id, $payable_id){
    if($request->payable_option == 'approve'){
        return redirect('/property/'.$request->property_id.'/payable/'.$payable_id.'/approve/');
    }elseif($request->payable_option == 'release'){
        return redirect('/property/'.$request->property_id.'/payable/'.$payable_id.'/release/');
    }elseif($request->payable_option == 'decline'){
        return redirect('/property/'.$request->property_id.'/payable/'.$payable_id.'/decline/');
    }
}

public function entries($property_id){

    $entries = DB::table('payable_entry')
    ->where('property_id_foreign', Session::get('property_id'))
    ->orderBy('created_at', 'desc')
    ->get();

    return view('webapp.payables.entries', compact('entries'));
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
                    'entry' =>  $request->input('entry'.$i),
                    'description' => $request->input('description'.$i),
                    'created_at' => Carbon::now(),
                    'property_id_foreign' => Session::get('property_id'),
                ]);

                $notification = new Notification();
                $notification->user_id_foreign = Auth::user()->id;
                $notification->property_id_foreign = Session::get('property_id');
                $notification->type = 'payable';
                
                $notification->message = Auth::user()->name.' adds '.$request->input('entry'.$i).' as an entry in payable.';
                $notification->save();
        }
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

    
        return back()->with('success', 'Entries are saved successfully.');
    }

    public function request(Request $request){

        $no_of_request = (int) $request->no_of_request;

        // $current_payable_no = DB::table('payable_request')
        // ->where('property_id_foreign',Session::get('property_id'))
        // ->max('no') + 1;
   
       for($i = 1; $i<$no_of_request; $i++){
           DB::table('payable_request')->insert(
               [
                   'entry_id' =>  $request->input('entry'.$i),
                   'amt' =>  $request->input('amt'.$i),
                   'note' =>  $request->input('note'.$i),
                   'requester_id' => Auth::user()->id,
                   'requested_at' => $request->input('requested_at'.$i),
               ]);

               $notification = new Notification();
               $notification->user_id_foreign = Auth::user()->id;
               $notification->property_id_foreign = Session::get('property_id');
               $notification->type = 'payable';
               
               $notification->message = Auth::user()->name. ' requests for funds.';
               $notification->save();

               Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
       }   
   
       return redirect('property/'.Session::get('property_id').'/payables#payables/')->with('success', 'Requests are sent successfully.');
    }

    public function approve(Request $request,  $property_id, $payable_id){

        DB::table('payable_request')
        ->where('id', $payable_id)
        ->update(
                    [
                        'status' => 'approved',
                        'approved_at' => Carbon::now(),
                        'approver_id' => Auth::user()->id,
                    ]
                );

      
        $entry = Payable::findOrFail($payable_id)->amt;
        $date = Payable::findOrFail($payable_id)->requested_at;

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payable';
        
        $notification->message = Auth::user()->name.' approves the requested funds for '.$entry.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

    return redirect('property/'.Session::get('property_id').'/payables#approved/')->with('success', 'request has been approved!');
    }

    public function decline(Request $request , $property_id, $payable_id){

        DB::table('payable_request')
        ->where('id', $payable_id)
        ->update(
                    [
                        'status' => 'declined',
                        'declined_at' => Carbon::now(),
                        'approver_id' => Auth::user()->id,
                    ]
                );

        $entry = Payable::findOrFail($payable_id)->amt;
        $date = Payable::findOrFail($payable_id)->requested_at;

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payable';
        
        $notification->message = Auth::user()->name.' declines the requested funds for '.$entry.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);             

    return redirect('/property/'.$property_id.'/payables#declined/')->with('success', 'request has been declined!');
    }

    public function release(Request $request, $property_id, $payable_id){
        
        DB::table('payable_request')
        ->where('id', $payable_id)
        ->update(
                    [
                        'status' => 'released',
                        'released_at' => Carbon::now(),
                    ]
                );

        $entry = Payable::findOrFail($payable_id)->amt;
        $date = Payable::findOrFail($payable_id)->requested_at;

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payable';
        
        $notification->message = Auth::user()->name.' releases the requested funds for '.$entry.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

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
