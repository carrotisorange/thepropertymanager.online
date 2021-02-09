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

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *n
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $property_id)
    {

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'unit';
        
        $notification->message = Auth::user()->name.' opens rooms page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        if(auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'admin' ){

            Session::put('status', $request->status);
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
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();
            }
            elseif(Session::has('type')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('type', Session::get('type'))
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();
            }
            elseif(Session::has('building')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('building', Session::get('building'))
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();
            }
            elseif(Session::has('floor')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('floor', Session::get('floor'))
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
              
                ->get();
            }
            elseif(Session::has('occupancy')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('occupancy', Session::get('occupancy'))
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();
            }
            elseif(Session::has('rent')){
                $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->where('rent', Session::get('rent'))
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
                ->get();
            }
            else{
                 $units = DB::table('units')
                ->where('property_id_foreign', Session::get('property_id'))
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'asc')
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

            $rents = Property::findOrFail($property_id)
            ->units()
            
            ->select('rent', DB::raw('count(*) as count'))
            ->orderBy('rent', 'asc')
            ->groupBy('rent')

            ->get('rent','count');
               
    
           if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            return view('webapp.units.condo',compact('units_occupied','units_vacant','units','buildings', 'units_count', 'property', 'units_dirty', 'st_contract'));
           }else{
            return view('webapp.rooms.index',compact('units','buildings', 'statuses','floors', 'types', 'occupancies', 'rents'));
           }
        }else{
            return view('layouts.arsha.unregistered');
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
           ->select('*', 'contracts.rent as contract_rent', 'contracts.term as contract_term')
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

           $remittances = DB::table('units')
           ->join('remittances', 'unit_id', 'remittances.unit_id_foreign')
           ->join('certificates', 'remittances.unit_id_foreign', 'certificates.unit_id_foreign')
         
           ->select('*', 'remittances.created_at as dateRemitted')
           ->where('remittances.unit_id_foreign',$unit_id)
           ->orderBy('remittances.created_at')
           ->get();

            $expenses = DB::table('units')
           ->join('expenses', 'unit_id', 'expenses.unit_id_foreign')
           
           ->join('certificates', 'expenses.unit_id_foreign', 'certificates.unit_id_foreign')
      
           ->select('*', 'expenses.created_at as dateCreated')
           ->where('expenses.unit_id_foreign',$unit_id)
           ->orderBy('expenses.created_at')
           ->get();


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
          
           
            return view('webapp.rooms.show',compact('occupants','reported_by','users','home', 'owners', 'tenant_active', 'tenant_inactive', 'tenant_reserved', 'concerns', 'remittances', 'expenses'));
           
        }else{
                return view('layouts.arsha.unregistered');
        }
        
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
            $unit->status = 'vacant';
            $unit->rent = $request->rent;
            $unit->type = 'residential';
            $unit->occupancy = $request->occupancy;
            $unit->property_id_foreign = Session::get('property_id');
            $unit->save();
       
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
 
            return back()->with('success', $request->no_of_rooms.' room is created sucessfully!');
        
     }

     public function edit_all($property_id){

            $units = DB::table('units')
            ->where('property_id_foreign', $property_id)
            ->orderBy('building', 'asc')
            ->orderBy('floor', 'asc')
            ->orderBy('unit_no', 'asc')
            ->get();

            $property = Property::findOrFail($property_id);

            if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                return view('webapp.units.edit', compact('units', 'property'));
            }else{
                return view('webapp.rooms.edit', compact('units', 'property'));
            }
    

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $id)
    {

            DB::table('units')->where('unit_id', $id)
            ->update([
                'unit_no' => $request->unit_no,
                'floor' => $request->floor,
                'occupancy' => $request->occupancy,
                'status' => $request->status,
                'building' => $request->building,
                'type' => $request->type,
                'rent' => $request->rent
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
            
            $notification->message = Auth::user()->name.' updates '.Unit::findOrFail($id)->unit_no.'.';
            $notification->save();
                        
            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

            return back()->with('success', 'Changes saved.');
       
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
