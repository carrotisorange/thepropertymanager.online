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
use App\Inventory;
use App\Contract;

class RoomController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'is_user_a_manager']);
    }
       
    /**
     * Display a listing of the resource.
     *n
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $property_id)
    {
        Session::put('current-page', 'rooms');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'unit';
        
        $notification->message = Auth::user()->name.' opens rooms page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            Session::put('status', $request->status);
            Session::put('size', $request->size);
            Session::put('type', $request->type);
            Session::put('building', $request->building);
            Session::put('occupancy', $request->occupancy);
            Session::put('rent', $request->rent);
            Session::put('floor', $request->floor);

            // if(Session::has('status')){
            //    $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('status', Session::get('status'))
            //     ->orderBy('unit_no', 'desc')
          
            //     ->get();
            // }
            // elseif(Session::has('type')){
            //     $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('type', Session::get('type'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }
            // elseif(Session::has('building')){
            //     $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('building', Session::get('building'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }
            // elseif(Session::has('floor')){
            //     $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('floor', Session::get('floor'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }
            // elseif(Session::has('occupancy')){
            //     $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('occupancy', Session::get('occupancy'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }
            // elseif(Session::has('rent')){
            //     $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('rent', Session::get('rent'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }
            // elseif(Session::has('size')){
            //     $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->where('size', Session::get('size'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }
            // else{
            //      $units = DB::table('units')
            //     ->where('property_id_foreign', Session::get('property_id'))
            //     ->orderBy('unit_no', 'desc')
            //     ->get();
            // }

           $units = DB::table('units')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('unit_no', 'asc')
             ->orderBy('floor', 'desc')
            ->where('units.status', '!=', 'deleted')
            ->get();
            
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
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room_types = DB::table('unit_types')->get();

        $room_floors = DB::table('unit_floors')->get();

        return view('webapp.rooms.create', compact('room_types', 'room_floors'));
    }

    public function clear($property_id)
    {
        // Session::forget(['status', 'type', 'building', 'occupancy', 'rent', 'floor']);

        return redirect('/property/'.$property_id.'/rooms');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $unit_id)
    {

        Session::put('current-page', 'rooms');
  
             $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
           ->where('property_id_foreign', Session::get('property_id'))
           ->whereNotIn('role_id_foreign' ,['6', '7', '8'])
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

            $tenants = DB::table('contracts')
           ->join('tenants', 'tenant_id_foreign', 'tenant_id')
           ->join('units', 'unit_id_foreign', 'unit_id')
           ->select('*', 'contracts.rent as contract_rent', 'contracts.term as contract_term', 'contracts.status as contract_status')
           ->where('unit_id', $unit_id)
           ->get();

             $revenues = Contract::
             join('tenants', 'tenant_id_foreign', 'tenant_id')
             ->join('payments', 'payment_tenant_id', 'tenant_id')
             ->join('units', 'unit_id_foreign', 'unit_id')
              ->join('bills', 'unit_id', 'bill_unit_id')
              ->join('particulars', 'particular_id_foreign', 'particular_id')
             ->where('unit_id', $unit_id)
             ->whereNull('payments.deleted_at')
             ->orderBy('payment_created', 'desc')
             ->groupBy('payment_id')
             ->get();

            $inventories = Inventory::where('unit_id_foreign', $unit_id)
            ->orderBy('created_at', 'asc')
            ->get();
       
           $remittances = Unit::findOrFail($unit_id)->remittances;

           $expenses = Unit::findOrFail($unit_id)->expenses;

           $concerns = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('unit_id', $unit_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $pending_concerns = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('unit_id', $unit_id)
            ->where('concerns.status', 'pending')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $room_types = DB::table('unit_types')->get();

            $room_floors = DB::table('unit_floors')->get();

             $bills = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
             ->join('particulars','particular_id_foreign', 'particular_id')
             ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance, IFNULL(sum(payments.amt_paid),0) as
             amt_paid')
             ->where('bill_unit_id', $unit_id)
             ->groupBy('bill_id')
             ->orderBy('bill_no', 'desc')
             // ->havingRaw('balance > 0')
             ->get();
          
            return
            view('webapp.rooms.show',compact('room_floors','room_types','tenants','occupants','reported_by','users','home',
            'owners','concerns', 'remittances', 'expenses','pending_concerns', 'inventories', 'revenues', 'bills'));
           
       
    }

    public function store(Request $request){

        if(Session::get('property_type') !== 5)
            $this->validate($request, [
            'unit_type_id_foreign' => 'required',
            'unit_floor_id_foreign' => 'required|integer',
            'unit_no' => 'required',
            'occupancy' => 'required|integer',
            'rent' => 'required',
            'no_of_rooms' => 'required|integer',
            ]);
        else{
            $this->validate($request, [
            'unit_type_id_foreign' => 'required',
            'unit_floor_id_foreign' => 'required|integer',
            'unit_no' => 'required',
        
            'no_of_rooms' => 'required|integer',
            ]);
        }

      

        if(!$request->building){
            $building = 'Building-1';
        }else{
            $building =  str_replace(' ', '-',$request->building);
        }

        for($i = 1; $i<=$request->no_of_rooms; $i++ ) {
            Unit::create([
                'unit_no' => $request->unit_no.'-'.$i,
                'unit_type_id_foreign' => $request->unit_type_id_foreign,
                'building' => $building,
                'size' => $request->size,
                'unit_floor_id_foreign' => $request->unit_floor_id_foreign,
                'occupancy' => $request->occupancy,
                'rent'=>$request->occupancy,
                'property_id_foreign' => Session::get('property_id'),
                'status' => 'vacant', 
            ]);

            // $unit = new Unit();
            // $unit->unit_no = $request->unit_no.'-'.$i;
            // $unit->floor = $request->floor;
            // $unit->size = $request->size;
            // $unit->building = $building;
            // $unit->unit_type_id_foreign = $request->room_type;
            // $unit->unit_floor_id_foreign = $request->floor;
            // $unit->status = 'vacant';
            // $unit->rent = $request->rent;
            // $unit->type = 'residential';
            // $unit->occupancy = $request->occupancy;
            // $unit->property_id_foreign = Session::get('property_id');
            // $unit->save();
       
        }

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

        $property = Property::findOrFail(Session::get('property_id'));
 
            return redirect('/property/'.Session::get('property_id').'/rooms')->with('success', $request->no_of_rooms.' Rooms are created sucessfully!');
        
     }

     public function edit_all(){
    
        Session::put('current-page', 'rooms');

            $units = DB::table('units')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('building', 'asc')
            ->orderBy('floor', 'asc')
            ->orderBy('unit_no', 'asc')
            ->get();

            if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
                return view('webapp.units.edit-all', compact('units'));
            }else{
                return view('webapp.rooms.edit-all', compact('units'));
            }
    

     }

     public function update_all(Request $request, $property_id){

        $all_rooms = Property::findOrFail(Session::get('property_id'))->units->count();

        for($i = 1; $i<=$all_rooms; $i++){

             $room = Unit::findOrFail($request->input('unit_id'.$i));
             $room->unit_no = $request->input('unit_no'.$i);
             $room->type = $request->input('type'.$i);
             $room->size = $request->input('size'.$i);
             $room->status = $request->input('status'.$i);
             $room->building = $request->input('building'.$i);
             $room->floor = $request->input('floor'.$i);
             $room->occupancy = $request->input('occupancy'.$i);
             $room->rent = $request->input('rent'.$i);
             $room->term = $request->input('term'.$i);
             $room->save();
        }
        
        $active_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status','<>','deleted')->count();

        $occupied_rooms = Property::findOrFail(Session::get('property_id'))->units->where('status', 'occupied')->count();

        $current_occupancy_rate = Property::findOrFail(Session::get('property_id'))->current_occupancy_rate()->orderBy('id', 'desc')->first()->occupancy_rate;

        $new_occupancy_rate = number_format(($occupied_rooms/$active_rooms) * 100,2);

        if($current_occupancy_rate !== $new_occupancy_rate){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();
        }
     
        return back()->with('success','Changes saved.');
                 
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($property_id, $room_id)
    {
        $room = Unit::findOrFail($room_id);

        $room_types = DB::table('unit_types')->get();

        $room_floors = DB::table('unit_floors')->get();

        return view('webapp.rooms.edit', compact('room', 'room_types', 'room_floors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $room_id)
    {

        Unit::where('unit_id', $room_id)
            ->update([
                'unit_no'=>$request->unit_no,
                'floor' => $request->floor,
                'occupancy' => $request->occupancy,
                'status' => $request->status,
                'building' => $request->building,
                'unit_type_id_foreign' => $request->unit_type_id_foreign,
                'unit_floor_id_foreign' => $request->unit_floor_id_foreign,
                'rent' => $request->rent,
                'size' => $request->size,
                'updated_at' => Carbon::now(),
            ]);
 
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
            
            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'room';
            
            $notification->message = Auth::user()->name.' updates '.Unit::findOrFail($room_id)->unit_no.'.';
            $notification->save();
                        
            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            return redirect('/property/'.Session::get('property_id').'/room/'.$room_id)->with('success', 'Changes saved.');
       
    }

    public function show_vacant_units($property){

        if(Auth::check()){
            return view('layouts.arsha.unregistered');
        }
        else
        $buildings = DB::table('units')
        ->select('building',DB::raw('count(*) as count'))
        ->whereIn('status', ['vacant','reserved'])
        ->where('status','<>','deleted')
        ->where('unit_property', $property)
        ->groupBy('building')
        ->get();

        $units = DB::table('units')
        ->whereIn('status', ['vacant','reserved'])
        ->where('unit_property', $property)
        ->where('status','<>','deleted')
        ->get();

        return view('reservation-forms.show-vacant-units', compact('buildings','units'));
    }
    public function upload(Request $request, $property_id, $room_id){
        // $image_code = '';
        // $images = $request->file('file');
        // foreach($images as $image)
        // {
        //  $new_name = rand() . '.' . $image->getClientOriginalExtension();
        //  $image->move(public_path('images'), $new_name);
        //  $image_code .= '<div class="col-md-3" style="margin-bottom:24px;"><img src="/images/'.$new_name.'" class="img-thumbnail" /></div>';
        // }
   
        // $output = array(
        //  'success'  => 'Images uploaded successfully',
        //  'image'   => $image_code
        // );
   
        // return response()->json($output);
    }

    public function show_property(){
       
         $properties = DB::table('units')
        ->select('unit_property',DB::raw('count(distinct building) as count_building'),DB::raw('count(distinct unit_no) as count_unit_no'))
        ->groupBy('unit_property')        
        ->get('unit_property', 'count_building','count_unit_no');

        return view('reservation-forms.show-property', compact('properties'));

    }

    public function show_reservation_form($property, $unit_id){

  
        $unit = Unit::whereIn('status', ['vacant', 'reserved'])->findOrFail($unit_id);

        return view('reservation-forms.show-reservation-form', compact('unit'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $property_id, $unit_id)
    {
        DB::table('units')->where('unit_id', $unit_id)
            ->update([
                'status' => 'deleted',
            ]);

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
                                'property_id_foreign' => $property_id,
                               'occupancy_date' => Carbon::now(),'created_at' => Carbon::now(),
                            ]
                        );
  
        return back()->with('success', 'Room archived successfully.');
       
    }

    public function restore(Request $request, $property_id, $unit_id)
    {
        DB::table('units')->where('unit_id', $unit_id)
            ->update([
                'status' => NULL,
            ]);

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
                                'property_id_foreign' => $property_id,
                               'occupancy_date' => Carbon::now(),'created_at' => Carbon::now(),
                            ]
                        );
  
        return back()->with('success', 'Room restored successfully.');
       
    }
}
