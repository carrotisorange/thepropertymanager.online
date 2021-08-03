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
use App\PropertyType;
use App\Country;
use App\PropertyBill;
use App\Particular;
use App\Role;
use Illuminate\Support\Facades\Hash;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Session::put('current-page', 'dashboard');

            if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1){
                if(Auth::user()->role_id_foreign === 4){
                    $properties = User::findOrFail(Auth::user()->id)->properties;
                }else{
                    $properties = User::findOrFail(Auth::user()->lower_access_user_id)->properties;
                }
              
            
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

            }elseif(Auth::user()->role_id_foreign == 'tenant'){
                $property_id = DB::table('users_properties_relations')
               ->join('users', 'user_id_foreign', 'id')
               ->where('user_id_foreign', Auth::user()->id)
               ->limit(1)
               ->get('property_id_foreign');

                $tenant = User::findOrFail(Auth::user()->id)->access;
                
                return view('webapp.tenant_access.main', compact('property_id', 'tenant'));

           
            }elseif(Auth::user()->role_id_foreign == 'owner'){
                $property_id = DB::table('users_properties_relations')
                ->join('users', 'user_id_foreign', 'id')
                ->where('user_id_foreign', Auth::user()->id)
                ->limit(1)
                ->get('property_id_foreign');
 
                  $owner = User::findOrFail(Auth::user()->id)->owner_access;
                 
                 return view('webapp.owner_access.main', compact('property_id', 'owner'));
            }elseif(Auth::user()->role_id_foreign == 'dev'){

                Session::put('notifications', Notification::orderBy('created_at','desc')->limit(5)->get());

                $issues = DB::table('issues')
                ->join('users', 'user_id_foreign', 'id')
                ->where('issues.status', 'active')
                ->orderBy('issues.created_at', 'desc')->get();

                $properties = Property::all();
        
                $paying_users = DB::table('users')
                ->whereNotNull('email_verified_at')
                ->where('user_type',4)
                ->get();
            
                $unverified_users = DB::table('users')
                ->whereNull('email_verified_at')
                ->orderBy('users.created_at', 'desc')
                ->where('user_type', '<>','tenant')
                ->get();
            
            
                $signup_rate_1 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->firstOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->count();
            
                $signup_rate_2 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonth()->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->count();
            
                $signup_rate_3 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->count();
            
                $signup_rate_4 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->count();
            
                $signup_rate_5 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->count();
            
                $signup_rate_6 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->count();
            
            
                $verified_users_1 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_2 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonth()->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_3 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_4 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_5 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->whereNotNull('email_verified_at')
                ->count();
            
                $verified_users_6 = DB::table('users')
                ->where('email_verified_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
                ->where('email_verified_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
                ->whereNotIn('user_type', ['owner','tenant','dev' ])
                ->whereNotNull('email_verified_at')
                ->count();
            
                $signup_rate = new DashboardChart;
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
            ->fill(false)
            ->backgroundcolor("#0000FF")
            ->linetension(0.3);
            
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
                ->fill(false)
                ->linetension(0.3);

            
                $active_users = DB::table('users')
                ->where('user_type',4)
                ->whereNotNull('email_verified_at')
                ->get();

                 $all_active_managers = DB::table('users')
                ->join('sessions', 'id', 'session_user_id')
                ->join('properties', 'id', 'user_id_property')
                ->select('*', 'properties.name as property_name', 'users.name as user_name')
                ->where('session_last_login_at', '>=', Carbon::today())
                ->where('user_type', 4)
                ->paginate(5);

                 $all_active_users = DB::table('users')
                ->join('sessions', 'id', 'session_user_id')
                ->where('session_last_login_at', '>=', Carbon::today())
                ->where('user_type', '<>', 4)
                ->get();


                $starter_plan = DB::table('users')
                ->where('account_type','starter')
                ->where('user_type',4)
                ->whereNotNull('email_verified_at')
                ->count();

                $basic_plan = DB::table('users')
                ->where('account_type','basic')
                ->where('user_type',4)
                ->whereNotNull('email_verified_at')
                ->count();

                $large_plan = DB::table('users')
                ->where('account_type','large')
                ->where('user_type',4)
                ->whereNotNull('email_verified_at')
                ->count();

                $advanced_plan = DB::table('users')
                ->where('account_type','advanced')
                ->where('user_type',4)
                ->whereNotNull('email_verified_at')
                ->count();


                $enterprise_plan = DB::table('users')
                ->where('account_type','enterprise')
                ->where('user_type',4)
                ->whereNotNull('email_verified_at')
                ->count();
            
            
            
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
            
            
                        return view('layouts.dev.dashboard', compact('users', 'sessions', 'paying_users', 'unverified_users', 'properties','signup_rate','active_users', 
                        'users','starter_plan', 'basic_plan', 'large_plan', 'advanced_plan', 'enterprise_plan', 'all_active_managers', 'issues', 'all_active_users'));
            
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
    public function create_property()
    {

        $property_types = PropertyType::all();

        $countries = Country::all();

        return view('webapp.properties.property.create', compact('property_types','countries'));
    }

    public function portforlio(){

        $properties = User::findOrFail(Auth::user()->id)->properties;

        return view('webapp.properties.portforlio', compact('properties'));
    }

    public function search(Request $request, $property_id){

         $search_key = $request->search_key;

         $notification = new Notification();
         $notification->user_id_foreign = Auth::user()->id;
         $notification->property_id_foreign = Session::get('property_id');
         $notification->type = 'search';
         
         $notification->message = Auth::user()->name.' searches for '.$search_key;
         $notification->save();
                     
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

         $tenants = DB::table('users_properties_relations')
         ->join('properties', 'property_id_foreign', 'property_id')
         ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
         ->where('property_id', $property_id)
         ->whereRaw("concat(first_name, last_name) like '%$search_key%' ")
         ->get();

        $units = DB::table('units')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("unit_no like '%$search_key%' ")
        ->orWhereRaw("building like '%$search_key%' ")
        ->get();

        $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("concat(name, mobile) like '%$search_key%' ")
        ->get();
    
        return view('webapp.properties.search', compact('search_key', 'tenants', 'units', 'owners'));
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
    public function store_property(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'property_type_id_foreign' => 'required',
            'country_id_foreign' => 'required',
            // 'ownership' => 'required',
            'address' => 'required',
            'mobile' => 'required',
        
            'zip' => 'required',
        ]);

      $property_id =  Uuid::generate()->string;

      Session::put('property_id',$property_id);
        
       $property = new Property;
       $property->property_id =  $property_id;
       $property->name = $request->name;
       $property->property_type_id_foreign = $request->property_type_id_foreign;
    //    $property->ownership = $request->ownership;
       $property->address = $request->address;
       $property->country_id_foreign = $request->country_id_foreign;
       $property->mobile = $request->mobile;
    //    $property->country = $request->country;
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
         

        return redirect('property/'.$property_id.'/rooms/create')->with('success', 'Property is successfully created.');

    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        Session::put('current-page', 'dashboard');
        
        Session::put('property_id', $request->property_id);

        Session::put('footer_message', Property::findOrFail(Session::get('property_id'))->footer_message);

        Session::put('electric_rate_kwh', Property::findOrFail(Session::get('property_id'))->electric_rate_kwh);

        Session::put('water_rate_cum', Property::findOrFail(Session::get('property_id'))->water_rate_cum);
       
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        Session::put('property_type', Property::findOrFail(Session::get('property_id'))->type);

        Session::put('property_name', Property::findOrFail(Session::get('property_id'))->name);

        Session::put('property_address', Property::findOrFail(Session::get('property_id'))->address);

        Session::put('property_mobile', Property::findOrFail(Session::get('property_id'))->mobile);

        Session::put('property_ownership', Property::findOrFail(Session::get('property_id'))->ownership);
        

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'property';
        
        $notification->message = Auth::user()->name.' manages '.Session::get('property_name').'.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
    

         $top_agents = DB::table('contracts')
        ->join('users', 'referrer_id_foreign', 'id')
        ->join('users_properties_relations', 'id', 'user_id_foreign')
        ->select('*', DB::raw('count(*) as referrals'))
        ->where('user_type', '<>', 'tenant')
        ->where('property_id_foreign', Session::get('property_id') )
        ->groupBy('id')
        ->orderBy('referrals', 'desc')
        ->get();

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

 $all_tenants = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->where('property_id_foreign', Session::get('property_id'))
->count();

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
    ->fill(false)
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
->where('form','!=' ,'Credit memo')
->sum('amt_paid');


$collection_rate_2 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonth()->endOfMonth())
 ->where('property_id_foreign',Session::get('property_id'))
 ->where('form','!=' ,'Credit memo')
->sum('amt_paid');



$collection_rate_3 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(2)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('form','!=' ,'Credit memo')

->sum('amt_paid');

$collection_rate_4 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(3)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('form','!=' ,'Credit memo')

->sum('amt_paid');

$collection_rate_5 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(4)->endOfMonth())
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('form','!=' ,'Credit memo')

->sum('amt_paid');

 $collection_rate_6 = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
->where('payment_created', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('payment_created', '<=', Carbon::now()->subMonths(5)->endOfMonth())
->where('form','!=' ,'Credit memo')
 ->where('property_id_foreign', Session::get('property_id'))

->sum('amt_paid');

 $increase_from_last_month = number_format(($collection_rate_2 == 0 ? 0 : ($collection_rate_1-$collection_rate_2)/$collection_rate_2 ) * 100 ,1);

 
 $expenses_1 = DB::table('payable_request')
 ->join('users', 'requester_id', 'users.id')
 ->join('payable_entry', 'entry_id', 'payable_entry.id')
 ->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->firstOfMonth())
->where('released_at', '<=', Carbon::now()->endOfMonth())
->sum('amt');

$expenses_2 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonth()->endOfMonth())
->sum('amt');

$expenses_3 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
->sum('amt');

$expenses_4 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
->sum('amt');

$expenses_5 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
->sum('amt');

$expenses_6 = DB::table('payable_request')
->join('users', 'requester_id', 'users.id')
->join('payable_entry', 'entry_id', 'payable_entry.id')
->select('*', 'payable_request.note as pb_note', 'payable_request.id as pb_id')
->where('payable_request.status', 'released')
->where('payable_entry.property_id_foreign', Session::get('property_id'))
->where('released_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('released_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
->sum('amt');


$expenses_rate = new DashboardChart;

$expenses_rate->barwidth(4.0);
$expenses_rate->displaylegend(true);
$expenses_rate->labels([Carbon::now()->subMonth(5)->format('M Y'),Carbon::now()->subMonth(4)->format('M Y'),Carbon::now()->subMonth(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
$expenses_rate->dataset
                        (
                            'Collections', 'line',
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
->fill(false)
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
->fill(false)
->backgroundcolor("#ff0000");

$expenses_rate->dataset
                        (
                            'Income', 'line',
                                                            [
                                                               $collection_rate_6 - $expenses_6,
                                                               $collection_rate_5 - $expenses_5,
                                                                $collection_rate_4 - $expenses_4,
                                                                $collection_rate_3 - $expenses_3,
                                                               $collection_rate_2 - $expenses_2,
                                                               $collection_rate_1 - $expenses_1,
                                                      
                                                            ],

                            )

    ->color("#008000")
    ->backgroundcolor("#008000")
    ->fill(false)
    ->linetension(0.3);


    if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
        $delinquent_accounts = Unit::leftJoin('bills', 'unit_id','bill_unit_id')
        ->leftJoin('payments', 'bill_id','payment_bill_id')
        ->leftJoin('contracts', 'unit_id', 'unit_id_foreign')
          ->selectRaw('*,sum(amount) - IFNULL(sum(payments.amt_paid),0) as balance')
          ->where('property_id_foreign',Session::get('property_id'))
          ->groupBy('unit_id')
          ->orderBy('balance', 'desc')
          ->havingRaw('balance > 0')
          ->get();
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
          ->get();
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
                                    'Total'.' ('.$contracts. ')'
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
                    
 $less_than_a_year = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->selectRaw('*, datediff(moveout_at, movein_at) as lenght_of_stay')
->whereRaw('datediff(moveout_at, movein_at) < 365')
->count();

  $one_two_years = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->selectRaw('*, datediff(moveout_at, movein_at) as lenght_of_stay')
->whereRaw('datediff(moveout_at, movein_at) >= 365 AND datediff(moveout_at, movein_at) <= 730')
->count();

$three_four_years = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->selectRaw('*, datediff(moveout_at, movein_at) as lenght_of_stay')
->whereRaw('datediff(moveout_at, movein_at) >= 1095 AND datediff(moveout_at, movein_at) <= 1460')
->count();

$five_six_years = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->selectRaw('*, datediff(moveout_at, movein_at) as lenght_of_stay')
->whereRaw('datediff(moveout_at, movein_at) >= 1825 AND datediff(moveout_at, movein_at) <= 2190')
->count();

$seven_eight_years = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->selectRaw('*, datediff(moveout_at, movein_at) as lenght_of_stay')
->whereRaw('datediff(moveout_at, movein_at) >= 2555 AND datediff(moveout_at, movein_at) <= 2920')
->count();

$morethan_eight_years = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->where('property_id_foreign', Session::get('property_id'))
->selectRaw('*, datediff(moveout_at, movein_at) as lenght_of_stay')
->whereRaw('datediff(moveout_at, movein_at) > 2920')
->count();


$length_of_stay = new DashboardChart;
$length_of_stay->displaylegend(true);
$length_of_stay->labels
                            (
                                [ 
                                    '<1 year'.' ('.$less_than_a_year.')',
                                    '1-2 years'.' ('.$one_two_years.')', 
                                    '3-4 years'.' ('.$three_four_years.')', 
                                    '5-6 years'.' ('.$five_six_years.')', 
                                    '7-8 years'.' ('.$seven_eight_years.')',
                                    '>8 years'.' ('.$morethan_eight_years.')', 
                                    'Total'.' ('.$contracts.')', 
                                ]
                            );
$length_of_stay->dataset
                            ('', 'pie',
                                [   
                                    $less_than_a_year,
                                    $one_two_years,
                                    $three_four_years,
                                    $five_six_years,
                                    $seven_eight_years,
                                    $morethan_eight_years,

                                   
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
                        ]
                    );

                    
 $tenants_to_watch_out = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->select('*', 'contracts.status as contract_status' )
->where('property_id_foreign', Session::get('property_id'))
->where('contracts.status','<>', 'inactive')
->where('moveout_at', '<=', Carbon::now()->addMonth())
->orderBy('moveout_at', 'asc')
->get();

$pending_concerns = DB::table('contracts')
->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
->leftJoin('units', 'unit_id_foreign', 'unit_id')
->join('concerns', 'tenant_id', 'concern_tenant_id')
->leftJoin('users', 'concern_user_id', 'id')
->select('*', 'concerns.status as concern_status')
->where('property_id_foreign', Session::get('property_id'))
->whereIn('concerns.status', ['pending', 'active'])
->orderBy('reported_at', 'desc')
->orderBy('urgency', 'desc')
->orderBy('concerns.status', 'desc')
->paginate(5);

$concerns = DB::table('contracts')
->join('tenants', 'tenant_id_foreign', 'tenant_id')
->join('units', 'unit_id_foreign', 'unit_id')
->join('concerns', 'tenant_id', 'concern_tenant_id')
->join('users', 'concern_user_id', 'id')
->where('property_id_foreign', Session::get('property_id'))
->where('concerns.status', 'closed')
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
->fill(false)
->linetension(0.3);

$end_of_contract = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','End of contract')
->where('contracts.status', 'inactive')
->get();

$delinquent = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Delinquent')
->where('contracts.status', 'inactive')
->get();

$force_majeure = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Force majeure')
->where('contracts.status', 'inactive')
->get();

$run_away = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Run away')
->where('contracts.status', 'inactive')
->get();

$unruly = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
->where('moveout_reason','Unruly')
->where('contracts.status', 'inactive')
->get();

$graduated = DB::table('contracts')
->join('units', 'unit_id_foreign', 'unit_id')
 ->where('property_id_foreign', Session::get('property_id'))
 ->where('contracts.status', 'inactive')
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


$working = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->where('property_id_foreign', Session::get('property_id'))
               -> where('type_of_tenant', 'working')
                ->count();

$studying = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->where('property_id_foreign', Session::get('property_id'))
               -> where('type_of_tenant', 'studying')
                ->count();

if($tenants->count() != 0){
    $working_tenants = number_format(( $working/$tenants->count()) * 100,1);
    $studying_tenants = number_format(( $studying/$tenants->count()) * 100,1);
}else{
    $working_tenants = 0;
    $studying_tenants = 0;  
}




   
 $status = new DashboardChart;
 $status->displaylegend(true);
 $status->labels
                             (
                                 [ 
                                     'Working'.' ('.$working.')',
                                     'Studying'.' ('.$studying.')', 
                                     'Total'.' ('.$all_tenants. ')'
                                 ]
                             );
 $status->dataset
                             ('', 'pie',
                                 [   
                                    $working_tenants,
                                    $studying_tenants,                                 
                                 ]
                             )
 ->backgroundColor
                     (
                         [
                             '#008000',
                             '#211939', 
                         ]
                     );



if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
    $collections_for_the_day = DB::table('contracts')
    ->leftJoin('units', 'unit_id_foreign', 'unit_id')
    ->leftJoin('bills', 'unit_id', 'bill_unit_id')
    ->leftJoin('payments', 'payment_bill_id', 'bill_id')
    ->join('particulars','particular_id_foreign', 'particular_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->where('form','!=' ,'Credit memo')
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
    ->join('particulars','particular_id_foreign', 'particular_id')
    ->where('property_id_foreign', Session::get('property_id'))
    ->where('form','!=' ,'Credit memo')
    ->whereDate('payment_created', Carbon::now())
    ->orderBy('payment_created', 'desc')
    ->orderBy('ar_no', 'desc')
    ->groupBy('payment_id')
    ->get();
}

if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
    return view('webapp.properties.show-unit-properties',
    compact(
                'units', 'units_occupied','units_vacant', 'units_reserved',
                'tenants', 'pending_tenants', 'owners',
                'movein_rate','moveout_rate', 'renewed_chart','expenses_rate', 'reason_for_moving_out_chart',
                'delinquent_accounts','tenants_to_watch_out',
                'collections_for_the_day','contracts',
                'current_occupancy_rate','collection_rate_1','renewal_rate','increase_from_last_month','increase_in_room_acquired','top_agents','point_of_contact','pending_concerns',
                'length_of_stay'
            )
    );
}else{
    return view('webapp.properties.show',
    compact(
                'units', 'units_occupied','units_vacant', 'units_reserved',
                'tenants', 'pending_tenants', 'owners',
                'movein_rate','moveout_rate', 'renewed_chart','expenses_rate', 'reason_for_moving_out_chart',
                'delinquent_accounts','tenants_to_watch_out',
                'collections_for_the_day','concerns','contracts',
                'current_occupancy_rate','collection_rate_1',
                'renewal_rate','increase_from_last_month','increase_in_room_acquired',
                'top_agents','point_of_contact','pending_concerns', 'status','length_of_stay'
            )
    );
}

    }

    public function create_bill(){

        $particulars = Particular::all();

        return view('webapp.properties.bills.create', compact('particulars'));
    }

    public function store_bill(Request $request){
       
        $particulars = $request->get('particulars');

        $data=array();
             foreach($particulars as $particular)
             {
                 $data[] =[
                            'particular_id_foreign' => $particular,
                            'property_id_foreign' => Session::get('property_id'),
                            'created_at' => Carbon::now(),
                         ];                 
             }
    
        PropertyBill::insert($data);

        return redirect('property/'.Session::get('property_id').'/duedates/create')->with('success', 'Bills are successfully created.');
    }

    public function create_duedate(){

        $bills = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->get();

        return view('webapp.properties.duedates.create', compact('bills'));
    }

    public function store_duedate(Request $request){

        // $bills_count = DB::table('particulars')
        // ->join('property_bills', 'particular_id', 'particular_id_foreign')
        // ->where('property_id_foreign', Session::get('property_id'))
        // ->count();

        $bills_count = PropertyBill::all() ->max('property_bill_id');
       
        for ($i=1; $i <= $bills_count; $i++) { 
                DB::table('property_bills')
                ->where('property_bill_id', $request->input('bill'.$i))
                ->update
                        (
                            [
                                'penalty' => $request->input('penalty'.$i),
                                'due_date' => $request->input('duedate'.$i),
                                'rate' => $request->input('rate'.$i),
                                'created_at' => Carbon::now()
                            ]
                        );
                      
          }

        return redirect('property/'.Session::get('property_id').'/users/create')->with('success', 'Bills are successfully set.');
    }

    public function create_user(){

        $roles = Role::all();

        return view('webapp.properties.users.create', compact('roles'));
    }

    
    public function store_user(Request $request){

       $no_of_entry = (int) $request->no_of_entry;

       for($i = 1; $i<$no_of_entry; $i++){  
           
       if($request->input('role'.$i)==='4'){
        $user_id =  DB::table('users')
        ->insertGetId
                (
                    [
                        'name' => $request->input('name'.$i),
                        'email' => $request->input('email'.$i),
                        'password' => Hash::make(Carbon::now()->timestamp),
                        'role_id_foreign' => $request->input('role'.$i),
                        'created_at' => Carbon::now(),
                        'account_type' => Session::get('plan'),
                        'trial_ends_at' => Carbon::now()->addDays(14),
                
                    ]
                );
        }
       else{
        $user_id =  DB::table('users')
        ->insertGetId
                (
                    [
                        'name' => $request->input('name'.$i),
                        'email' => $request->input('email'.$i),
                        'password' => Hash::make(Carbon::now()->timestamp),
                        'role_id_foreign' => $request->input('role'.$i),
                        'created_at' => Carbon::now(),
                        'account_type' => Session::get('plan'),
                        'trial_ends_at' => Carbon::now()->addDays(14),
                        'lower_access_user_id' => Auth::user()->id
                    ]
                );
        }
       

        DB::table('users_properties_relations')
        ->insert
                (
                    [
                        'user_id_foreign' => $user_id,
                        'property_id_foreign' => Session::get('property_id'),
                    ]
                );
            }       

       return redirect('property/all')->with('success', 'Users are added successfully. Please provide them with the password '.Carbon::now()->timestamp);
   }

   
   public function create_room(){

    return view('webapp.properties.rooms.create');
}


    public function store_room(Request $request){

        // return $request->all();



        $no_of_entry = (int) $request->no_of_entry;
       
        for ($i=1; $i <= $no_of_entry; $i++) { 
            for ($j=1; $j <= $request->input('no_of_room'.$i); $j++) { 
                $firstCharacter = $request->input('building'.$i); 
                $building =  str_replace(' ', '-',$request->input('building'.$i));

                $unit = new Unit();
                $unit->unit_no = $firstCharacter[0].'-'.$j;
                $unit->floor = 1;
                $unit->size = $request->input('size'.$i);
                $unit->building = $building; 
                $unit->status = 'vacant';
                $unit->rent = 0;
                $unit->type = 'residential';
                $unit->occupancy = 1;
                $unit->property_id_foreign = Session::get('property_id');
                $unit->save();

            }
          }


        return redirect('property/'.Session::get('property_id').'/bills/create')->with('success', 'Room are successfully created.');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response    
     */
    public function edit($property_id)
    {
        Session::put('notifications', Property::findOrFail($property_id)->unseen_notifications);

        Session::put('property_id', $property_id);

        $property = Property::findOrFail($property_id);
       
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        Session::put('property_type', Property::findOrFail(Session::get('property_type_id_foreign'))->type);

        Session::put('property_name', Property::findOrFail(Session::get('property_id'))->name);

        Session::put('property_address', Property::findOrFail(Session::get('property_id'))->address);

        Session::put('property_mobile', Property::findOrFail(Session::get('property_id'))->mobile);

        Session::put('footer_message', Property::findOrFail($property_id)->footer_message);

        Session::put('electric_rate_kwh', Property::findOrFail($property_id)->electric_rate_kwh);

        Session::put('water_rate_cum', Property::findOrFail($property_id)->water_rate_cum);

        return view('webapp.properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id)
    {
        $property = Property::findOrFail($property_id);

        $property->name = $request->name;
        $property->type = $request->type;
        $property->ownership = $request->ownership;
        $property->mobile = $request->mobile;
        $property->address = $request->address;
        $property->country = $request->country;
        $property->zip = $request->zip;
        $property->save();

        Session::put('property_id', $property_id);
       
         Session::put('notifications', Property::findOrFail($property_id)->unseen_notifications);

        Session::put('property_type', Property::findOrFail($property_id)->type);

        Session::put('property_name', Property::findOrFail($property_id)->name);

        Session::put('property_ownership', Property::findOrFail($property_id)->ownership);

        return redirect('/property/all')->with('success','Changes saved.');
     
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
