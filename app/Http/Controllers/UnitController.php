<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Unit, App\Bill;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Property;
use App\OccupancyRate;
use Session;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
                return $item->floor;
            });;
    
            $buildings = Property::findOrFail($property_id)
            ->units()
            ->where('status','<>','deleted')
            ->select('building', 'status', DB::raw('count(*) as count'))
            ->groupBy('building')
            ->get('building', 'status','count');
               
            $property = Property::findOrFail($property_id);
    
           if(Session::get('property_type') === 'Condominium Corporation'){
            return view('webapp.units.index',compact('units_occupied','units_vacant','units','buildings', 'units_count', 'property'));
           }else{
            return view('webapp.rooms.index',compact('units_occupied','units_vacant','units_reserved','units','buildings', 'units_count', 'property'));
           }
        }else{
            return view('website.unregistered');
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $unit_id)
    {
        if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'treasury'){
         
            $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
           ->where('property_id_foreign', $property_id)
           ->where('user_type','<>' ,'tenant')
           ->get();

            $home = Unit::findOrFail($unit_id);
        
            $owners = DB::table('certificates')
            ->join('owners', 'owner_id_foreign', 'owner_id')
            ->where('certificates.unit_id_foreign', $unit_id)
            ->get();
    
            $reported_by = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('unit_id', $unit_id)
            ->get();

            $occupants = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->select('*', 'contracts.rent as contract_rent')
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

    
            $bills = Bill::leftJoin('payments', 'bills.bill_no', '=', 'payments.payment_bill_no')
           ->join('units', 'bill_unit_id', 'unit_id')
           ->selectRaw('*, bills.amount - IFNULL(sum(payments.amt_paid),0) as balance')
           ->where('unit_id', $unit_id)
           ->groupBy('bill_id')
           ->orderBy('bill_no', 'desc')
           ->havingRaw('balance > 0')
           ->get();


           $concerns = DB::table('units')
            ->join('concerns', 'unit_id', 'concern_unit_id')
            ->join('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('unit_id', $unit_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();
            
            $property = Property::findOrFail(Session::get('property_id'));

            if(Session::get('property_type') === 'Condominium Corporation'){
                return view('webapp.units.show',compact('occupants','reported_by','users','property','home', 'owners', 'tenant_active', 'tenant_inactive', 'tenant_reserved', 'concerns'));
            }else{
                return view('webapp.rooms.show',compact('occupants','reported_by','users','property','home', 'owners', 'tenant_active', 'tenant_inactive', 'tenant_reserved', 'concerns'));
            }
          
        }else{
                return view('website.unregistered');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function edit_all($property_id){

        $units = DB::table('units')
        ->where('property_id_foreign', $property_id)
        ->orderBy('building', 'asc')
        ->orderBy('floor', 'asc')
        ->orderBy('unit_no', 'asc')
        ->get();

        $property = Property::findOrFail($property_id);

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations'){
            return view('webapp.units.edit-all', compact('units', 'property'));
        }else{
            return view('webapp.rooms.edit', compact('units', 'property'));
        }


 }

    
    public function add_multiple_units(Request $request){
        if(!$request->building){
            $building = 'Building-1';
        }else{
            $building =  str_replace(' ', '-',$request->building);
        }

        for($i = 1; $i<=$request->no_of_rooms; $i++ ) {
            $unit = new Unit();
            $unit->unit_no = $request->unit_no.'-'.$i;
            $unit->floor = $request->floor;
            $unit->building = $building;
            $unit->status = 'accepted';
            $unit->type = $request->type;
            $unit->occupancy = $request->occupancy;
            $unit->property_id_foreign = Session::get('property_id');
            $unit->save();
        }

       
        $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

        $occupied_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'occupied')->count();

        $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

        $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);

       
        if($current_occupancy_rate? $new_occupancy_rate/$current_occupancy_rate !== 1: 0){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }
        
        $property = Property::findOrFail(Session::get('property_id'));

        return back()->with('success', $request->no_of_rooms.' units have been added!');
      
        
     }

     public function update_all(Request $request, $property_id){

        $all_rooms = Property::findOrFail($property_id)->units->count();

        for($i = 1; $i<=$all_rooms; $i++){

             $room = Unit::findOrFail($request->input('unit_id'.$i));
             $room->unit_no = $request->input('unit_no'.$i);
             $room->type = $request->input('type'.$i);
             $room->status = $request->input('status'.$i);
             $room->building = $request->input('building'.$i);
             $room->floor = $request->input('floor'.$i);
             $room->occupancy = $request->input('occupancy'.$i);
             $room->rent = $request->input('rent'.$i);
             $room->save();
        }
        
      
        $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

        $occupied_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'occupied')->count();

         $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

         $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);

        if($current_occupancy_rate? $new_occupancy_rate/$current_occupancy_rate !== 1: 0){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }
     
        return redirect('/property/'. $property_id.'/home')->with('success','changes have been saved!');
                 
     }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
