<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Owner, App\Unit, App\Bill;
use Illuminate\Support\Facades\Auth;
use App\Property;
use Illuminate\Support\Facades\Mail;
use App\Mail\OwnerCredentialsMail;
use App\Certificate;
use Uuid;
use Carbon\Carbon;
use Session;
use App\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OwnerController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
        Session::put('current-page', 'owners');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'owner';
        
        $notification->message = Auth::user()->name.' opens owners page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
            $owners = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('owners', 'users_properties_relations.user_id_foreign', 'owners.user_id_foreign')
            ->where('property_id', $property_id)
            ->orderBy('owner_id', 'desc')
            ->paginate(5);
    
            $count_owners = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('owners', 'users_properties_relations.user_id_foreign', 'owners.user_id_foreign')
            ->where('property_id', $property_id)
            ->orderBy('owner_id', 'desc')
            ->count();
        }else{
            $owners = DB::table('certificates')
                ->join('owners', 'owner_id_foreign', 'owner_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->orderBy('owners.name')
                     ->paginate(5);

                $count_owners = DB::table('certificates')
                ->join('owners', 'owner_id_foreign', 'owner_id')
                ->join('units', 'certificates.unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->count();
        }
       

      

        $property = Property::findOrFail($property_id);
        
        return view('webapp.owners.index', compact('owners','count_owners','property'));
    }

    
    public function search(Request $request,$property_id){   
        
        Session::put('current-page', 'owners');

       $search = $request->owner_search;

        Session::put('owner_search', $search);
      
        $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("name like '%$search%' ")
           ->paginate(5);

        $count_owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->count();

        return view('webapp.owners.index', compact('owners', 'count_owners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $room_id)
    {
        $room = Unit::findOrFail($room_id);

        return view('webapp.owners.create', compact('room'));
    }

    public function upload_img(Request $request, $property_id, $owner_id)
    {
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

     $extension = $request->img->getClientOriginalExtension();
    
      $filename = $owner_id.Str::random(8).'.'.$extension;
    
      $request->img->storeAs('public/img/owners', $filename);
    
        DB::table('owners')
        ->where('owner_id', $owner_id)
        ->update(
                [
                    'img' => $filename
                ]
            );
    
        return back()->with('success', 'Image is uploaded successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $unit_id)
    {
        //validate inputs
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'address' => 'required',
            'bank_name' => '',
            'account_number' => '',
            'account_name' => '',
            'representative' => 'required',
            'occupation' => 'required',
            'payment_type' => 'required',
            'price' => 'required'
        ]);

        //store all the input fields to the input
        $input = $request->all();

        //insert a new tenant to the database
        $new_owner_id = Owner::create($input)->owner_id;

    //    Owner::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'mobile' => $request->mobile,
    //         'address' => $request->address,
    //         'bank_name' => $request->bank_name,
    //         'account_number' => $request->account_number,
    //         'account_name' => $request->account_name,
    //         'representative' => $request->representative,
    //    ]);

        Certificate::create([
            'certificate_id' => Uuid::generate()->string,
            'status' => 'active',
            'unit_id_foreign' => $unit_id,
            'owner_id_foreign' => $new_owner_id,
            'payment_type' => $request->payment_type,
            'price' => $request->price
        ]);
      
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'owner';
        
        $notification->message = Auth::user()->name.' adds '.$request->name.' as an owner in '.Unit::findOrFail($unit_id)->unit_no.'.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return redirect('/property/'.$property_id.'/room/'.$unit_id.'/#owners')->with('success', 'Owner is created successfully.');

        // $explode = explode(" ", $request->name);

        // if(count($explode)<=1){
        //      $last_name = 'NULL';
        // }else{
        //      $last_name = '';
        // }

        //  $owner_id = DB::table('owners')
        // ->insertGetId
        // (
        //     [
        //         'name' => $request->name.' '.$last_name,
        //         'email' => $request->owner_email,
        //         'mobile' => $request->mobile,
        //     ]
        //     );

        // $certificate = new Certificate();
        // $certificate->certificate_id = Uuid::generate()->string;
        // $certificate->status = 'active';
        // $certificate->unit_id_foreign = $unit_id;
        // $certificate->owner_id_foreign = $owner_id;
        // $certificate->save();

        // $notification = new Notification();
        // $notification->user_id_foreign = Auth::user()->id;
        // $notification->property_id_foreign = Session::get('property_id');
        // $notification->type = 'owner';
        
        // $notification->message = Auth::user()->name.' adds '.$request->name.' '.$last_name.' as an owner in '.Unit::findOrFail($unit_id)->unit_no.'.';
        // $notification->save();
                    
        //  Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        // return redirect('/property/'.$property_id.'/owner/'.$owner_id.'/edit')->with('success', 'Owner is created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id,$owner_id)
    {
        Session::put('current-page', 'owners');

        if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4){

            $owner = Owner::findOrFail($owner_id);

            $investor_billings = DB::table('units')
           ->join('owners', 'unit_id', 'owner_id')
           ->join('bills', 'owner_id', 'bill_tenant_id')
           ->get();

            $rooms = DB::table('certificates')

           ->join('units', 'certificates.unit_id_foreign', 'unit_id')
           ->select('*', 'units.type as type')
           ->where('owner_id_foreign', $owner_id)
           ->get();

            $all_units = DB::table('units')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('building', 'asc')
            ->orderBy('unit_no', 'asc')
            ->get();

            $access = DB::table('users')
           ->join('owners', 'id', 'user_id_foreign')
           ->select('*', 'users.email as user_email')
           ->where('owner_id', $owner_id)
           ->get();
   
            return view('webapp.owners.show', compact('owner','rooms','access', 'all_units'));
        }else{
            return view('layouts.arsha.unregistered');
        }

       
       
    }

    public function create_owner_credentials($property_id, $owner_id){
        
        $owner = Owner::findOrFail($owner_id);

        return view('webapp.owners.create-credentials', compact('owner'));
    }

    public function store_owner_credentials(Request $request, $property_id, $owner_id){
          $request->validate([
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required'],
          ]);

          $new_user_id =  DB::table('users')->insertGetId([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'unhashed_password' => $request->password,
           'created_at' => Carbon::now(),
           'role_id_foreign' => '7'
           ]);

           DB::table('owners')
           ->where('owner_id', $owner_id)
           ->update([
           'user_id_foreign' => $new_user_id,
           ]);


           DB::table('users_properties_relations')
           ->insert
           (
           [
           'user_id_foreign' => $new_user_id,
           'property_id_foreign' => $property_id,
           ]
           );

           $data = array(
           'email' => $request->email,
           'password' => $request->password,
           'name' => $request->name,
           'property' => Session::get('property_name'),
           );


           Mail::send('webapp.owners.email-credentials-to-owner', $data, function($message) use ($data){
           $message->to([$data['email'], 'lmbernardo@slu.edu.ph']);
           $message->subject('Online Access to Owner Portal');
           });

      return redirect('/property/'.Session::get('property_id').'/owner/'.$owner_id.'/#credentials')->with('success', 'Owner"s credentials is successfully created!');

    }

    public function create_user_access(Request $request, $property_id, $owner_id){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

      $user_id =  DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'role_id_foreign' => '7',
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

         $data = array(
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
            'property' => Session::get('property_name'),
        );

        
                Mail::send('webapp.owners.email-credentials-to-owner', $data, function($message) use ($data){
                $message->to([$data['email'], 'thepropertymanagernoreply@gmail.com']);
                $message->subject('Online Access to Owner Portal');
            });      
                                  

    return redirect('/property/'.Session::get('property_id').'/owner/'.$owner_id.'/#user')->with('success', 'Access to the system is sent to the owner!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id,$owner_id)
    {

        Session::put('current-page', 'owners');

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
    public function destroy($property_id, $owner_id)
    { 
        DB::table('owners')->where('owner_id', $owner_id)->delete();
        DB::table('certificates')->where('owner_id_foreign', $owner_id)->delete();

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'owner';
        
        $notification->message = Auth::user()->name.' deletes an owner.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
        

        return back()->with('success', 'Owner is deleted successfully.');
    }
}
