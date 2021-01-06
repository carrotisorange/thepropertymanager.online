<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tenant;
use App\Payment;
use DB;
use App\Unit;
use App\Personnel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
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
use App\Owner;

class OccupantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $property_id)
    {

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'tenant';
        $notification->message = 'User '.Auth::user()->id.' opens tenants page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));
        
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

        return view('webapp.occupants.index', compact('tenants', 'count_tenants', 'property'));
    }else{
        return view('layouts.arsha.unregistered');
    }
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

        return view('webapp.occupants.create', compact('property', 'unit'));
    }

    public function create_prefilled($property_id, $unit_id)
    {   

        $current_owner_id = Unit::findOrFail($unit_id)->certificates()->orderBy('owner_id_foreign', 'desc')->first()->owner_id_foreign;

        $current_owner = Owner::find($current_owner_id);

        $unit = Unit::findOrFail($unit_id);

        $property = Property::findOrFail($property_id);

        return view('webapp.occupants.create_prefilled', compact('property', 'unit', 'current_owner'));
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
    
            'birthdate' => [],
            'gender' => [],
    
            'civil_status' => [],
            'id_number' => [],
        
            'email_address' => ['required', 'string', 'email', 'max:255', 'unique:tenants'],
            'contact_no' => ['required', 'unique:tenants'],
        ]);

        $latest_tenant_id = Tenant::all()->max('tenant_id')+1;

        $tenant_unique_id = Str::random(8);

        $tenant_id = DB::table('tenants')->insertGetId(
            [
                'tenant_unique_id' => $latest_tenant_id.$tenant_unique_id,
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

            DB::table('contracts')->insert(
                [
                    'contract_id' => Uuid::generate()->string,
                    'unit_id_foreign' => $unit_id,
                    'tenant_id_foreign' => $tenant_id,
                    'movein_at' => Carbon::now(),
                    'status' => 'active',
                    'created_at' =>Carbon::now(),
                ]
            );
            
            $unit = Unit::find($unit_id);
            $unit->status = 'occupied';
            $unit->save();
       
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

        $occupant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'success';
        $notification->message = $occupant->first_name.' '.$occupant->last_name.' has been added to the property!';
        $notification->save();
        
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

        return redirect('/property/'.$request->property_id.'/occupant/'.$tenant_id)->with('success', 'Occupant has been added!');
       
    }
   
    public function show($property_id, $tenant_id)
    {

        if(Auth::user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'treasury'){
           
           $tenant = Tenant::findOrFail($tenant_id);

           $units = Property::findOrFail($property_id)
           ->units()->whereIn('status',['vacant'])
           ->get()->groupBy(function($item) {
                return $item->floor;
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


            $concerns = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->where('tenant_id', $tenant_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();


        //    $payments = Tenant::findOrFail($tenant_id)->payments;


         $payments = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('payment_id')
        ->orderBy('ar_no', 'desc')
       ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->payment_created)->timestamp;
        });

              //get the number of last added bills
              if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                $current_bill_no = DB::table('units')
                ->join('bills', 'unit_id', 'bill_unit_id')
                ->where('property_id_foreign', Session::get('property_id'))
                ->max('bill_no') + 1;
        
            }else{
                $current_bill_no = DB::table('contracts')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->join('bills', 'tenant_id', 'bill_tenant_id')
                ->where('property_id_foreign', Session::get('property_id'))
                ->max('bill_no') + 1;
            }     

            $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            ->havingRaw('balance > 0')
            ->get();


            $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
            ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
            ->where('bill_tenant_id', $tenant_id)
            ->groupBy('bill_id')
            ->orderBy('bill_no', 'desc')
            // ->havingRaw('balance > 0')
            ->get();

               $access = DB::table('users')
              ->join('tenants', 'id', 'user_id_foreign')
              ->where('tenant_id', $tenant_id)
              ->get();
            
               if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                return view('webapp.occupants.show', compact('bills','buildings','units','guardians','contracts','access','tenant','users' ,'concerns', 'current_bill_no', 'balance', 'payments', 'property'));  
               }else{
                return view('webapp.tenants.show', compact('bills','buildings','units','guardians','contracts','access','tenant','users' ,'concerns', 'current_bill_no', 'balance', 'payments', 'property'));  
               }
        }else{
                return view('layouts.arsha.unregistered');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id, $tenant_id)
    {
        $property = Property::findOrFail($property_id);

        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){
            $tenant = Tenant::findOrFail($tenant_id);
            return view('webapp.occupants.edit', compact('tenant', 'property'));
        }else{
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
    public function update(Request $request,$property_id, $tenant_id)
    {   

        $occupant = Tenant::findOrFail($tenant_id);
        $occupant->first_name = $request->first_name;
        $occupant->middle_name = $request->middle_name;
        $occupant->last_name = $request->last_name;
        $occupant->birthdate = $request->birthdate;
        $occupant->gender = $request->gender;
        $occupant->civil_status = $request->civil_status;
        $occupant->id_number = $request->id_number;
        $occupant->contact_no = $request->contact_no;
        $occupant->email_address = $request->email_address;
        $occupant->barangay = $request->barangay;
        $occupant->city = $request->city;
        $occupant->id_number = $request->id_number;
        $occupant->province = $request->province;
        $occupant->country = $request->country;
        $occupant->save();
        
       return redirect('/property/'.$property_id.'/occupant/'.$tenant_id)->with('success','changes have been saved!');
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
