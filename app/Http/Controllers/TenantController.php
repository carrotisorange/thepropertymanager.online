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
use App\Mail\UserRegisteredMail;
use App\Bill;
use App\Property;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Concern;
use Uuid;
use Illuminate\Support\Str;
use Session;
use App\UserProperty;
use App\Notification;
use App\OccupancyRate;
use App\Contract;

class TenantController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $property_id)
    {
        Session::put('current-page', 'tenants');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'tenant';
        
        $notification->message = Auth::user()->name.' opens tenants page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $search = $request->tenant_search;

        Session::put('tenant_search', $search);

        $tenant_status = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->select('*', 'contracts.status as contract_status')
         ->where('property_id_foreign', Session::get('property_id'))
         ->select('contracts.status', DB::raw('count(*) as count'))
         ->groupBy('contracts.status')
         ->get('contracts.status','count');

         $count_tenants = DB::table('contracts')
         ->join('units', 'unit_id_foreign', 'unit_id')
         ->join('tenants', 'tenant_id_foreign', 'tenant_id')
         ->where('property_id_foreign', Session::get('property_id'))
         ->count();
      
        if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 5 ){
            
            if($search === null){
               if(Session::get('status')){
                 $tenants = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->select('*', 'contracts.status as contract_status')
                 ->where('property_id_foreign', Session::get('property_id'))
                 ->where('contracts.status', Session::get('status'))
                ->orderBy('tenant_id', 'desc')
                ->paginate(5);

                $count_tenants = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                 ->where('property_id_foreign', Session::get('property_id'))
                 ->where('contracts.status', Session::get('status'))
                ->count();
               }else{
                 $tenants = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->select('*', 'contracts.status as contract_status')
                ->where('property_id_foreign', Session::get('property_id'))
                ->orderBy('tenant_id', 'desc')
                ->paginate(5);
               }

            }else{

                if(Session::get('status')){
                     $tenants = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->select('*', 'contracts.status as contract_status')
                     ->where('property_id_foreign', Session::get('property_id'))
                     ->whereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
                     ->where('contracts.status', Session::get('status'))
                     ->orderBy('tenant_id', 'desc')
                          ->paginate(5);

                    $count_tenants = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->where('property_id_foreign', Session::get('property_id'))
                    ->where('contracts.status', Session::get('status'))
                    
                    ->count();
    
                   }else{
                      $tenants = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->select('*', 'contracts.status as contract_status')
                     ->where('property_id_foreign', Session::get('property_id'))
                     ->whereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
                     ->orderBy('tenant_id', 'desc')
                    ->paginate(5);
                   }
             }
        return view('webapp.tenants.index', compact('tenants', 'count_tenants', 'tenant_status'));
    }else{
        return view('layouts.arsha.unregistered');
    }
    }

    public function filter(Request $request, $property_id)
    {
        Session::put('current-page', 'tenants');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'tenant';
        
        $notification->message = Auth::user()->name.' filters tenants page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $search = $request->tenant_search;

        Session::put('tenant_search', $search);

        $tenant_status = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->select('*', 'contracts.status as contract_status')
         ->where('property_id_foreign', Session::get('property_id'))
         ->select('contracts.status', DB::raw('count(*) as count'))
         ->groupBy('contracts.status')
         ->get('contracts.status','count');

         $count_tenants = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->where('property_id_foreign', Session::get('property_id'))
                   
                    
                    ->count();
      

        if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 5 ){
            
            if($search === null){
               if($request->tenant_status){
                $tenants = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->select('*', 'contracts.status as contract_status')
                 ->where('property_id_foreign', Session::get('property_id'))
                 ->where('contracts.status', $request->tenant_status)
                ->orderBy('tenant_id', 'desc')
                      ->paginate(5);

              
               }else{
                $tenants = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->select('*', 'contracts.status as contract_status')
                 ->where('property_id_foreign', Session::get('property_id'))
                
                ->orderBy('tenant_id', 'desc')
                     ->paginate(5);

               
               }

            }else{

                if($request->tenant_status){
                    $tenants = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->select('*', 'contracts.status as contract_status')
                     ->where('property_id_foreign', Session::get('property_id'))
                     ->where("concat(first_name, ' ', last_name) like '%$search%' ")
                     ->where('contracts.status', $request->tenant_status)
                     ->orderBy('tenant_id', 'desc')
                          ->paginate(5);

                        
                    
    
                   }else{
                    $tenants = DB::table('contracts')
                    ->join('units', 'unit_id_foreign', 'unit_id')
                    ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                    ->select('*', 'contracts.status as contract_status')
                     ->where('property_id_foreign', Session::get('property_id'))
                     ->where("concat(first_name, ' ', last_name) like '%$search%' ")
                    
                     ->orderBy('tenant_id', 'desc')
                    ->paginate(5);

                        
                    
                   }
             }
        return view('webapp.tenants.index', compact('tenants', 'count_tenants', 'tenant_status'));
    }else{
        return view('layouts.arsha.unregistered');
    }
    }

    public function pending($property_id){

        Session::put('current-page', 'dashboard');

        $tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->where('contracts.status', 'pending')
        ->get();

        return view('webapp.tenants.pending', compact('tenants'));
    }

    public function search(Request $request, $property_id){   
        
        Session::put('current-page', 'tenants');

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

        return view('webapp.tenants.index', compact('tenants', 'count_tenants', 'property'));

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
            'role_id_foreign' => '6',
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'account_type' => Auth::user()->account_type,
            'created_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
            'trial_ends_at' => Auth::user()->trial_ends_at,
        ]);

    DB::table('tenants')
    ->where('tenant_id', $tenant_id)
    ->F([
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


            return redirect('/property/'.$request->property_id.'/tenant/'.$tenant_id)->with('success', 'Credentials created successfully.');
                                  

    return back()->with('success', 'Credentials are created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $unit_id)
    {   
        Session::put('current-page', 'tenants');

        $room = Unit::findOrFail($unit_id);

        return view('webapp.tenants.create', compact('room'));

        // Session::put('current-page', 'rooms');

        // $unit = Unit::findOrFail($unit_id);

        // $users = DB::table('users_properties_relations')
        // ->join('properties', 'property_id_foreign', 'property_id')
        // ->join('users', 'user_id_foreign', 'id')
        // ->select('*', 'properties.name as property')
        // ->where('lower_access_user_id', Auth::user()->id)
        // ->orWhere('id', Auth::user()->id)  
        // ->orderBy('users.name')
        // ->get();

        //  $units = Property::findOrFail(Session::get('property_id'))
        // ->units
        // ->whereIn('status',['vacant', 'reserved']);

        // if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
        //     $current_bill_no = DB::table('units')
        //     ->join('bills', 'unit_id', 'bill_unit_id')
        //     ->where('property_id_foreign', Session::get('property_id'))
        //     ->max('bill_no') + 1;
    
        // }else{
        //     $current_bill_no = DB::table('contracts')
        //     ->join('units', 'unit_id_foreign', 'unit_id')
        //     ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        //     ->join('bills', 'tenant_id', 'bill_tenant_id')
        //     ->where('property_id_foreign', Session::get('property_id'))
        //     ->max('bill_no') + 1;
        // }     

        // return view('webapp.tenants.create', compact('unit', 'current_bill_no', 'users', 'units'));
    }


    public function create_occupant_prefilled($property_id, $unit_id)
    {   
        Session::put('current-page', 'tenants');

        $unit = Unit::findOrFail($unit_id);

        $property = Property::findOrFail($property_id);

        return view('webapp.occupants.create', compact('property', 'unit'));
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
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required'],
            'gender' => ['required'],
            'civil_status' => ['required'],
            'email' => 'required|email',
            'contact_no' => ['required'],
            'provincial_address' => ['required'],
            'ethnicity' => ['required'],
            'nationality' => ['required'],
            'id_number' => ['required']
       ]);

        //get the last tenant_id
        $latest_tenant_id = Tenant::all()->max('tenant_id')+1;

        //generate 8-digit string
        $tenant_unique_id = Str::random(8);

        //concatenate the last_tenant_id and tenant_unique_id
        $tenant_unique_id = $latest_tenant_id.$tenant_unique_id;

        //store all the input fields to the input
        $input = $request->all();

        //insert a new tenant to the database
        $new_tenant_id = Tenant::create($input)->tenant_id;

        $tenant = Tenant::find($new_tenant_id);
        $tenant->tenant_unique_id = $tenant_unique_id;
        $tenant->save();
    
        return redirect('/property/'.Session::get('property_id').'/room/'.$unit_id.'/tenant/'.$new_tenant_id.'/create/contract')->with('success', 'Tenant is added successfully!');
    }

    public function store_occupant_prefilled(Request $request, $property_id, $unit_id )
    {
        return 'asdasd';

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
                'created_at' => Carbon::now()
            ]
            );

            
            DB::table('units')
            ->where('unit_id', $unit_id)
            ->update(
                [
                    'status' => 'occupied'
                ]
            );
            $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

            $occupied_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'occupied')->count();
    
            $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;
    
            $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);
    
            if($current_occupancy_rate !== $new_occupancy_rate){
                $occupancy = new OccupancyRate();
                $occupancy->occupancy_rate = $new_occupancy_rate;
                $occupancy->occupancy_date = Carbon::now();
                $occupancy->property_id_foreign =  Session::get('property_id');
                $occupancy->save();
            }


        $user_id =  DB::table('users')->insertGetId([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email_address,
            'role_id_foreign' => '6',
            'password' => Hash::make($request->contact_no),
            'created_at' => Carbon::now(),
            'account_type' => '',
            'email_verified_at' => Carbon::now(),
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
        
        $notification->message = Auth::user()->name.' adds '.$tenant->first_name.' '.$tenant->last_name.' as an occupant in '.Unit::findOrFail($unit_id)->unit_no.'.';
        $notification->save();
        
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return redirect('/property/'.$request->property_id.'/occupant/'.$tenant_id)->with('success', 'occupant has been added!');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $tenant_id)
    {  

        if(Auth::user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 5){
            
            $property_bills = DB::table('particulars')
            ->join('property_bills', 'particular_id', 'particular_id_foreign')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('particular', 'asc')
            ->get();

             $violations = DB::table('violations')
            //->join('violation_types', 'violation_type_id_foreign', 'violation_type_id')
            ->where('tenant_id_foreign', $tenant_id)
            ->get();

            $violations_type = DB::table('violation_types')->get();
        
           $tenant = Tenant::findOrFail($tenant_id);

           $units = Property::findOrFail(Session::get('property_id'))
           
           ->units()->whereIn('status',['vacant'])
           ->get()->groupBy(function($item) {
                return $item->floor;
            });;
    
            $buildings = Property::findOrFail(Session::get('property_id'))
            ->units()
            ->whereIn('status',['vacant'])
            ->select('building', 'status', DB::raw('count(*) as count'))
            ->groupBy('building')
            ->orderBy('building', 'asc')
            ->get('building', 'status','count');

            $contracts = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->select('*', 'contracts.status as contract_status', 'contracts.term as contract_term')
            ->where('tenant_id', $tenant_id)
            ->orderBy('contracts.created_at', 'desc')
            ->get();

            $guardians = Tenant::findOrFail($tenant_id)->guardians;
 
            $users = DB::table('users_properties_relations')
             ->join('users','user_id_foreign','id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->whereNotIn('role_id_foreign' ,['6', '7'])
            ->get();

            $concerns  = Concern::where('concern_tenant_id', $tenant_id)->get();

             $payments = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
            ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('particulars','particular_id_foreign', 'particular_id')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('payment_id')
            ->orderBy('payment_created', 'desc')
            ->get();
       
             
            $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;


            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->join('particulars','particular_id_foreign', 'particular_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as
            amt_paid')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();


              $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
             ->join('particulars','particular_id_foreign', 'particular_id')
             ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
             ->where('bill_tenant_id', $tenant_id)
             ->groupBy('bill_id')
             ->orderBy('bill_no', 'desc')
             ->havingRaw('balance > 0')
             ->get();

                $access = DB::table('users')
                ->select('*', 'users.email as email')
              ->join('tenants', 'id', 'user_id_foreign')
              ->where('tenant_id', $tenant_id)
              ->get();
            
                return view('webapp.tenants.show', compact('violations_type','violations','bills','buildings','units','guardians','contracts','access','tenant','users' ,'concerns', 'current_bill_no', 'balance', 'payments','property_bills'));  
        }else{
                return view('layouts.arsha.unregistered');
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
    
        return back()->with('success', 'Image is uploaded successfully.');
    }

    public function show_billings($unit_id, $tenant_id){

        if(Auth::user()->role_id_foreign === 3 ||Auth::user()->role_id_foreign === 5 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 ){
            
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
            $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;

            //count the number of payments made
            $payments = DB::table('payments')
            ->where('payment_tenant_id', $tenant_id)
            ->where('amt_paid','>',0)
            ->count();

            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id') 
            ->selectRaw('* ,bills.amount - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_no')
            ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

            
            $collections = DB::table('units')
            ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
           
            ->leftJoin('bills', 'tenant_id', 'bill_tenant_id')
            ->leftJoin('payments', 'payment_bill_id', 'bill_id')
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
            return view('layouts.arsha.unregistered');
        }
    }

    public function edit_billings( $unit_id, $tenant_id){


        if(auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 4 ){
            
            //get the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $room = Unit::findOrFail($unit_id);
    
            //get the number of last added bills

            $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
            ->max('bill_no') + 1;


            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id') 
            ->selectRaw('* ,bills.amount - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_no')
            ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();

            return view('webapp.bills.edit', compact('current_bill_no','tenant', 'room', 'balance'));  
        }else{
            return view('layouts.arsha.unregistered');
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

        if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4){
            $tenant = Tenant::findOrFail($tenant_id);
            return view('webapp.tenants.edit', compact('tenant', 'property'));
        }else{
            return view('layouts.arsha.unregistered');
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
                //'email_address' => $request->email_address,

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

                'type_of_tenant' => $request->type_of_tenant,

        ]);

        $tenant =Tenant::findOrFail($tenant_id);
           
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'tenant';
        
        $notification->message = Auth::user()->name.' updates '.$tenant->first_name.' '.$tenant->last_name.' profile.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        
       return redirect('/property/'.$property_id.'/tenant/'.$tenant_id)->with('success','Changes saved.');
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

       $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
       ->max('bill_no') + 1;
  

        for($i = 1; $i<$no_of_charges; $i++){
            DB::table('bills')->insert(
                [
                    'bill_tenant_id' => $request->tenant_id,
                    'bill_no' => $current_bill_no++,
                    'date_posted' => $request->actual_move_out_date,
                    'particular' =>  $request->input('particular'.$i),
                    'amount' =>  $request->input('amount'.$i)
                ]);
        }
            $tenant = Tenant::findOrFail($tenant_id);
            $unit = Unit::findOrFail($unit_id);

            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id') 
            ->selectRaw('* ,bills.amount - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_no')
            ->orderBy('bill_no', 'desc')
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
                $message->bcc(['landleybernardo@thepropertymanager.online','thepropertymanagernoreply@gmail.com']);
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

  
      $current_bill_no = Bill::where('property_id_foreign', Session::get('property_id'))
      ->max('bill_no') + 1;


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
                DB::table('bills')->insert(
                    [
                        'bill_tenant_id' => $request->tenant_id,
                        'bill_no' => $current_bill_no++,
                        'date_posted' => $request->movein_date,
                        'start' =>  $request->input('start'.$i),
                        'end' =>  $request->input('end'.$i),
                        'particular' =>  $request->input('particular'.$i),
                        'amount' =>  $request->input('amount'.$i)
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
    
 

            if($no_of_items > 0){
                DB::table('units')
                ->where('unit_id', $unit_id)
                ->update(
                    [
                        'status' => 'reserved'
                    ]
                );
            }else{
                DB::table('units')
                ->where('unit_id', $unit_id)
                ->update(
                    [
                        'status' => 'reserved'
                    ]
                );
            }

            return back()->with('success', 'contract has been extended to '. $request->no_of_months.' month/s.');
            
        }
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
        DB::table('bills')->where('bill_tenant_id', $tenant_id)->delete();
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
            DB::table('bills')->insert(
                [
                    'bill_tenant_id' => $tenant_id,
                    'date_posted' => $request->movein_date,
                    'particular' =>  $request->input('desc'.$i),
                    'amount' =>  $request->input('amt'.$i)
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

        $billings = DB::table('bills')->where('bill_tenant_id', $tenant_id)->get();

        return view('reservation-forms.get-reservation', compact('tenant', 'unit', 'billings'));
    }

}


