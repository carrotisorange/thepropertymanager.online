<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Owner, App\Unit, App\Bill;
use Illuminate\Support\Facades\Auth;
use App\Property;
use App\Certificate;
use Uuid;
use Carbon\Carbon;
use Session;
use App\Notification;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
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
        $notification->type = 'owner';
       
        $notification->message = Auth::user()->name.' opens owners page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->get();

        $count_owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->count();

        $property = Property::findOrFail($property_id);
        
        return view('webapp.owners.index', compact('owners','count_owners','property'));
    }

    
    public function search(Request $request,$property_id){   
        
       $search = $request->owner_search;

        Session::put('owner_search', $search);
      
        $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("name like '%$search%' ")
        ->get();

        $count_owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("name like '%$search%' ")
        ->count();

         $property = Property::findOrFail($property_id);

        return view('webapp.owners.index', compact('owners', 'count_owners', 'property'));

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
    public function store(Request $request, $property_id, $unit_id)
    {
   

        $explode = explode(" ", $request->name);

        if(count($explode)<=1){
             $last_name = 'NULL';
        }else{
             $last_name = '';
        }

         $owner_id = DB::table('owners')
        ->insertGetId
        (
            [
                'name' => $request->name.' '.$last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
            ]
            );

        $certificate = new Certificate();
        $certificate->certificate_id = Uuid::generate()->string;
        $certificate->status = 'active';
        $certificate->unit_id_foreign = $unit_id;
        $certificate->owner_id_foreign = $owner_id;
        $certificate->save();

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'owner';
       
        $notification->message = Auth::user()->name.' adds '.$request->name.' '.$last_name.' as an owner in '.Unit::findOrFail($unit_id)->unit_no.'.';
        $notification->save();
                    
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return redirect('/property/'.$property_id.'/owner/'.$owner_id.'/edit')->with('success', 'Owner is created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id,$owner_id)
    {
        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){

            $owner = Owner::findOrFail($owner_id);

            $investor_billings = DB::table('units')
           ->join('owners', 'unit_id', 'owner_id')
           ->join('bills', 'owner_id', 'bill_tenant_id')
           ->get();

           $rooms = DB::table('certificates')
           ->join('units', 'certificates.unit_id_foreign', 'unit_id')
           ->where('owner_id_foreign', $owner_id)
           ->get();

            $access = DB::table('users')
           ->join('owners', 'id', 'user_id_foreign')
           ->where('owner_id', $owner_id)
           ->get();
   
            return view('webapp.owners.show', compact('owner','rooms','access'));
        }else{
            return view('layouts.arsha.unregistered');
        }

       
       
    }

    public function create_user_access(Request $request, $property_id, $owner_id){
   
         $request->all();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

      $user_id =  DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'owner',
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'account_type' => Auth::user()->account_type,
            'created_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
            'trial_ends_at' => Auth::user()->trial_ends_at,
        ]);

    DB::table('owners')
    ->where('owner_id', $owner_id)
    ->update([
        'user_id_foreign' => $user_id,
    ]);


    DB::table('users_properties_relations')
                          ->insert
                                  (
                                      [
                                          'user_id_foreign' => $user_id,
                                        
                                          'property_id_foreign' => $property_id,
                                      ]
                                  );      
                                  

    return redirect('/property/'.Session::get('property_id').'/owner/'.$owner_id.'/#user')->with('success', 'Credentials are created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id,$owner_id)
    {
        $owner = Owner::findOrFail($owner_id);

        $property = Property::findOrFail($property_id);
        
        return view('webapp.owners.edit', compact('owner', 'property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $owner_id)
    {

        DB::table('owners')
        ->where('owner_id',$owner_id )
        ->update([
            'name' => $request->unit_owner,
            'mobile' => $request->investor_contact_no,
            'email' => $request->investor_email_address,
            'address' => $request->investor_address,
            'representative' => $request->investor_representative,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        DB::table('certificates')
        ->where('owner_id_foreign', $owner_id)
        ->update([
            'date_purchased' => $request->date_purchased,
            'price' => $request->price,
            'payment_type' => $request->payment_type, 
            'updated_at' => Carbon::now()
        ]);
           
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'owner';
       
        $notification->message = Auth::user()->name.' updates '.$request->unit_owner.' profile.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return redirect('/property/'.$property_id.'/owner/'.$owner_id)->with('success', 'Changes saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('owners')->where('owner_id', $id)->delete();

        return back();
    }
}
