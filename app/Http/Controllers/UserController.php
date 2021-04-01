<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, App\User, Carbon\Carbon, Auth, Session;
use Illuminate\Support\Facades\Hash;

use App\Mail\TenantRegisteredMail;
use Illuminate\Support\Facades\Mail;
use App\Property;
use App\Charts\DashboardChart;
use App\Tenant;
use App\Bill;
use App\Concern;
use App\Notification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {

        Session::put('current-page', 'usage-history');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'user';
        
        $notification->message = Auth::user()->name.' opens users page.';
        $notification->save();
                    

        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));;

        $sessions = DB::table('users_properties_relations')
        ->join('users', 'user_id_foreign', 'id')
        ->join('sessions', 'id', 'session_user_id')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->select('*', 'properties.name as property_name', 'users.name as user_name')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('sessions.created_at', 'desc')
        ->get();


            // $sessions = DB::table('sessions')
            // ->join('properties', 'id', 'user_id_property')
            // ->select('*', 'properties.name as property_name', 'users.name as user_name')
            // ->where('property_id', Session::get('property_id'))
     
            // ->get();

           


        return view('webapp.users.index', compact('sessions'));
}

    public function search(Request $request){
        $search = $request->get('search');

        $request->session()->put('search_user', $search);

        $users = DB::table('users')
        ->whereRaw("name like '%$search%' ")
        ->get();

        return view('webapp.users.index', compact('users'));
    }

    public function upgrade(){
      return view('webapp.users.upgrade');
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

    public function create_system_user(){
        
            // return back()->with('danger', 'Exceeded your limit for adding users. Upgrade to Pro to add more users.');
            // $property = Property::findOrFail($property_id);
            return view('webapp.users.system-users.create');

    }

    public function index_system_user(){
       
        //  $users = DB::table('users_properties_relations')
        // ->join('users', 'user_id_foreign', 'id')
        
        // ->where('property_id_foreign', $property_id)
        // ->orWhere('lower_access_user_id', Auth::user()->id)
        // ->get();

        // $users = User::findOrFail(Auth::user()->id)->users;

        $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('lower_access_user_id', Auth::user()->id)
        ->orWhere('id', Auth::user()->id)  
        ->get();

        //     $lower_access = DB::table('users_properties_relations')
        //     ->join('properties', 'property_id_foreign', 'property_id')
        //     ->join('users', 'user_id_foreign', 'lower_access_user_id')
        //     ->select('*', 'properties.name as property')
        //     ->where('lower_access_user_id', Auth::user()->id)
        //     ->get();

        //    $manager_access = DB::table('users_properties_relations')
        //     ->join('properties', 'property_id_foreign', 'property_id')
        //     ->join('users', 'user_id_foreign', 'id')
        //     ->select('*', 'properties.name as property')
        //     ->where('id', Auth::user()->id)
        //     ->get();

        //    $users = $lower_access->merge($manager_access);
    
        return view('webapp.users.system-users.index', compact('users'));
    }

    public function show_system_user($user_id){
        
       $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('id', $user_id)
        ->limit(1)
        ->get();
        
        return view('webapp.users.system-users.show', compact('users'));
    }

    public function edit_system_user($user_id){
        
        $user = User::findOrFail($user_id);

       $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('id', $user_id)
        ->limit(1)
        ->get();

         $properties = User::findOrFail(Auth::user()->id)->properties;
        
        return view('webapp.users.system-users.edit', compact('user','users', 'properties'));
    }

    public function update_system_user(Request $request, $user_id){

      DB::table('users_properties_relations')
      ->insert([
        'user_id_foreign' => $user_id,
        'property_id_foreign' => $request->property_id
      ]);

       $user = User::findOrFail($user_id);
        
        return redirect('/user/'.$user_id.'/edit')->with('success','New user has been added!');
    }

    public function store_system_user(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_type' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

      $user_id =  DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'email_verified_at' =>Carbon::now(),
            'account_type' => Auth::user()->account_type,
            'lower_access_user_id' => Auth::user()->id,
            'trial_ends_at' => Auth::user()->trial_ends_at,
        ]);

        $data = array(
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
            'property' => Session::get('property_name'),
        );

                Mail::send('webapp.users.welcome-generated-mail', $data, function($message) use ($data){
                $message->to([$data['email'], 'customercare@thepropertymanager.online']);
                $message->subject('Welcome New User');
            });      

        return redirect('/user/'.$user_id.'/edit')->with('success', 'New user has been saved!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'property' => Auth::user()->property,
            'property_type' => Auth::user()->property_type,
            'property_ownership' => Auth::user()->property_ownership,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'account_type' => Auth::user()->account_type,
        ]);

 
        return redirect('/users')->with('success', 'New user has been saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $user_id)
    {
        Session::put('current-page', 'usage-history');

        $user = User::findOrFail($user_id);

        $concerns = User::findOrFail($user_id)->concerns;

         $referrals = User::findOrFail($user_id)->referrals;

         $properties = User::findOrFail($user_id)->properties;

        $manager = User::findOrFail(Auth::user()->id);

        $sessions = DB::table('sessions')->where('session_user_id', $user_id)->orderBy('session_last_login_at', 'desc')->get();

        $blogs = DB::table('users')
        ->join('blogs', 'users.id','user_id_foreign')
        ->select('*', 'blogs.created_at as created_at')
        ->orderBy('blogs.id', 'desc')
        ->where('user_id_foreign', Auth::user()->id)
        ->get();

        $property = Property::findOrFail($property_id);

         if(($user->id === Auth::user()->id) || ($manager->user_type === 'manager' && $user->property === $manager->property) || Auth::user()->email === 'thepropertymanager2020@gmail.com'){
            return view('webapp.users.show', compact('referrals','concerns','properties','property','user', 'sessions', 'blogs'));
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
    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);

        $manager = User::findOrFail(Auth::user()->id);

        if(($user->id === Auth::user()->id) || ($manager->user_type === 'manager' && $user->property === $manager->property)){

            return view('webapp.users.edit-user', compact('user'));
        }
        else{
            return view('layouts.arsha.unregistered');
        }

       
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $user_id)
    {

        if($request->password === null){


            DB::table('users')
            ->where('id', $user_id)
            ->update(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'updated_at' => Carbon::now(),
                        'email_verified_at' => Carbon::now()
                      
                    ]
                );

                return back()->with('success', 'Changes saved.');
        }else{
            DB::table('users')
            ->where('id', $user_id)
            ->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->password),
                    'updated_at' => Carbon::now(),
                ]
                );
            
                if(Auth::user()->user_type != 'manager'){
                    Auth::logout();
                    return redirect('/login')->with('success', 'Changes saved.');
                }else{
                    return back()->with('success', 'Changes saved!');
                }
            
          
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
      DB::table('users')->where('id', $id)->delete();
      return redirect('/users')->with('success', 'user has been deleted!');
    }

    public function show_user_tenant(Request $request, $user_id, $tenant_id){

        if($request->property_id === null){
            Session::put('property_id', Session::get('property_id'));
            Session::put('mobile', Session::get('mobile'));
        }else{
            Session::put('property_id', $request->property_id);
            Session::put('mobile', $request->mobile);
        }

        if(($user_id == Auth::user()->id)){

            $tenant = Tenant::findOrFail($tenant_id);

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'tenant';
            
            $notification->message = Auth::user()->name. ' accesses his tenant portal.';
            $notification->save();


            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return view('webapp.tenant_access.index', compact('tenant'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      
      
       
    }

    public function show_bill_tenant($user_id, $tenant_id){

        if(($user_id == Auth::user()->id)){

            $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();

           $tenant = Tenant::findOrFail($tenant_id);

           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'bill';
           
           $notification->message = Auth::user()->name. ' checks his bills.';
           $notification->save();

           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));


            return view('webapp.tenant_access.bills', compact('bills','tenant'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function show_payment_tenant($user_id, $tenant_id){

        if(($user_id == Auth::user()->id)){

            $payments = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('payment_id')
            ->orderBy('ar_no', 'desc')
           ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            });


           $tenant = Tenant::findOrFail($tenant_id);

           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'payment';
           
           $notification->message = Auth::user()->name. ' checks his payments.';
           $notification->save();


           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));


            return view('webapp.tenant_access.payments', compact('payments','tenant'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function show_concern_tenant($user_id, $tenant_id){

        if(($user_id == Auth::user()->id)){

             $concerns = DB::table('concerns')
            ->join('tenants', 'concern_tenant_id', 'tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('tenant_id', $tenant_id)
            ->orderBy('concern_id', 'desc')
            ->get();

           $tenant = Tenant::findOrFail($tenant_id);
            
            $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
           ->where('property_id_foreign', Session::get('property_id'))
           ->where('user_type','<>' ,'tenant')
           ->get();

           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'concern';
           
           $notification->message = Auth::user()->name. ' checks his concerns.';
           $notification->save();


           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return view('webapp.tenant_access.concerns', compact('concerns','tenant','users'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function show_concern_responses($user_id, $tenant_id, $concern_id){

        if(($user_id == Auth::user()->id)){

             $responses = Concern::findOrFail($concern_id)->responses;

             $tenant = Tenant::findOrFail($tenant_id);

             $concern = Concern::findOrFail($concern_id);

             
           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'concern';
           
           $notification->message = Auth::user()->name. ' checks the responses for his concern regarding '.$concern->title.'.';
           $notification->save();


           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return view('webapp.tenant_access.responses', compact('responses','tenant', 'concern'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function store_concern_tenant(Request $request, $user_id, $tenant_id){

        if(($user_id == Auth::user()->id)){

             DB::table('concerns')->insertGetId(
                [
                    'concern_tenant_id' => $tenant_id,
                    'reported_at' => Carbon::now(),
                    'category'=> $request->category,
                    'urgency' => $request->urgency,
                    'title' => $request->title,
                    'details' => $request->details,
                ]);

    
           $tenant = Tenant::findOrFail($tenant_id);

           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'concern';
           $notification->message = Auth::user()->name. ' reports a concern regarding '. $request->category.'.';
           $notification->save();
                   

           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

           return back()->with('success', 'Your concern is successfully reported! Please keep your line open. One of our employees will get back to you.');

         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function show_profile_tenant($user_id, $tenant_id){

        if(($user_id == Auth::user()->id)){

            $user = User::findOrFail($user_id);

            $tenant = Tenant::findOrFail($tenant_id);

            
           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'user';
           
           $notification->message = Auth::user()->name. ' checks his profile.';
           $notification->save();

           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return view('webapp.tenant_access.profile', compact('tenant','user'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function show_update_tenant(Request $request, $user_id, $tenant_id){

        if(($user_id == Auth::user()->id)){
          
        if($request->password === null){


            DB::table('users')
            ->where('id', $user_id)
            ->update(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'updated_at' => Carbon::now()
                      
                    ]
                );
            
            DB::table('tenants')
            ->where('tenant_id', $tenant_id)
            ->update([
                'contact_no'=> $request->contact_no
            ]);

            
           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'user';
           
           $notification->message = Auth::user()->name. ' updates his profile.';
           $notification->save();


           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

            return back()->with('success', 'Changes saved.');
        }else{
            DB::table('users')
            ->where('id', $user_id)
            ->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'updated_at' => Carbon::now(),
                ]
                );
            
                DB::table('tenants')
                ->where('tenant_id', $tenant_id)
                ->update([
                    'contact_no'=> $request->contact_no
                ]);

                
           $notification = new Notification();
           $notification->user_id_foreign = Auth::user()->id;
           $notification->property_id_foreign = Session::get('property_id');
           $notification->type = 'user';
           
           $notification->message = Auth::user()->name. ' updates his password.';
           $notification->save();

  
           Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));
            
                if(Auth::user()->user_type != 'manager'){
                    Auth::logout();
                    return redirect('/login')->with('success', 'New password has been saved!');
                }else{
                    return back()->with('success', 'Changes saved.');
                }
            
          
        } 

            return view('webapp.tenant_access.profile', compact('tenant','user'));
         }else{
             return view('layouts.arsha.unregistered');
         }
      

       
    }

    public function show_room_tenant($user_id, $tenant_id){

          $rooms = DB::table('contracts')
         ->join('units', 'unit_id_foreign', 'unit_id')
        ->select('*', 'contracts.rent as contract_rent', 'contracts.status as contract_status')
         ->where('tenant_id_foreign', $tenant_id)
         ->get();

         $tenant = Tenant::findOrFail($tenant_id);

         
         $notification = new Notification();
         $notification->user_id_foreign = Auth::user()->id;
         $notification->property_id_foreign = Session::get('property_id');
         $notification->type = 'concern';
         
         $notification->message = Auth::user()->name. ' checks his contracts.';
         $notification->save();

  
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('user_id_foreign', Auth::user()->id));

        return view('webapp.tenant_access.contracts', compact('rooms', 'tenant'));
    }

    public function show_portal_tenant(){

        $tenant = User::findOrFail(Auth::user()->id)->access;

        return view('webapp.tenant_access.main', compact('tenant'));
    }
}


