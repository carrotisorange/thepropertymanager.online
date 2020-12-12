<?php

namespace App\Http\Controllers;

use App\Property;
use DB;
use Auth;
use App\Unit, App\Owner, App\Tenant, App\User, App\Billing;
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
       

                $existing_users = DB::table('users')->where('property', Auth::user()->property)
                ->where('id','<>',Auth::user()->id )
                ->count();

        return view('webapp.properties.index', compact('properties', 'users','existing_users')); 

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
            }else{
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
        $notification->type = 'success';
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


        return redirect('property/all')->with('success', 'New property has been added!');

    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($property_id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
