<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit, App\UnitOwner, App\Tenant, DB, App\User, App\Property;
use App\Charts\DashboardChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Billing;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($property_id)
    {
    if(auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'admin' ){

        $units_count = Property::findOrFail($property_id)
        ->units->where('status','<>','deleted')
        ->count();

    
        $units_occupied = Property::findOrFail(Session::get('property_id'))->units->where('status', 'occupied')->count();

        $units_vacant = Property::findOrFail(Session::get('property_id'))->units->where('status', 'vacant')->count();
       
         $units_reserved =  Property::findOrFail(Session::get('property_id'))->units->where('status', 'reserved')->count();
        

       $units = Property::findOrFail($property_id)
       ->units()->where('status','<>','deleted')
       ->get()->groupBy(function($item) {
            return $item->floor_no;
        });;

        $buildings = Property::findOrFail($property_id)
        ->units()
        ->where('status','<>','deleted')
        ->select('building', 'status', DB::raw('count(*) as count'))
        ->groupBy('building')
        ->get('building', 'status','count');
    
        $property = Property::findOrFail($property_id);

        return view('webapp.home.home',compact(    'units_occupied','units_vacant','units_reserved','units','buildings', 'units_count', 'property'));
    }else{
        return view('website.unregistered');
    }
}
    public function show($property_id, $unit_id){
       
        if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'treasury'){
         
            $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
           ->where('property_id_foreign', $property_id)
           ->where('user_type','<>' ,'tenant')
           ->get();

            $home = Unit::findOrFail($unit_id);

            $property = Property::findOrFail($property_id);

            $owners = DB::table('certificates')
            ->join('unit_owners', 'owner_id_foreign', 'unit_owner_id')
            ->where('certificates.unit_id_foreign', $unit_id)
            ->get();
    
            $reported_by = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('unit_id', $unit_id)
            ->get();

           $tenant_active = DB::table('contracts')
           ->join('tenants', 'tenant_id_foreign', 'tenant_id')
           ->join('units', 'unit_id_foreign', 'unit_id')
           ->select('*', 'contracts.rent as contract_rent')
           ->where('unit_id', $unit_id)
           ->where('contracts.status', 'active')
           ->get();

            $tenant_inactive =DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('unit_id', $unit_id)
            ->where('contracts.status', 'inactive')
            ->get();

            $tenant_reserved = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('unit_id', $unit_id)
            ->where('contracts.status', 'pending')
            ->get();

            // $bills = DB::table('contracts')
            // ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            // ->join('units', 'unit_id_foreign', 'unit_id')
            // ->join('billings', 'tenant_id', 'billing_tenant_id')
            // ->where('unit_id', $unit_id)
            // ->orderBy('billing_id', 'desc')
            // ->groupBy('billing_id')
            // ->get();

            
            $bills = Billing::leftJoin('payments', 'billings.billing_no', '=', 'payments.payment_billing_no')
           ->join('tenants', 'billing_tenant_id', 'tenant_id')
           ->selectRaw('*, billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
           ->where('unit_tenant_id', $unit_id)
           ->groupBy('billing_id')
           ->orderBy('billing_no', 'desc')
           ->havingRaw('balance > 0')
           ->get();


        //     $bills = Billing::leftJoin('payments', 'billings.billing_no', '=', 'payments.payment_billing_no')
        //    ->join('tenants', 'billing_tenant_id', 'tenant_id')
        //    ->selectRaw('*, billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
        //    ->where('unit_tenant_id', $unit_id)
        //    ->groupBy('billing_id')
        //    ->orderBy('billing_no', 'desc')
        //    ->havingRaw('balance > 0')
        //    ->get();

           $concerns = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->where('unit_id', $unit_id)
            ->orderBy('date_reported', 'desc')
            ->orderBy('concern_urgency', 'desc')
            ->orderBy('concern_status', 'desc')
            ->get();
            

                // if(Auth::user()->property_type === 'Apartment Rentals' || Auth::user()->property_type === 'Dormitory'){
                    return view('webapp.home.show',compact('reported_by','users','property','home', 'owners', 'tenant_active', 'tenant_inactive', 'tenant_reserved', 'bills', 'concerns'));
                // }
                // else{
                //     return view('webapp.home.show-unit',compact('unit', 'unit_owner', 'tenant_active', 'tenant_inactive', 'tenant_reservations', 'bills', 'concerns'));
                // }
        }else{
                return view('website.unregistered');
        }
    
    }
}
