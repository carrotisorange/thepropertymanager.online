<?php

namespace App\Http\Controllers;

use App\Property;
use DB;
use Auth;
use App\Unit, App\Owner, App\Tenant, App\User, App\Bill;
use Carbon\Carbon;
use App\Charts\DashboardChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantRegisteredMail;
use App\Mail\SendContractAlertEmail;
use Uuid;
use App\UserProperty;
use App\Notification;
use Session;
use App\OccupancyRate;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            if(Auth::user()->user_type == 'manager'){
                $properties = User::findOrFail(Auth::user()->id)->properties;

               $users = DB::table('users_properties_relations')
               ->join('properties', 'property_id_foreign', 'property_id')
               ->join('users', 'user_id_foreign', 'id')
               ->select('*', 'properties.name as property')
               ->where('lower_access_user_id', Auth::user()->id)
               ->orWhere('id', Auth::user()->id)  
               ->count();

               $manager_access = DB::table('users_properties_relations')
               ->join('properties', 'property_id_foreign', 'property_id')
               ->join('users', 'user_id_foreign', 'id')
               ->select('*', 'properties.name as property')
               ->where('lower_access_user_id', Auth::user()->id)
               ->orWhere('id', Auth::user()->id)  
               ->count();
       
        return view('webapp.properties.index', compact('properties', 'users')); 

            }elseif(Auth::user()->user_type == 'tenant'){
                $property_id = DB::table('users_properties_relations')
               ->join('users', 'user_id_foreign', 'id')
               ->where('user_id_foreign', Auth::user()->id)
               ->limit(1)
               ->get('property_id_foreign');

                $tenant = User::findOrFail(Auth::user()->id)->access;
                
                return view('webapp.tenant_access.main', compact('property_id', 'tenant'));

           
            }elseif(Auth::user()->user_type == 'owner'){
                return redirect('/user/'.Auth::user()->id.'/owner/portal');
            }elseif(Auth::user()->user_type == 'dev'){

                Session::put('notifications', Property::findOrFail($property_id)->unseen_notifications);

                $properties = Property::all();
        
                $paying_users = DB::table('users')
                ->where('account_type','!=','Free')
                ->where('user_type', '<>','tenant')
                ->get();
            
                $unverified_users = DB::table('users')
                ->whereNull('email_verified_at')
                ->orderBy('users.created_at', 'desc')
                ->where('user_type', '<>','tenant')
                ->get();
            
            
                $signup_rate_1 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->endOfMonth())
                ->where('user_type', 'manager')
            
                ->whereNull('email_verified_at')
                ->count();
            
                $signup_rate_2 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonth()->endOfMonth())
    
                ->where('user_type', 'manager')
            
                ->whereNull('email_verified_at')
                ->count();
            
                $signup_rate_3 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
    
                ->where('user_type', 'manager')
            
                ->whereNull('email_verified_at')
                ->count();
            
                $signup_rate_4 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
            
        
                ->where('user_type', 'manager')
            
                ->whereNull('email_verified_at')
                ->count();
            
                $signup_rate_5 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
            
            
                ->where('user_type', 'manager')
            
                ->whereNull('email_verified_at')
                ->count();
            
                $signup_rate_6 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
            
           
                ->where('user_type', 'manager')
            
                ->whereNull('email_verified_at')
                ->count();
            
            
                $verified_users_1 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->endOfMonth())
    
                ->where('user_type', 'manager')
            
                ->whereNotNull('account_type')
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_2 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonth()->endOfMonth())
    
            
                ->where('user_type', 'manager')
                ->whereNotNull('account_type')
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_3 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
            
                ->where('user_type', 'manager')
                ->whereNotNull('account_type')
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_4 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
            
       
                ->where('user_type', 'manager')
                ->whereNotNull('account_type')
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_5 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
    
            
                ->where('user_type', 'manager')
                ->whereNotNull('account_type')
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_6 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
    
            
                ->where('user_type', 'manager')
                ->whereNotNull('account_type')
                ->whereNotNull('email_verified_at')
                ->count();
            
                $signup_rate = new DashboardChart;
            
                $signup_rate->barwidth(4.0);
                $signup_rate->displaylegend(true);
                $signup_rate->labels([Carbon::now()->subMonth(5)->format('M Y'),Carbon::now()->subMonth(4)->format('M Y'),Carbon::now()->subMonth(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
                $signup_rate->dataset
                                        (
                                            'Sign Ups', 'line',
                                                                            [
                                                                                $signup_rate_6,
                                                                                $signup_rate_5,
                                                                                $signup_rate_4,
                                                                                $signup_rate_3,
                                                                                $signup_rate_2,
                                                                                $signup_rate_1,
                                                                        
            
            
                                                                            ]
                                        )
            ->color("#0000FF")
            ->fill(true)
            ->backgroundcolor("#0000FF");
            
                $signup_rate->dataset
                                        (
                                            'Active Users', 'line',
                                                                            [
            
                                                                                $verified_users_6,
                                                                                $verified_users_5,
                                                                                $verified_users_4,
                                                                                $verified_users_3,
                                                                                $verified_users_2,
                                                                                $verified_users_1,
                                                                       
            
                                                                            ],
            
                                            )
            
                ->color("#008000")
                ->backgroundcolor("#008000")
                ->fill(true)
                ->linetension(0.4);
            
                $active_users = DB::table('users')
            
            
                ->where('user_type', '<>','tenant')
                ->whereNotNull('email_verified_at')
    
            
                ->get();
            
            
            
                        $users = DB::table('users')
                        ->orderBy('email_verified_at', 'desc')
                        ->where('user_type','<>', 'tenant')
                        ->paginate(10);
            
                        $sessions = DB::table('users')
                        ->join('sessions', 'id', 'session_user_id')
                        ->join('properties', 'id', 'user_id_property')
                        ->select('*', 'properties.name as property_name', 'users.name as user_name')
            
                        ->whereDay('session_last_login_at', now()->day)
                        ->get();
            
            
                        return view('layouts.dev.dashboard', compact('users', 'sessions', 'paying_users', 'unverified_users', 'properties','signup_rate','active_users', 'users'));
            
            }
            else{
                if(Auth::user()->lower_access_user_id == null){
                    return view('webapp.users.system-users.warning'); 
                }else{
                    $properties = User::findOrFail(Auth::user()->lower_access_user_id)->properties;

                    $users = DB::table('users_properties_relations')
                    ->join('users', 'user_id_foreign', 'id')
                    ->where('user_id_foreign', Auth::user()->lower_access_user_id)
                    ->count();

                    return view('webapp.properties.index', compact('properties', 'users')); 
                }
            }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webapp.properties.create');
    }

    public function search(Request $request, $property_id){

         $search_key = $request->search_key;

         $tenants = DB::table('users_properties_relations')
         ->join('properties', 'property_id_foreign', 'property_id')
         ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
         ->where('property_id', $property_id)
         ->whereRaw("concat(first_name, ' ', last_name) like '%$search_key%' ")
         ->get();

         $emails = DB::table('users_properties_relations')
         ->join('properties', 'property_id_foreign', 'property_id')
         ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
         ->where('property_id', $property_id)
         ->whereRaw("email_address like '%$search_key%' ")
        ->orWhereRaw("contact_no like '%$search_key%' ")
         ->get();

        $all_tenants = $tenants->merge($emails)->unique();

        $units = DB::table('units')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("unit_no like '%$search_key%' ")
        ->orWhereRaw("building like '%$search_key%' ")
        ->get();

        $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("name like '%$search_key%' ")
        ->get();

        $mobiles = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("name like '%$search_key%' ")
        ->get();

        $all_owners = $owners->merge($mobiles)->unique();

        $property = Property::findOrFail($property_id);
    

        return view('webapp.properties.search', compact('property','search_key', 'all_tenants', 'units', 'all_owners'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function select(Request $request)
    {
        return redirect('/property/'.$request->selectedProperty.'/dashboard');
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
            'name' => 'required|max:255',
            'type' => 'required',
          
            'ownership' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'zip' => 'required',
        ]);

      $property_id =  Uuid::generate()->string;
        
       $property = new Property;
       $property->property_id =  $property_id;
       $property->name = $request->name;
       $property->type = $request->type;
       $property->ownership = $request->ownership;
       $property->address = $request->address;
       $property->mobile = $request->mobile;
       $property->country = $request->country;
       $property->zip = $request->zip;
       $property->user_id_property = Auth::user()->id;
       $property->save();
     
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = $property_id;
        $notification->type = 'property';
        $notification->message = 'Congratulations! You have successfully added your first property.';
        $notification->save();
    
        Session::put('notifications', Property::findOrFail($property_id)->unseen_notifications);
        
        DB::table('users_properties_relations')
        ->insert
                (
                    [
                        'user_id_foreign' => Auth::user()->id,
                        'property_id_foreign' => $property_id,
                    ]
                );

            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = 100;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  $property_id;
            $occupancy->save();
         

        return redirect('property/all')->with('success', 'Your property has been added!');

    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        Session::put('property_id', $request->property_id);
       
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        Session::put('property_type', Property::findOrFail(Session::get('property_id'))->type);

        Session::put('property_name', Property::findOrFail(Session::get('property_id'))->name);

        Session::put('property_ownership', Property::findOrFail(Session::get('property_id'))->ownership);
    

         $top_agents = DB::table('contracts')
        ->join('users', 'referrer_id_foreign', 'id')
        ->join('users_properties_relations', 'id', 'user_id_foreign')
        ->select('*', DB::raw('count(*) as referrals'))
        ->where('user_type', '<>', 'tenant')
        ->where('property_id_foreign', Session::get('property_id') )
        ->groupBy('id')
        ->orderBy('referrals', 'desc')
        ->limit(5)
        ->get();

        // $active_concerns = DB::table('tenants')
        // ->join('units', 'unit_id', 'unit_tenant_id')
        // ->join('concerns', 'tenant_id', 'concern_tenant_id')
        // ->where('status', 'active')
        // ->where('property_id_foreign', Session::get('property_id'))
        // ->get();

$units = Property::findOrFail(Session::get('property_id'))->units->where('status', '<>', 'deleted');



  $no_of_rooms_previous_month = Property::findOrFail(Session::get('property_id'))
->units
->where('created_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('created_at', '<=', Carbon::now()->subMonth()->endOfMonth())
->where('status', '<>', 'deleted')
->count();

 $no_of_rooms_current_month = Property::findOrFail(Session::get('property_id'))
->units
->where('created_at', '>=', Carbon::now()->firstOfMonth())
->where('created_at', '<=', Carbon::now()->endOfMonth())
->where('status', '<>', 'deleted')
->count();

$increase_in_room_acquired = number_format($no_of_rooms_previous_month == 0 ? 0 : (($no_of_rooms_current_month-$no_of_rooms_previous_month)/$no_of_rooms_previous_month ) * 100 ,1);

 $units_occupied = Property::findOrFail(Session::get('property_id'))->units->where('status', 'occupied')->count();

 $units_vacant = Property::findOrFail(Session::get('property_id'))->units->where('status', 'vacant')->count();

  $units_reserved =  Property::findOrFail(Session::get('property_id'))->units->where('status', 'reserved')->count();


$tenants = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->where('property_id_foreign', Session::get('property_id'))
->where('contracts.status', 'active')
->get();

$inactive_tenants = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->where('property_id_foreign', Session::get('property_id'))
->where('contracts.status', 'inactive')
->get();

$pending_tenants = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->where('property_id_foreign', Session::get('property_id'))
->where('contracts.status', 'pending')
->get();

$owners = DB::table('certificates')
->join('units', 'unit_id_foreign', 'unit_id')
->join('owners', 'owner_id_foreign', 'owner_id')
->where('property_id_foreign', Session::get('property_id'))
->get();

 $current_occupancy_rate = Property::findOrFail(Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

$occupancy_rate_5 = DB::table('occupancy_rate')
->where('property_id_foreign', Session::get('property_id'))
->where('occupancy_date', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('occupancy_date', '<=', Carbon::now()->subMonth()->endOfMonth())
->max('occupancy_rate');

 $occupancy_rate_4 = DB::table('occupancy_rate')
->where('property_id_foreign', Session::get('property_id'))
->where('occupancy_date', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('occupancy_date', '<=', Carbon::now()->subMonths(2)->endOfMonth())
->max('occupancy_rate');

 $occupancy_rate_3 = DB::table('occupancy_rate')
->where('property_id_foreign', Session::get('property_id'))
->where('occupancy_date', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('occupancy_date', '<=', Carbon::now()->subMonths(3)->endOfMonth())
->max('occupancy_rate');

  $occupancy_rate_2 = DB::table('occupancy_rate')
->where('property_id_foreign', Session::get('property_id'))
->where('occupancy_date', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('occupancy_date', '<=', Carbon::now()->subMonths(4)->endOfMonth())
->max('occupancy_rate');

$occupancy_rate_1 = DB::table('occupancy_rate')
->where('property_id_foreign', Session::get('property_id'))
->where('occupancy_date', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('occupancy_date', '<=', Carbon::now()->subMonths(5)->endOfMonth())
->max('occupancy_rate');

$movein_rate = new DashboardChart;
$movein_rate->barwidth(0.0);
$movein_rate->displaylegend(false);
$movein_rate->labels([Carbon::now()->subMonths(5)->format('M Y'),Carbon::now()->subMonths(4)->format('M Y'),Carbon::now()->subMonths(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
$movein_rate->dataset('Occupancy Rate: ', 'line',
                                        [ 
                                            $occupancy_rate_1,
                                            $occupancy_rate_2,
                                            $occupancy_rate_3,
                                            $occupancy_rate_4,
                                            $occupancy_rate_5,
                                            $current_occupancy_rate,
                                        ]

                        )
    ->color("#858796")
    ->backgroundcolor("rgba(78, 115, 223, 0.05)")
    ->fill(true)
    ->linetension(0.3);


  $renewed_contracts = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
     ->where('property_id_foreign', Session::get('property_id'))
    ->where('contracts.form_of_interaction', 'Renewal')
    ->count();

    $terminated_contracts = DB::table('contracts')
    ->join('units', 'unit_id_foreign', 'unit_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->where('contracts.status', 'inactive')
    ->count();

    $overall_contract_termination = $renewed_contracts + $terminated_contracts;


 $renewal_rate =  number_format($overall_contract_termination== 0 ? 0 : $renewed_contracts/$overall_contract_termination * 100,2);

$renewed_chart = new DashboardChart;
$renewed_chart->displaylegend(true);
$renewed_chart->labels([ 'Renewed'.' ('.$renewed_contracts.')', 'Terminated'.' ('.$terminated_contracts. ')', 'Total'.' ('.$overall_contract_termination. ')']);
$renewed_chart->dataset('', 'doughnut', [number_format(($overall_contract_termination == 0 ? 0 : $renewed_contracts/$overall_contract_termination) * 100,1),number_format(($overall_contract_termination == 0 ? 0 :$terminated_contracts/$overall_contract_termination) * 100,1)  ])
->backgroundColor(['#008000', '#FF0000']);

 $collection_rate_1 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->endOfMonth())
->where('property_id_foreign', Session::get('property_id'))
->sum('amt_paid');


$collection_rate_2 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonth()->endOfMonth())
 ->where('property_id_foreign',Session::get('property_id'))
->sum('amt_paid');



$collection_rate_3 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(2)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

$collection_rate_4 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(3)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

$collection_rate_5 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(4)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

 $collection_rate_6 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(5)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

 $increase_from_last_month = number_format(($collection_rate_2 == 0 ? 0 : ($collection_rate_1-$collection_rate_2)/$collection_rate_2 ) * 100 ,1);

$expenses_1 = DB::table('payable_request')
->where('property_id_foreign', Session::get('property_id'))
->where('status', 'released')
->where('updated_at', '>=', Carbon::now()->firstOfMonth())
->where('updated_at', '<=', Carbon::now()->endOfMonth())
->sum('amt');

$expenses_2 = DB::table('payable_request')
->where('property_id_foreign', Session::get('property_id'))
->where('status', 'released')
->where('updated_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('updated_at', '<=', Carbon::now()->subMonth()->endOfMonth())
->sum('amt');

$expenses_3 = DB::table('payable_request')
->where('property_id_foreign', Session::get('property_id'))
->where('status', 'released')
->where('updated_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('updated_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
->sum('amt');

$expenses_4 = DB::table('payable_request')
->where('property_id_foreign', Session::get('property_id'))
->where('status', 'released')
->where('updated_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('updated_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
->sum('amt');

$expenses_5 = DB::table('payable_request')
->where('property_id_foreign',Session::get('property_id'))
->where('status', 'released')
->where('updated_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('updated_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
->sum('amt');

$expenses_6 = DB::table('payable_request')
->where('property_id_foreign',Session::get('property_id'))
->where('status', 'released')
->where('updated_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('updated_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
->sum('amt');


$expenses_rate = new DashboardChart;

$expenses_rate->barwidth(4.0);
$expenses_rate->displaylegend(true);
$expenses_rate->labels([Carbon::now()->subMonth(5)->format('M Y'),Carbon::now()->subMonth(4)->format('M Y'),Carbon::now()->subMonth(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
$expenses_rate->dataset
                        (
                            'Collection', 'line',
                                                            [
                                                                $collection_rate_6,
                                                                $collection_rate_5,
                                                                $collection_rate_4,
                                                                $collection_rate_3,
                                                                $collection_rate_2,
                                                                $collection_rate_1,
                                                          

                                                            ]
                        )
->color("#0000FF")
->fill(true)
->backgroundcolor("#0000FF");

$expenses_rate->dataset
                        (
                            'Expenses', 'line',
                                                            [
                                                                $expenses_6,
                                                                $expenses_5,
                                                                $expenses_4,
                                                                $expenses_3,
                                                                $expenses_2,
                                                                $expenses_1,
                                                            
                                                            ]
                        )
->color("#ff0000")
->fill(true)
->backgroundcolor("#ff0000");

$expenses_rate->dataset
                        (
                            'Income', 'line',
                                                            [
                                                                $collection_rate_6 -  $expenses_6,
                                                                $collection_rate_5 -  $expenses_5,
                                                                $collection_rate_4 -  $expenses_4,
                                                                $collection_rate_3 - $expenses_3,
                                                                $collection_rate_2 -  $expenses_2,
                                                                $collection_rate_1 - $expenses_1,
                                                      
                                                            ],

                            )

    ->color("#008000")
    ->backgroundcolor("#008000")
    ->fill(true)
    ->linetension(0.4);


    if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
        $delinquent_accounts = Unit::leftJoin('bills', 'unit_id','bill_unit_id')
        ->leftJoin('payments', 'bill_id','payment_bill_id')
        ->leftJoin('contracts', 'unit_id', 'unit_id_foreign')
          ->selectRaw('*,sum(amount) - IFNULL(sum(payments.amt_paid),0) as balance')
          ->where('property_id_foreign',Session::get('property_id'))
          ->groupBy('unit_id')
          ->orderBy('balance', 'desc')
          ->havingRaw('balance > 0')
          ->simplePaginate(5);
    }else{
        $delinquent_accounts = Tenant::leftJoin('bills', 'tenant_id','bill_tenant_id')
          ->leftJoin('payments', 'bill_id','payment_bill_id')
        ->leftJoin('contracts', 'tenant_id', 'tenant_id_foreign')
      
        ->leftJoin('units', 'unit_id_foreign', 'unit_id')
          ->selectRaw('*,sum(amount) - IFNULL(sum(payments.amt_paid),0) as balance')
          ->where('property_id_foreign',Session::get('property_id'))
          ->groupBy('tenant_id')
          ->orderBy('balance', 'desc')
          ->havingRaw('balance > 0')
          ->simplePaginate(5);
    }



//  $delinquent_accounts = Billing::leftJoin('payments', 'billings.billing_id', '=', 'payments.payment_bill_id')
// ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
// ->join('units', 'unit_id_foreign', 'unit_id')
// ->join('tenants', 'tenant_id_foreign', 'tenant_id')
// ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance')
// ->where('property_id_foreign', Session::get('property_id'))
// ->groupBy('tenant_id')
// ->orderBy('balance', 'desc')
// ->havingRaw('balance > 0')
// ->get();

$contracts = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->count();

 $facebook = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','Facebook')
->count();

$flyers = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','Flyers')
->count();

$inhouse = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','In house')
->count();

$instagram = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','Instagram')
->count();

$website = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','Website')
->count();

$walkin = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','Walk in')
->count();

$wordofmouth = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->where('form_of_interaction','Word of mouth')
->count();

$point_of_contact = new DashboardChart;
$point_of_contact->displaylegend(true);
$point_of_contact->labels
                            (
                                [ 
                                    'Facebook'.' ('.$facebook.')',
                                    'Flyers'.' ('.$flyers.')', 
                                    'In house'.' ('.$inhouse.')', 
                                    'Instagram'.' ('.$instagram.')', 
                                    'Website'.' ('.$website.')',
                                    'Walk in'.' ('.$walkin.')', 
                                    'Word of mouth'.' ('.$wordofmouth.')',
                                ]
                            );
$point_of_contact->dataset
                            ('', 'pie',
                                [   
                                    number_format(($contracts == 0 ? 1 : $facebook/$contracts) * 100,1),
                                    number_format(($contracts == 0 ? 1 : $flyers/$contracts) * 100,1),
                                    number_format(($contracts == 0 ? 1 : $inhouse/$contracts) * 100,1),
                                    number_format(($contracts == 0 ? 1 : $instagram/$contracts) * 100,1),
                                    number_format(($contracts== 0 ? 1 : $website/$contracts) * 100,1), 
                                    number_format(($contracts== 0 ? 1 : $walkin/$contracts) * 100,1), 
                                    number_format(($contracts == 0 ? 1 : $wordofmouth/$contracts) * 100,1),
                                ]
                            )
->backgroundColor
                    (
                        [
                            '#3b5998',
                            '#211939', 
                            '#008000',
                            '#C13584',
                            '#DE7835',
                            '#211979',
                            '#FF0000',
                        ]
                    );
                    
 $tenants_to_watch_out = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->select('*', 'contracts.status as contract_status' )
->where('property_id_foreign', Session::get('property_id'))
->where('contracts.status', 'active')
->where('moveout_at', '<=', Carbon::now()->addMonth())
->orderBy('moveout_at', 'asc')
->paginate(5);

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


$moveout_rate_1 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('actual_moveout_at', '>=', Carbon::now()->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_2 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonth()->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_3 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_4 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_5 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

 $moveout_rate_6 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate = new DashboardChart;
$moveout_rate->displaylegend(false);
$moveout_rate->labels([Carbon::now()->subMonth(5)->format('M Y'),Carbon::now()->subMonth(4)->format('M Y'),Carbon::now()->subMonth(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
$moveout_rate->dataset('Moveouts', 'bar', [
                                                $moveout_rate_6,
                                                $moveout_rate_5,
                                                $moveout_rate_4,
                                                $moveout_rate_3,
                                                $moveout_rate_2,
                                                $moveout_rate_1,
                                           
                                              ]
                )
->color("#858796")
->backgroundcolor("rgba(78, 115, 223, 0.05)")
->fill(true)
->linetension(0.1);

$end_of_contract = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','End of contract')
->get();

$delinquent = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Delinquent')
->get();

$force_majeure = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Force majeure')
->get();

$run_away = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Run away')
->get();

$unruly = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Unruly')
->get();

$graduated = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Graduated')
->get();

$reason_for_moving_out_chart = new DashboardChart;
$reason_for_moving_out_chart->displaylegend(true);
$reason_for_moving_out_chart->labels(
                                        [ 'End Of Contract'.' ('.$end_of_contract->count(). ')',
                                          'Graduated'.' ('.$graduated->count(). ')', 
                                          'Delinquent'.' ('.$delinquent->count(). ')', 
                                          'Force Majeure'.' ('.$force_majeure->count(). ')', 
                                          'Run Away'.' ('.$run_away->count(). ')', 
                                          'Unruly'.' ('.$unruly->count(). ')',
                                          'Total'.' ('.$inactive_tenants->count(). ')'
                                          ]
                                    );
$reason_for_moving_out_chart->dataset('', 'pie', 
                                        [
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $end_of_contract->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $graduated->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $delinquent->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $force_majeure->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $run_away->count()/$inactive_tenants->count()) * 100,1), 
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $unruly->count()/$inactive_tenants->count()) * 100,1),
                                        ]
                                    )
->backgroundColor(
                    [
                        '#008000',
                        '#FFF000', 
                        '#FF0000',
                        '#0E0601',
                        '#DE7835',
                        '#211979'
                    ]
                );



if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
    $collections_for_the_day = DB::table('contracts')
    ->leftJoin('units', 'unit_id_foreign', 'unit_id')
    ->leftJoin('bills', 'unit_id', 'bill_unit_id')
    ->leftJoin('payments', 'payment_bill_id', 'bill_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->whereDate('payment_created', Carbon::now())
    ->orderBy('payment_created', 'desc')
    ->orderBy('ar_no', 'desc')
    ->groupBy('payment_id')
    ->get();
}else{

    $collections_for_the_day = DB::table('contracts')
    ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
    ->leftJoin('units', 'unit_id_foreign', 'unit_id')
    ->leftJoin('bills', 'tenant_id', 'bill_tenant_id')
    ->leftJoin('payments', 'payment_bill_id', 'bill_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->whereDate('payment_created', Carbon::now())
    ->orderBy('payment_created', 'desc')
    ->orderBy('ar_no', 'desc')
    ->groupBy('payment_id')
    ->get();
}

$property = Property::findOrFail(Session::get('property_id'));

if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
    return view('webapp.properties.show-unit-properties',
    compact(
                'units', 'units_occupied','units_vacant', 'units_reserved',
                'tenants', 'pending_tenants', 'owners',
                'movein_rate','moveout_rate', 'renewed_chart','expenses_rate', 'reason_for_moving_out_chart',
                'delinquent_accounts','tenants_to_watch_out',
                'collections_for_the_day',
                'current_occupancy_rate', 'property','collection_rate_1','renewal_rate','increase_from_last_month','increase_in_room_acquired','top_agents','point_of_contact','pending_concerns'
            )
    );
}else{
    return view('webapp.properties.show',
    compact(
                'units', 'units_occupied','units_vacant', 'units_reserved',
                'tenants', 'pending_tenants', 'owners',
                'movein_rate','moveout_rate', 'renewed_chart','expenses_rate', 'reason_for_moving_out_chart',
                'delinquent_accounts','tenants_to_watch_out',
                'collections_for_the_day',
                'current_occupancy_rate', 'property','collection_rate_1','renewal_rate','increase_from_last_month','increase_in_room_acquired','top_agents','point_of_contact','pending_concerns'
            )
    );
}

   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id)
    {
        $property = Property::findOrFail($property_id);

        return view('webapp.properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        if(Auth::user()->user_type === 'dev'){
            $property = Property::findOrFail($request->property_id);
        }else{
            $property = Property::findOrFail(Session::get('property_id'));
        }

        $property->name = $request->name;
        $property->type = $request->type;
        $property->ownership = $request->ownership;
        $property->mobile = $request->mobile;
        $property->address = $request->address;
        $property->country = $request->country;
        $property->zip = $request->zip;
        $property->save();

        Session::put('property_id', $request->property_id);
       
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        Session::put('property_type', Property::findOrFail(Session::get('property_id'))->type);

        Session::put('property_name', Property::findOrFail(Session::get('property_id'))->name);

        Session::put('property_ownership', Property::findOrFail(Session::get('property_id'))->ownership);

        if(Auth::user()->user_type === 'dev'){
            return redirect('/dev/properties/')->with('success','Changes have been saved!');
        }else{
          
            return redirect('/property/'.Session::get('property_id').'/user/'.Auth::user()->id.'#property')->with('success','Changes have been saved!');
        }
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property, $property_id)
    {
      
    }
}
