<?php

namespace App\Http\Controllers;

use App\Tenant;
use App\Payment;
use Illuminate\Http\Request;
use DB;
use App\Unit;
use App\Personnel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Billing;
use App\Property;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Concern;
use Uuid;
use Illuminate\Support\Str;
use Session;
use App\UserProperty;
use App\Notification;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $property_id)
    {

        $search = $request->tenant_search;

        Session::put('tenant_search', $search);

        if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury' ){
            
            if($search === null){
                $tenants = DB::table('users_properties_relations')
                ->join('properties', 'property_id_foreign', 'property_id')
                ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
                ->select('*', 'tenants.created_at as movein_at')
                ->where('property_id', $property_id)
                ->orderBy('tenant_id', 'desc')
                ->get();
    
                $count_tenants = DB::table('users_properties_relations')
                ->join('properties', 'property_id_foreign', 'property_id')
                ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
                ->where('property_id', $property_id)
                ->count();
            }else{
                $tenants = DB::table('users_properties_relations')
                ->join('properties', 'property_id_foreign', 'property_id')
                ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
                ->select('*', 'tenants.created_at as movein_at')
                ->where('property_id', $property_id)
                ->whereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
                ->orderBy('tenant_id', 'desc')
                ->get();
    
                $count_tenants = DB::table('users_properties_relations')
                ->join('properties', 'property_id_foreign', 'property_id')
                ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
                ->where('property_id', $property_id)
                ->count();
            }

            // return 'under maintenance';
            $property = Property::findOrFail($property_id);

        return view('webapp.tenants.tenants', compact('tenants', 'count_tenants', 'property'));
    }else{
        return view('website.unregistered');
    }
    }

    public function search(Request $request, $property_id){   
        
        $search = $request->get('search');

        //create session for the search
        $request->session()->put(Auth::user()->id.'search_tenant', $search);
        
          if(Auth::user()->email === 'thepropertymanager2020@gmail.com'){

            $tenants = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
         
            ->whereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
            ->orderBy('tenant_id', 'desc')
            ->get();

            $count_tenants = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
        
            ->count();

          }else{

                 $tenants = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
            ->where('property_id', $property_id)
            ->whereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
            ->orderBy('tenant_id', 'desc')
            ->get();

            $count_tenants = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
            ->where('property_id', $property_id)
            ->count();
          }

 
         $property = Property::findOrFail($property_id);

        return view('webapp.tenants.tenants', compact('tenants', 'count_tenants', 'property'));

    }

    public function create_user_access(Request $request, $property_id, $tenant_id){
   
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

      $user_id =  DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'tenant',
            'property' => '',
            'property_type' => '',
            'property_ownership' => '',
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'account_type' => '',
            'created_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
            'trial_ends_at' => '',
        ]);

    DB::table('tenants')
    ->where('tenant_id', $tenant_id)
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


    return back()->with('success', 'Tenant access to the system has been created!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $unit_id)
    {   
        $unit = Unit::findOrFail($unit_id);

        $property = Property::findOrFail($property_id);

        $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('lower_access_user_id', Auth::user()->id)
        ->orWhere('id', Auth::user()->id)  
        ->orderBy('users.name')
        ->get();

         $units = Property::findOrFail($property_id)
        ->units
        ->whereIn('status',['vacant', 'reserved']);


        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign',  Session::get('property_id'))
        ->max('billing_no') + 1;

        return view('webapp.tenants.create', compact('unit', 'property', 'current_bill_no', 'users', 'units'));
    }


    public function create_occupant($property_id, $unit_id)
    {   
        $unit = Unit::findOrFail($unit_id);

        $property = Property::findOrFail($property_id);

        $users = DB::table('users_properties_relations')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'properties.name as property')
        ->where('lower_access_user_id', Auth::user()->id)
        ->orWhere('id', Auth::user()->id)  
        ->orderBy('users.name')
        ->get();

         $units = Property::findOrFail($property_id)
        ->units
        ->whereIn('status',['vacant', 'reserved']);


        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign',  Session::get('property_id'))
        ->max('billing_no') + 1;

        return view('webapp.occupants.create', compact('unit', 'property', 'current_bill_no', 'users', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $unit_id )
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'number_of_months' => ['required'],
            'discount' => ['required'],
            'term' => ['required'],
            'birthdate' => [],
            'gender' => [],
            'form_of_interaction' => [],
            'civil_status' => [],
            'id_number' => [],
            'movein_at' => ['date'],
            'moveout_at' => ['date'],
            'email_address' => ['required', 'string', 'email', 'max:255', 'unique:tenants'],
            'contact_no' => ['required', 'unique:tenants'],
        ]);

        $tenant_unique_id = Str::random(8);

        $tenant_id = DB::table('tenants')->insertGetId(
            [
                'tenant_unique_id' => $tenant_unique_id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name'=> $request->last_name,
                'birthdate'=>$request->birthdate,
                'gender' => $request->gender,
                'civil_status'=> $request->civil_status,
                'id_number' => $request->id_number,
                //contact number
                'contact_no' => $request->contact_no,
                'email_address' => $request->email_address,
                'created_at' => $request->movein_at
            ]
            );

            DB::table('contracts')->insert(
                    [
                        'contract_id' => Uuid::generate()->string,
                        'unit_id_foreign' => $unit_id,
                        'tenant_id_foreign' => $tenant_id,
                        'referrer_id_foreign' => $request->referrer_id,
                        'form_of_interaction' => $request->form_of_interaction,
                        'rent' => $request->rent,
                        'movein_at' => $request->movein_at,
                        'moveout_at' => $request->moveout_at,
                        'discount' => $request->discount,
                        'term' => $request->term,
                        'number_of_months' => $request->number_of_months,
                        'created_at' => $request->movein_at,
                    ]
                );

            
            DB::table('units')
            ->where('unit_id', $unit_id)
            ->update(
                [
                    'status' => 'reserved'
                ]
            );

            $units = DB::table('units')
            ->where('property_id_foreign', $property_id)
            ->where('status','<>','deleted')
            ->count();

            $occupied_units = DB::table('units')
            ->where('property_id_foreign', $property_id)
            ->where('status', 'occupied')
            ->count();

        DB::table('occupancy_rate')
            ->insert(
                        [
                            'occupancy_rate' => ($occupied_units/$units) * 100,
                            'property_id_foreign' => $request->property_id,
                           'occupancy_date' => Carbon::now(),
                           'created_at' => Carbon::now(),
                        ]
                    );

            
                    $no_of_bills = $request->no_of_items;

                    $current_bill_no = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->join('billings', 'tenant_id', 'billing_tenant_id')
                    ->where('property_id_foreign', Session::get('property_id'))
                    ->max('billing_no') + 1;
            
                    for ($i=1; $i < $no_of_bills; $i++) { 
                        $bill = new Billing();
                        $bill->billing_tenant_id = $tenant_id;
                        $bill->billing_no = $current_bill_no++;
                        $bill->billing_date = $request->movein_at;
                        $bill->billing_desc = $request->input('billing_desc'.$i);
                        $bill->billing_start = $request->movein_at;
                        $bill->billing_end = $request->moveout_at;
                        $bill->billing_amt = $request->input('billing_amt'.$i);
                        $bill->save();
                    }

        $user_id =  DB::table('users')->insertGetId([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email_address,
            'user_type' => 'tenant',
            'property' => '',
            'property_type' => '',
            'property_ownership' => '',
            'password' => Hash::make($request->contact_no),
            'created_at' => $request->movein_at,
            'account_type' => '',
            'email_verified_at' => $request->movein_at,
            'trial_ends_at' => '',
        ]);

        DB::table('tenants')
        ->where('tenant_id', $tenant_id)
        ->update([
            'user_id_foreign' => $user_id,
        ]);

        DB::table('users_properties_relations')
        ->insert([
            'property_id_foreign' => $property_id,
            'user_id_foreign' => $user_id,
        ]);

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'success';
        $notification->message = $tenant->first_name.' '.$tenant->last_name.' has been marked as pending!';
        $notification->save();
        
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id)->with('success', 'tenant has been added!');
       

       
    }

    public function store_occupant(Request $request, $property_id, $unit_id )
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['max:255'],
            'last_name' => ['required', 'string', 'max:255'],
    
            'birthdate' => [],
            'gender' => [],
    
            'civil_status' => [],
            'id_number' => [],
        
            'email_address' => ['required', 'string', 'email', 'max:255', 'unique:tenants'],
            'contact_no' => ['required', 'unique:tenants'],
        ]);

        $tenant_unique_id = Str::random(8);

        $tenant_id = DB::table('tenants')->insertGetId(
            [
                'tenant_unique_id' => $tenant_unique_id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name'=> $request->last_name,
                'birthdate'=>$request->birthdate,
                'gender' => $request->gender,
                'civil_status'=> $request->civil_status,
                'id_number' => $request->id_number,
                //contact number
                'contact_no' => $request->contact_no,
                'email_address' => $request->email_address,
                'created_at' => $request->movein_at
            ]
            );

            DB::table('contracts')->insert(
                    [
                        'contract_id' => Uuid::generate()->string,
                        'unit_id_foreign' => $unit_id,
                        'tenant_id_foreign' => $tenant_id,
                        'referrer_id_foreign' => $request->referrer_id,
                        'form_of_interaction' => $request->form_of_interaction,
                        'rent' => $request->rent,
                        'status' => 'pending',
                        'movein_at' => $request->movein_at,
                        'moveout_at' => $request->moveout_at,
                        'discount' => $request->discount,
                        'term' => $request->term,
                        'number_of_months' => $request->number_of_months,
                        'created_at' => $request->movein_at,
                    ]
                );

            
            DB::table('units')
            ->where('unit_id', $unit_id)
            ->update(
                [
                    'status' => 'reserved'
                ]
            );

            $units = DB::table('units')
            ->where('property_id_foreign', $property_id)
            ->where('status','<>','deleted')
            ->count();

            $occupied_units = DB::table('units')
            ->where('property_id_foreign', $property_id)
            ->where('status', 'occupied')
            ->count();

        DB::table('occupancy_rate')
            ->insert(
                        [
                            'occupancy_rate' => ($occupied_units/$units) * 100,
                            'property_id_foreign' => $request->property_id,
                           'occupancy_date' => Carbon::now(),
                           'created_at' => Carbon::now(),
                        ]
                    );

            
                    $no_of_bills = $request->no_of_items;

                    $current_bill_no = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->join('billings', 'tenant_id', 'billing_tenant_id')
                    ->where('property_id_foreign', Session::get('property_id'))
                    ->max('billing_no') + 1;
            
                    for ($i=1; $i < $no_of_bills; $i++) { 
                        $bill = new Billing();
                        $bill->billing_tenant_id = $tenant_id;
                        $bill->billing_no = $current_bill_no++;
                        $bill->billing_date = $request->movein_at;
                        $bill->billing_desc = $request->input('billing_desc'.$i);
                        $bill->billing_start = $request->movein_at;
                        $bill->billing_end = $request->moveout_at;
                        $bill->billing_amt = $request->input('billing_amt'.$i);
                        $bill->save();
                    }

        $user_id =  DB::table('users')->insertGetId([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email_address,
            'user_type' => 'tenant',
            'property' => '',
            'property_type' => '',
            'property_ownership' => '',
            'password' => Hash::make($request->contact_no),
            'created_at' => $request->movein_at,
            'account_type' => '',
            'email_verified_at' => $request->movein_at,
            'trial_ends_at' => '',
        ]);

        DB::table('tenants')
        ->where('tenant_id', $tenant_id)
        ->update([
            'user_id_foreign' => $user_id,
        ]);

        DB::table('users_properties_relations')
        ->insert([
            'property_id_foreign' => $property_id,
            'user_id_foreign' => $user_id,
        ]);

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'success';
        $notification->message = $tenant->first_name.' '.$tenant->last_name.' has been marked as pending!';
        $notification->save();
        
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id)->with('success', 'new tenant has been added!');
       

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $tenant_id)
    {

        if(Auth::user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'treasury'){
           
           $tenant = Tenant::findOrFail($tenant_id);

           $units = Property::findOrFail($property_id)
           ->units()->whereIn('status',['vacant'])
           ->get()->groupBy(function($item) {
                return $item->floor_no;
            });;
    
            $buildings = Property::findOrFail($property_id)
            ->units()
            ->whereIn('status',['vacant'])
            ->select('building', 'status', DB::raw('count(*) as count'))
            ->groupBy('building')
            ->orderBy('building', 'asc')
            ->get('building', 'status','count');

            $contracts = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->select('*', 'contracts.status as contract_status')
            ->where('tenant_id', $tenant_id)
            ->get();

            $guardians = Tenant::findOrFail($tenant_id)->guardians;


              $users = DB::table('users_properties_relations')
             ->join('users','user_id_foreign','id')
            ->where('property_id_foreign', $property_id)
            ->where('user_type','<>' ,'tenant')
            ->get();
    
            $property = Property::findOrFail($property_id);

             $concerns = DB::table('tenants')
           ->join('units', 'unit_id', 'unit_tenant_id')
           ->join('concerns', 'tenant_id', 'concern_tenant_id')
           ->join('users', 'concern_user_id', 'id')
           ->where('tenant_id', $tenant_id)
           ->orderBy('date_reported', 'desc')
           ->orderBy('concern_urgency', 'desc')
           ->orderBy('concern_status', 'desc')
           ->get();

        //    $payments = Tenant::findOrFail($tenant_id)->payments;


        $payments = Billing::leftJoin('payments', 'billings.billing_id', 'payments.payment_billing_id')
        ->where('billing_tenant_id', $tenant_id)
        ->groupBy('payment_id')
        ->orderBy('ar_no', 'desc')
       ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->payment_created)->timestamp;
        });

        //  $payments = DB::table('payments')
        // ->join('billings', 'payment_tenant_id', 'billing_tenant_id')
        // ->where('payment_tenant_id', $tenant_id)
        // ->orderBy('payment_created', 'desc')
        // ->orderBy('ar_no', 'desc')
        // ->groupBy('ar_no')
        // ->get()
        // ->groupBy(function($item) {
        //     return \Carbon\Carbon::parse($item->payment_created)->timestamp;
        // });

            //  $payments = DB::table('units')
            // ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
            // ->leftJoin('billings', 'tenant_id', 'billing_tenant_id')
            // ->leftJoin('payments', 'payment_billing_id', 'billing_id')
            // ->where('tenant_id', $tenant_id)
            // ->orderBy('payment_created', 'desc')
            // ->orderBy('ar_no', 'desc')
            // ->groupBy('payment_id')
            // ->get();
        

            // $collections_count = DB::table('payments')
           
            // ->where('payment_tenant_id', $tenant_id)
            // ->count();

              //get the number of last added bills
       
              $current_bill_no = DB::table('contracts')
              ->join('units', 'unit_id_foreign', 'unit_id')
              ->join('tenants', 'tenant_id_foreign', 'tenant_id')
              ->join('billings', 'tenant_id', 'billing_tenant_id')
              ->where('property_id_foreign',  Session::get('property_id'))
              ->max('billing_no') + 1;

            $balance = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id')
            ->selectRaw('*, billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_id')
            ->orderBy('billing_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();


            $bills = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id')
            ->selectRaw('*, billing_amt - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_id')
            ->orderBy('billing_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();

               $access = DB::table('users')
              ->join('tenants', 'id', 'user_id_foreign')
              ->where('tenant_id', $tenant_id)
              ->get();
            
                return view('webapp.tenants.show', compact('bills','buildings','units','guardians','contracts','access','tenant','users' ,'concerns', 'current_bill_no', 'balance', 'payments', 'property'));  
        }else{
                return view('website.unregistered');
        }
    }

    public function upload_img(Request $request, $property_id, $tenant_id){
        $request->validate([
            'tenant_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

     $extension = $request->tenant_img->getClientOriginalExtension();
    
      $filename = $tenant_id.Str::random(8).'.'.$extension;
    
      $request->tenant_img->storeAs('public/img/tenants', $filename);
    
        DB::table('tenants')
        ->where('tenant_id', $tenant_id)
        ->update(
                [
                    'tenant_img' => $filename
                ]
            );
    
        return back()->with('success', 'image has been uploaded!');
    }

    public function show_billings($unit_id, $tenant_id){

        if(Auth::user()->user_type === 'billing' ||Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager' ){
            
            //get the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $room = Unit::findOrFail($unit_id);
    
            //get the ar number
            $payment_ctr = DB::table('units')
            ->join('tenants', 'unit_id', 'unit_tenant_id')
            ->join('payments', 'tenant_id', 'payment_tenant_id')
            ->where('unit_property', Auth::user()->property)
            ->max('ar_no') + 1;
            

            //get the number of last added bills
         
            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('billings', 'tenant_id', 'billing_tenant_id')
            ->where('property_id_foreign',  Session::get('property_id'))
            ->max('billing_no') + 1;

            //count the number of payments made
            $payments = DB::table('payments')
            ->where('payment_tenant_id', $tenant_id)
            ->where('amt_paid','>',0)
            ->count();

            $balance = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id') 
            ->selectRaw('* ,billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_no')
            ->orderBy('billing_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

            
            $collections = DB::table('units')
            ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
           
            ->leftJoin('billings', 'tenant_id', 'billing_tenant_id')
            ->leftJoin('payments', 'payment_billing_id', 'billing_id')
            ->where('tenant_id', $tenant_id)
            ->orderBy('payment_created', 'desc')
            ->orderBy('ar_no', 'desc')
            ->groupBy('payment_id')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            });
    

            return view('webapp.bills.show-billings', compact('current_bill_no','tenant','payments', 'room', 'balance','payment_ctr', 'collections'));  
        }else{
            return view('website.unregistered');
        }
    }

    public function edit_billings( $unit_id, $tenant_id){

        if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' ){
            
            //get the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $room = Unit::findOrFail($unit_id);
    
            //get the number of last added bills

            $current_bill_no = DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('billings', 'tenant_id', 'billing_tenant_id')
            ->where('property_id_foreign',  Session::get('property_id'))
            ->max('billing_no') + 1;

            $balance = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id') 
            ->selectRaw('* ,billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_no')
            ->orderBy('billing_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

            return view('webapp.bills.edit-billings', compact('current_bill_no','tenant', 'room', 'balance'));  
        }else{
            return view('website.unregistered');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id, $tenant_id)
    {
        $property = Property::findOrFail($property_id);

        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){
            $tenant = Tenant::findOrFail($tenant_id);
            return view('webapp.tenants.edit', compact('tenant', 'property'));
        }else{
            return view('website.unregistered');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$property_id, $tenant_id)
    { 

        DB::table('tenants')
        ->where('tenant_id', $tenant_id)
        ->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'civil_status' => $request->civil_status,
                'id_number' => $request->id_number,

                'contact_no' => $request->contact_no,
                'email_address' => $request->email_address,

                'barangay'=> $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'country' => $request->country,
                'zip_code' => $request->zip_code,


                'high_school' => $request->high_school,
                'high_school_address' =>$request->high_school_address,
                'college_school' => $request->college_school,
                'college_school_address' => $request->college_school_address,
                'course' => $request->course,
                'year_level' => $request->year_level,
                
                'employer' => $request->employer,
                'employer_address' => $request->employer_address,
                'employer_contact_no' => $request->employer_contact_no,
                'job' => $request->job,
                'years_of_employment' => $request->years_of_employment,

                'tenants_note' => $request->tenants_note,

                //  'tenant_status' => 'pending',

                // 'created_at' => null,

                // 'updated_at' => null
        ]);
        
       return redirect('/property/'.$property_id.'/tenant/'.$tenant_id)->with('success','changes have been saved!');
    }
    
    public function request(Request $request, $property_id, $unit_id, $tenant_id){

        $no_of_charges = (int) $request->no_of_charges; 


        DB::table('tenants')
        ->where('tenant_id', $tenant_id)
        ->update(
            [
                'created_at' => Carbon::now(),
                'reason_for_moving_out' => $request->reason_for_moving_out,
                'actual_move_out_date' => $request->actual_move_out_date,
            ]
        );

        //get the number of last added bills

        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign',  Session::get('property_id'))
        ->max('billing_no') + 1;

        for($i = 1; $i<$no_of_charges; $i++){
            DB::table('billings')->insert(
                [
                    'billing_tenant_id' => $request->tenant_id,
                    'billing_no' => $current_bill_no++,
                    'billing_date' => $request->actual_move_out_date,
                    'billing_desc' =>  $request->input('billing_desc'.$i),
                    'billing_amt' =>  $request->input('billing_amt'.$i)
                ]);
        }
            $tenant = Tenant::findOrFail($tenant_id);
            $unit = Unit::findOrFail($unit_id);

            $balance = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_billing_id') 
            ->selectRaw('* ,billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_no')
            ->orderBy('billing_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

           //assign the value of tenant and unit information to variable data
           $data = array(
            'email' => $tenant->email_address,
            'name' => $tenant->first_name,
            'unit' => $unit->building.' '.$unit->unit_no,
            'contract_ends_at'  => $tenant->moveout_date,
            'contract_starts_at'  => $tenant->moveout_date,
            'balance' => $balance
        );

        if($tenant->email_address !== null){
             //send welcome email to the tenant
             Mail::send('webapp.tenants.send-request-moveout-mail', $data, function($message) use ($data){
                $message->to($data['email']);
                $message->bcc(['landleybernardo@thepropertymanager.online','customercare@thepropertymanager.online']);
                $message->subject('Request to Moveout');
            });
        }

        return back()->with('success', 'termination has been initialized!');
    }   

    public function approve(Request $request, $property_id, $unit_id, $tenant_id){

        DB::table('tenants')
        ->where('tenant_id', $tenant_id)
        ->update(
            [
                'updated_at' => Carbon::now(),
                'reason_for_moving_out' => $request->reason_for_moving_out,
                'actual_move_out_date' => $request->actual_move_out_date,
            ]
        );

        return back()->with('success', 'request has been approved!');
    }

    public function extend(Request $request, $property_id, $unit_id, $tenant_id){
        

        $renewal_history = Tenant::findOrFail($tenant_id);

  
        $current_bill_no = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('billings', 'tenant_id', 'billing_tenant_id')
        ->where('property_id_foreign',  Session::get('property_id'))
        ->max('billing_no') + 1;

        //retrieve the number of dynamically created.
        $no_of_items = (int) $request->no_of_items; 
        
        // if number of rows is greater than 1
        if($no_of_items < 1){
            DB::table('tenants')
            ->where('tenant_id', $tenant_id)
            ->update([
                'movein_date' => $request->movein_date, 
                'moveout_date' => Carbon::parse($request->movein_date)->addMonths($request->no_of_months),
                'tenant_status' => 'active',
                'has_extended' => 'renewed',
                'renewal_history' => $renewal_history->renewal_history.', from '.Carbon::parse($request->old_movein_date)->format('M d Y').' to -'.Carbon::parse($request->movein_date)->format('M d Y')
            ]);

            return back()->with('success', 'contract has been extended to '. $request->no_of_months.' months.');

        }else{
            //insert all the additional charges
            for($i = 1; $i<$no_of_items; $i++){
                DB::table('billings')->insert(
                    [
                        'billing_tenant_id' => $request->tenant_id,
                        'billing_no' => $current_bill_no++,
                        'billing_date' => $request->movein_date,
                        'billing_start' =>  $request->input('billing_start'.$i),
                        'billing_end' =>  $request->input('billing_end'.$i),
                        'billing_desc' =>  $request->input('billing_desc'.$i),
                        'billing_amt' =>  $request->input('billing_amt'.$i)
                    ]);
            }

            DB::table('tenants')
            ->where('tenant_id', $tenant_id)
            ->update([
                'movein_date' => $request->movein_date, 
                'moveout_date' => Carbon::parse($request->movein_date)->addMonths($request->no_of_months),
                'tenant_status' => 'pending',
                'has_extended' => 'renewed',
                'renewal_history' => $renewal_history->renewal_history.', from '.Carbon::parse($request->old_movein_date)->format('M d Y').' to '.Carbon::parse($request->movein_date)->format('M d Y')
            ]);
    
            DB::table('units')
            ->where('unit_id', $unit_id)
            ->update([
                'status' => 'reserved'
            ]);

            return back()->with('success', 'contract has been extended to '. $request->no_of_months.' month/s.');
            
        }
    }

    public function add_billings(Request $request){

        $active_tenants = DB::table('tenants')
            ->join('units', 'unit_id', 'unit_tenant_id')
            ->where('unit_property', Auth::user()->property)
            ->where('tenant_status', 'active')
            ->get();

        $delinquent_tenants = DB::table('units')
            ->selectRaw('*,sum(billing_amt) as total_bills')
            ->join('tenants', 'unit_id', 'unit_tenant_id')
            ->join('billings', 'tenant_id', 'billing_tenant_id')
            ->where('unit_property', Auth::user()->property)
            ->whereIn('billing_desc', ['Surcharge', 'Rent'])
            ->where('billing_status', 'unpaid')
            ->where('billing_date', '<', Carbon::now()->addDays(7))
            ->where('billing_amt', '>', 0)
            ->groupBy('tenant_id')
            ->get();

             //get the number of last added bills
     
             $current_bill_no = DB::table('contracts')
             ->join('units', 'unit_id_foreign', 'unit_id')
             ->join('tenants', 'tenant_id_foreign', 'tenant_id')
             ->join('billings', 'tenant_id', 'billing_tenant_id')
             ->where('property_id_foreign',  Session::get('property_id'))
             ->max('billing_no') + 1;
       
        if($request->billing_option === 'rent'){
            return view('billing.add-billings', compact('active_tenants','current_bill_no'));
        }

        if($request->billing_option === 'electric'){
            return view('billing.add-billings-electric', compact('active_tenants','current_bill_no'));
        }

        if($request->billing_option === 'water'){
            return view('billing.add-billings-water', compact('active_tenants','current_bill_no'));
        }

        if($request->billing_option === 'surcharge'){
            return view('billing.add-billings-surcharge', compact('delinquent_tenants','current_bill_no'));
        }
        
    }

    public function post_billings(Request $request){

        if($request->desc1 === 'Surcharge'){
           
            for($i = 1; $i<=$delinquent_tenants->count(); $i++){
                DB::table('billings')->insert(
                    [
                        'billing_no' => $current_bill_no++,
                        'billing_tenant_id' => $request->input('tenant'.$i),
                        'billing_date' => Carbon::now()->addDays(7),
                        'billing_desc' =>  $request->input('desc'.$i),
                        'billing_amt' =>  $request->input('amt'.$i),
                        'details' => $request->input('details'.$i),
                    ]);

                DB::table('tenants')
                    ->where('tenant_id', $request->input('tenant'.$i))
                    ->where('tenant_status', 'active')
                    ->update(
                                [
                                    'tenants_note' => ''
                                ]
                            );
            }

            return redirect('/bills')->with('success', ($i-1).' '.$request->desc1.' bills has been saved!');
            
        }
        else{

        for($i = 1; $i<=$active_tenants->count(); $i++){
            DB::table('billings')->insert(
                [
                    'billing_no' => $current_bill_no++,
                    'billing_tenant_id' => $request->input('tenant'.$i),
                    'billing_date' => Carbon::now()->firstOfMonth(),
                    'billing_desc' =>  $request->input('desc'.$i),
                    'details' => $request->input('details'.$i),
                    'billing_amt' =>  $request->input('amt'.$i)
                ]);

                DB::table('tenants')
                ->where('tenant_id', $request->input('tenant'.$i))
                ->where('tenant_status', 'active')
                ->update(
                            [
                                'tenants_note' => ''
                            ]
                        );
        }
    }
        
        return redirect('/bills')->with('success', ($i-1).' '.$request->desc1.' bills has been saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy($tenant_id)
    {
        DB::table('payments')->where('payment_tenant_id', $tenant_id)->delete();
        DB::table('billings')->where('billing_tenant_id', $tenant_id)->delete();
        DB::table('tenants')->where('tenant_id', $tenant_id)->delete();

        return back()->with('success', 'tenant has been deleted!');
    }

    public function post_reservation(Request $request){
        
        $tenant_id = DB::table('tenants')->insertGetId(
            [
                'unit_tenant_id' => $request->unit_id,
                'tenant_unique_id' => '',
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name'=> $request->last_name,
                'birthdate'=> $request->birthdate,
                'gender' => $request->gender,
                // 'civil_status'=> $request->civil_status,
                // 'id_number' => $request->id_number,

                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'barangay' => $request->barangay,
                'zip_code' => $request->zip_code,

                //contact number
                'contact_no' => $request->contact_no,
                'email_address' => $request->email_address,

                //guardian information
                // 'guardian' => $request->guardian,
                // 'guardian_relationship' => $request->guardian_relationship,
                // 'guardian_contact_no' => $request->guardian_contact_no,

                //rent information
                'tenant_monthly_rent' => $request->tenant_monthly_rent,
                'type_of_tenant' => 'online',
                'tenant_status' => 'pending',
                'movein_date'=> $request->movein_date,
                'moveout_date'=> $request->moveout_date,
    
                
                //information for studentf
                'high_school' => $request->high_school,
                'high_school_address' => $request->high_school_address,
                'college_school' => $request->college_school,
                'college_school_address' => $request->college_school_address,
                'course' => $request->course,
                'year_level' => $request->year_level,
             
                     //information for working
                'employer' => $request->employer,
                'employer_address' => $request->employer_address,
                'job' => $request->job,
                'employer_contact_no' => $request->employer_contact_no,
                'years_of_employment' => $request->years_of_employment,

                'created_at' => Carbon::now(),

                'tenants_note' => 'One of our employee will contact you within the day to confirm your reservation. 
                                    Your reservation will expire after 1 week without payment.'
            
        ]);
            
        //insert billing information of tenant.
        
       $no_of_items = (int) $request->no_of_items; 
        
        for($i = 0; $i<$no_of_items; $i++){
            DB::table('billings')->insert(
                [
                    'billing_tenant_id' => $tenant_id,
                    'billing_date' => $request->movein_date,
                    'billing_desc' =>  $request->input('desc'.$i),
                    'billing_amt' =>  $request->input('amt'.$i)
                ]);
        }

        //web unit status to occupied.
         DB::table('units')->where('unit_id', $request->unit_id)
             ->update(
                        [
                            'status'=> 'reserved',
                            'monthly_rent' => $request->tenant_monthly_rent,
                        ]
                    );

        return redirect($request->unit_property.'/units/'.$request->unit_id.'/tenants/'.$tenant_id.'/reserved')->with('success', 'reservation reservation has been saved!');
    }

    public function get_reservation($properties, $unit_id, $tenant_id){
        
        $tenant = Tenant::findOrFail($tenant_id);

        $unit = Unit::findOrFail($unit_id);

        $billings = DB::table('billings')->where('billing_tenant_id', $tenant_id)->get();

        return view('reservation-forms.get-reservation', compact('tenant', 'unit', 'billings'));
    }

    public function export ($unit_id, $tenant_id, $payment_id,$payment_created){

            $tenant = Tenant::findOrFail($tenant_id);

            $unit = Unit::findOrFail($unit_id);

            $collections = DB::table('units')
                ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
                ->leftJoin('payments', 'tenant_id', 'payment_tenant_id')
                ->leftJoin('billings', 'payment_billing_no', 'billing_no')
                ->where('tenant_id', $tenant_id)
                ->where('payment_created', $payment_created)
                ->orderBy('payment_created', 'desc')
                ->orderBy('ar_no', 'desc')
                ->groupBy('payment_id')
                ->get();

            $balance = Billing::leftJoin('payments', 'billings.billing_no', '=', 'payments.payment_billing_no')
            ->selectRaw('*, billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('billing_tenant_id', $tenant_id)
            ->groupBy('billing_id')

            ->havingRaw('balance > 0')
            ->get();

            $payment = Payment::findOrFail($payment_id);
            
            $data = [
                        'tenant' => $tenant->first_name.' '.$tenant->last_name ,
                        'unit' => $unit->building.' '.$unit->unit_no,
                        'collections' => $collections,
                        'balance' => $balance,
                        'payment_date' => $payment->payment_created,
                        'payment_ar' => $payment->ar_no
                    ];

            $pdf = \PDF::loadView('webapp.collections.export-collections', $data)->setPaper('a5', 'portrait');
      
            return $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-ar'.'.pdf');
    }

}


