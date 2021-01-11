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

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payable';
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' opens payables page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

        
        if( auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'ap'){

            $entry = DB::table('payable_entry')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(5);
     
            $pending = DB::table('payable_request')
             ->join('users', 'requester_id', 'users.id')
             ->join('payable_entry', 'entry_id', 'payable_entry.id')
             ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
            ->where('payable_request.status', 'pending')
            ->where('payable_entry.property_id_foreign', Session::get('property_id'))
            ->get();
     
            $approved = DB::table('payable_request')
            ->join('users', 'requester_id', 'users.id')
            ->join('payable_entry', 'entry_id', 'payable_entry.id')
            ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
           ->where('payable_request.status', 'approved')
           ->where('payable_entry.property_id_foreign', Session::get('property_id'))
           ->get();

           $released = DB::table('payable_request')
           ->join('users', 'requester_id', 'users.id')
           ->join('payable_entry', 'entry_id', 'payable_entry.id')
           ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
          ->where('payable_request.status', 'released')
          ->where('payable_entry.property_id_foreign', Session::get('property_id'))
          ->get();
    
     
          $declined = DB::table('payable_request')
          ->join('users', 'requester_id', 'users.id')
          ->join('payable_entry', 'entry_id', 'payable_entry.id')
          ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
         ->where('payable_request.status', 'declined')
         ->where('payable_entry.property_id_foreign', Session::get('property_id'))
         ->get();

            $property = Property::findOrFail(Session::get('property_id'));
     
             return view('webapp.payables.index', compact('entry','pending','approved','declined','released', 'property'));
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
                $notification->isOpen = '1';
                $notification->message = Auth::user()->name.' adds '.$request->input('entry'.$i).' as an entry in payable.';
                $notification->save();
        }
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

    
        return back()->with('success', 'entries have been saved!');
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
               $notification->isOpen = '1';
               $notification->message = Auth::user()->name. ' requests for funds.';
               $notification->save();

               Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));
       }   
   
       return redirect('property/'.Session::get('property_id').'/payables#payables/')->with('success', 'Request is sent successfully!');
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
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' approves the requested funds for '.$entry.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

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
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' declines the requested funds for '.$entry.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));             

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
        $notification->isOpen = '1';
        $notification->message = Auth::user()->name.' releases the requested funds for '.$entry.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

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
