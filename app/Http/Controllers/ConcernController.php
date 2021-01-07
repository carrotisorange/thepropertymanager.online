<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, App\Tenant, App\Unit, App\Concern, Auth, Carbon\Carbon;
use App\Property;
use App\Response;
use Session;
use App\Notification;

class ConcernController extends Controller
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
        $notification->type = 'concern';
        $notification->message = 'User '.Auth::user()->id.' opens concerns page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

         $concerns = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->where('property_id_foreign', $property_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

        $property = Property::findOrFail($property_id);

        return view('webapp.concerns.index', compact('concerns', 'property'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_room_concern(Request $request, $property_id, $unit_id)
    {
        $concern = new Concern();
        $concern->reported_at = $request->reported_at;
        $concern->concern_tenant_id = $request->reported_by;
        $concern->concern_unit_id = $unit_id;
        $concern->category = $request->category;
        $concern->urgency = $request->urgency;
        $concern->title = $request->title;
        $concern->details = $request->details;
        $concern->concern_user_id = $request->concern_user_id;
        $concern->save();

        $unit = Unit::findOrFail($unit_id)->unit_no;
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        $notification->message = $unit.' reports a concern.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

        return redirect('/property/'.$property_id.'/home/'.$unit_id.'#concerns')->with('success', 'concern has been saved!');

    }
  
    public function store(Request $request, $property_id, $tenant_id)
    {

        $concern = new Concern();
        $concern->concern_tenant_id = $tenant_id;
        $concern->reported_at = $request->reported_at;
        $concern->category = $request->category;
        $concern->urgency = $request->urgency;
        $concern->title = $request->title;
        $concern->details = $request->details;
        $concern->concern_user_id = $request->concern_user_id;
        $concern->save();

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        $notification->message = 'User '. Auth::user()->id.' adds a concern.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));


            if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#concerns')->with('success', 'concern has been added!');
            }else{
                return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#concerns')->with('success', 'concern has been added!');
            }
            

           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $concern_id)
    {
        
        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'treasury' || auth()->user()->user_type === 'billing'){
        
            // $tenant = Tenant::findOrFail($tenant_id);

            // $unit = Unit::findOrFail($unit_id);

            $concern = Concern::findOrFail($concern_id);

            
            $concern_details = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->where('concern_id', $concern_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->limit(1)
            ->get();

            $personnels = Property::findOrFail($property_id)->personnels;

            $responses = Concern::findOrFail($concern_id)->responses;

            // $responses = DB::table('concerns')
            // ->join('responses', 'concern_id', 'concern_id_foreign')
            // ->select('*', 'responses.created_at as created_at')
            // ->where('concern_id', $concern_id)
            // ->orderBy('responses.created_at', 'desc')
            // ->get();

            $property = Property::findOrFail($property_id);
      
       return view('webapp.concerns.show', compact('concern', 'responses', 'property','concern_details', 'personnels'));
   }else{
       return view('layouts.arsha.unregistered');
   }

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
    public function update(Request $request, $concern_id)
    {
        
        DB::table('concerns')
        ->where('concern_id', $concern_id)
        ->update([
            'reported_at' => $request->reported_at,
            'title' => $request->title,
            'category' => $request->category,
            'details' => $request->details,
            'urgency' => $request->urgency
        ]);

        $concern = Concern::findOrFail($concern_id);    

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        $notification->message = 'User '. Auth::user()->id.' updates concern '.$concern->concern_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

        return back()->with('success', 'changes have been saved!');
    }

    public function pending()
    {
        $pending_concerns = DB::table('contracts')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('concerns', 'tenant_id', 'concern_tenant_id')
        ->join('users', 'concern_user_id', 'id')

        ->where('property_id_foreign', Session::get('property_id'))
        ->where('concerns.status', 'pending')
        ->orderBy('reported_at', 'desc')
        ->orderBy('urgency', 'desc')
        ->orderBy('concerns.status', 'desc')
        ->paginate(5);

        return view('webapp.concerns.pending', compact('pending_concerns'));
    }

    public function closed(Request $request){

        if($request->rating === null || $request->feedback === null){
            return back()->with('danger', 'Please provide a rating and feedback for the employee.');
        }else{
            DB::table('concerns')
            ->where('concern_id', $request->concern_id)
            ->update(
                [
                    'status' => 'closed',
                    'rating' => $request->rating,
                    'feedback' => $request->feedback
                ]
            );

        $concern = Concern::findOrFail($request->concern_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        $notification->message =  'User '.Auth::user()->id.' rates User '.$request->id.' for resolving concern '.$concern->concern_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));
    
        return back()->with('success', 'concern has been closed!');
        }
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
