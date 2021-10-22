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
use App\Notification;

class UnitController extends Controller
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
        
        Session::put('current-page', 'units');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'unit';
        
        $notification->message = Auth::user()->name.' opens rooms page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        if(auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 1 ){

            Session::put('status', $request->status);
            Session::put('size', $request->size);
            Session::put('type', $request->type);
            Session::put('building', $request->building);
            Session::put('occupancy', $request->occupancy);
            Session::put('rent', $request->rent);
            Session::put('floor', $request->floor);

            // $units = DB::table('units')
            // ->where('property_id_foreign', Session::get('property_id'))
            // ->orWhere(function($query) {
            //     $query->where('status', Session::get('status'))
            //     ->where('type', Session::get('type'))
            //     ->where('building', Session::get('building'))
            //     ->where('occupancy', Session::get('occupancy'))
            //     ->where('rent', Session::get('rent'))
            //     ->where('floor', Session::get('floor'));
            // })
                
            // ->get();

        //    $units = Property::findOrFail($property_id)
        //    ->units()->where('status','<>','deleted')
      
        //    ->get()->groupBy(function($item) {
        //         return $item->floor;
        //     });

            if(Session::has('status')){
               $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('status', Session::get('status'))
                ->orderBy('unit_no', 'asc')
          
                ->get();
            }
            elseif(Session::has('type')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('type', Session::get('type'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }
            elseif(Session::has('building')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('building', Session::get('building'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }
            elseif(Session::has('floor')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('floor', Session::get('floor'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }
            elseif(Session::has('occupancy')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('occupancy', Session::get('occupancy'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }
            elseif(Session::has('rent')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('rent', Session::get('rent'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }
            elseif(Session::has('size')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('size', Session::get('size'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }
            else{
                 $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->orderBy('unit_no', 'asc')
                ->get();
            }

            $buildings = Property::findOrFail($property_id)
            ->units()
            ->where('status','<>','deleted')
            ->select('building', 'status', DB::raw('count(*) as count'))
            ->groupBy('building')
            ->get('building', 'status','count');

            $statuses = Property::findOrFail($property_id)
            ->units()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get('status','count');

            $floors = Property::findOrFail($property_id)
            ->units()
            ->select('floor', DB::raw('count(*) as count'))
            ->groupBy('floor')
            ->get('floor','count');

            $types = Property::findOrFail($property_id)
            ->units()
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get('type','count');

            $occupancies = Property::findOrFail($property_id)
            ->units()
            ->select('occupancy', DB::raw('count(*) as count'))
            ->groupBy('occupancy')
            ->get('occupancy','count');

            
            $sizes = Property::findOrFail($property_id)
            ->units()
            ->select('size', DB::raw('count(*) as count'))
            ->groupBy('size')
            ->get('size','count');

            $rents = Property::findOrFail($property_id)
            ->units()
            
            ->select('rent', DB::raw('count(*) as count'))
            ->orderBy('rent', 'asc')
            ->groupBy('rent')

            ->get('rent','count');
            
            $room_types = DB::table('unit_types')->get();

            $room_floors = DB::table('unit_floors')->get();
    
           if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
            return view('webapp.units.index',compact('units','buildings', 'statuses','floors', 'types', 'occupancies', 'rents', 'sizes','room_types','room_floors'));
           }else{
            return view('webapp.rooms.index',compact('units','buildings', 'statuses','floors', 'types', 'occupancies', 'rents', 'sizes','room_types','room_floors'));
           }
        }else{
            return view('layouts.arsha.unregistered');
        }
    }

    public function clear_units_filters($property_id)
    {
        // Session::forget(['status', 'type', 'building', 'occupancy', 'rent', 'floor']);

        return redirect('/property/'.$property_id.'/units');
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
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $unit_id)
    {
        Session::put('current-page', 'units');

         $property_bills = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 5){
         
            $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
           ->where('property_id_foreign', $property_id)
           ->where('role_id_foreign','<>' ,'6')
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
            ->select('*', 'contracts.rent as contract_rent', 'contracts.term as contract_term')
            ->where('unit_id', $unit_id)
            ->where('contracts.status', 'active')
            ->get();

            $payments = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
            ->join('contracts', 'bill_unit_id', 'unit_id_foreign')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('bill_unit_id', $unit_id)
            ->groupBy('payment_id')
            ->orderBy('payment_created', 'desc')
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
           

           $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
           ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as amt_paid')
           ->where('bill_unit_id', $unit_id)
           ->groupBy('bill_id')
           ->orderBy('bill_no', 'desc')
           #->havingRaw('balance > 0')
           ->get();


           $concerns = DB::table('units')
            ->join('concerns', 'unit_id', 'concern_unit_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('unit_id', $unit_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

                return view('webapp.units.show',compact('occupants','bills','reported_by','users','property_bills','home', 'owners', 'tenant_active', 'tenant_inactive', 'tenant_reserved', 'concerns', 'payments'));
           
             
          
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
    public function edit($id)
    {
        //
    }

    public function edit_all($property_id){

        Session::put('current-page', 'units');

        $units = DB::table('units')
        ->where('property_id_foreign', $property_id)
        ->orderBy('building', 'asc')
        ->orderBy('floor', 'asc')
        ->orderBy('unit_no', 'asc')
        ->get();

        return view('webapp.units.edit', compact('units'));
 }

    
    public function store(Request $request){
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

        $occupied_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'accepted')->count();

        $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

        $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);

        if($current_occupancy_rate !== $new_occupancy_rate){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }
        
        $property = Property::findOrFail(Session::get('property_id'));

        return back()->with('success', $request->no_of_rooms.' unit is successfully created!');
      
        
     }

     public function update_all(Request $request, $property_id){

        $all_rooms = Property::findOrFail($property_id)->units->count();

        for($i = 1; $i<=$all_rooms; $i++){
            if(!$request->input('building'.$i)){
                $building = 'Building-1';
            }else{
                $building =  str_replace(' ', '-',$request->input('building'.$i));
            }
            
             $room = Unit::findOrFail($request->input('unit_id'.$i));
             $room->unit_no = $request->input('unit_no'.$i);
             $room->type = $request->input('type'.$i);
             $room->status = $request->input('status'.$i);
             $room->building = $building;
             $room->floor = $request->input('floor'.$i);
             $room->occupancy = $request->input('occupancy'.$i);
             $room->rent = $request->input('rent'.$i);
             $room->save();
        }
        
      
        $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

        $occupied_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'accepted')->count();

        $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

        $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);

        if($current_occupancy_rate !== $new_occupancy_rate){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }
     
        return redirect('/property/'. $property_id.'/units')->with('success','Changes saved.');
                 
     }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $unit_id)
    {

        $unit = Unit::findOrFail($unit_id);
        $unit->unit_no = $request->unit_no;
        $unit->floor = $request->floor;
        $unit->building = $request->building;
        $unit->type = $request->type;
        $unit->occupancy = $request->occupancy;
        $unit->status = $request->status;
        $unit->save();

        $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

        $accepted_rooms = Property::findOrFail( Session::get('property_id'))->units->where('status', 'accepted')->count();

        $current_occupancy_rate = Property::findOrFail( Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

        $new_occupancy_rate = number_format(($accepted_rooms/$active_rooms) * 100,2);

        if($current_occupancy_rate !== $new_occupancy_rate){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }

        return back()->with('success', 'Changes saved.');
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
