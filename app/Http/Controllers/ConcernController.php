<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, App\Tenant, App\Unit, App\Concern, Auth, Carbon\Carbon;
use App\Property;
use App\Response;
use Session;
use App\Notification;
use App\User;
use App\Personnel;
use App\Bill;

class ConcernController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']);
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {

        Session::put('current-page', 'concerns');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        
        $notification->message = Auth::user()->name.' opens concerns page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

       if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4){

            $all_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $pending_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concerns.status', 'pending')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $active_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concerns.status', 'active')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $closed_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concerns.status', 'closed')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();
       }else{
            $all_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concern_user_id', Auth::user()->id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $pending_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concern_user_id', Auth::user()->id)
            ->where('concerns.status', 'pending')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $active_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concern_user_id', Auth::user()->id)
            ->where('concerns.status', 'active')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

            $closed_concerns = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('property_id_foreign', Session::get('property_id'))
            ->where('concern_user_id', Auth::user()->id)
            ->where('concerns.status', 'closed')
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->get();

       }       

        return view('webapp.concerns.index', compact('all_concerns', 'pending_concerns', 'active_concerns', 'closed_concerns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create_room_concern(Request $request, $property_id, $room_id){


        $tenants = DB::table('contracts')
        ->select('*', 'contracts.status as contract_status')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->select('*', 'contracts.rent as contract_rent', 'contracts.term as contract_term', 'contracts.status as contract_status')
        ->where('unit_id', $room_id)
        ->get();

         $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->where('certificates.unit_id_foreign', $room_id)
        ->get();

        $users = DB::table('users_properties_relations')
        ->join('users','user_id_foreign','id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->whereNotIn('user_type' ,['tenant', 'owner'])
        ->get();

        $particulars = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        $room = Unit::findOrFail($room_id);

        return view('webapp.concerns.create-room-concern', compact('room', 'tenants', 'owners',
        'users','particulars'));
     }

     public function view_room_concern(Request $request, $property_id, $room_id, $tenant_id, $concern_id, $endorsed_to, $resolved_by){

        $tenants = DB::table('contracts')
        ->select('*', 'contracts.status as contract_status')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->select('*', 'contracts.rent as contract_rent', 'contracts.term as contract_term', 'contracts.status as contract_status')
        ->where('unit_id', $room_id)
        ->get();

        $owners = DB::table('certificates')
        ->join('owners', 'owner_id_foreign', 'owner_id')
        ->where('certificates.unit_id_foreign', $room_id)
        ->get();

        $users = DB::table('users_properties_relations')
        ->join('users','user_id_foreign','id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->whereNotIn('user_type' ,['tenant', 'owner'])
        ->get();

        $particulars = DB::table('particulars')
        ->join('property_bills', 'particular_id', 'particular_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('particular', 'asc')
        ->get();

        $materials = DB::table('materials_for_concerns')
        ->where('concern_id_foreign', $concern_id)
        ->get();

        $room  = Unit::findOrFail($room_id);

        $tenant = Tenant::findOrFail($tenant_id);

        $concern = Concern::findOrFail($concern_id);

        $endorsed_to = User::findOrFail($endorsed_to);

        $resolved_by = User::findOrFail($resolved_by);

        $responses = Concern::findOrFail($concern_id)->responses;

        return view('webapp.concerns.view-room-concern', compact('room', 'tenants', 'owners', 'users','particulars', 'tenant','concern','endorsed_to','resolved_by','materials','responses'));
     }

     public function update_room_concern(Request $request, $property_id, $room_id, $concern_id ){

        Session::put('current-page', 'concerns');

        $request->validate([
            'reported_at' => 'required', 
            'concern_unit_id' => 'required',
            'concern_tenant_id' => 'required',
            'contact_no' => 'required',
            'details' => 'required',
            'urgency' => 'required',
            'is_warranty' => 'required',
            'scheduled_at' => 'required',
            'concern_user_id' => 'required',
            'details' => 'required',
            'resolved_by' => '',
            'status' => 'required',
             'rating' => '',
             'remarks' => '',
             'action_taken' => '',
             'resolved_at' => ''
        ]);

        Concern::where('concern_id', $concern_id)
        ->update([
            'reported_at' => $request->reported_at, 
            'concern_unit_id' => $request->concern_unit_id,
            'concern_tenant_id' => $request->concern_tenant_id,
            'contact_no' => $request->contact_no,
            'details' => $request->details,
            'urgency' => $request->urgency,
            'is_warranty' => $request->is_warranty,
            'scheduled_at' => $request->scheduled_at,
            'concern_user_id' => $request->concern_user_id,
            'details' => $request->details,
            'resolved_by' => $request->resolved_by,
            'status' => $request->status,
             'rating' => $request->rating,
             'remarks' => $request->remarks,
             'action_taken' => $request->action_taken,
             'resolved_at' => $request->resolved_at,
        ]);

        return back()->with('success', 'Concern is updated successfully!');
     }

    public function create($property_id, $tenant_id)
    {

        Session::put('current-page', 'concerns');

        $contracts = DB::table('contracts')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->select('*', 'contracts.status as contract_status', 'contracts.term as contract_term')
        ->where('tenant_id', $tenant_id)
        ->orderBy('contracts.created_at', 'desc')
        ->get();

        $users = DB::table('users_properties_relations')
        ->join('users','user_id_foreign','id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->whereNotIn('user_type' ,['tenant', 'owner'])
        ->get();

        $tenant = Tenant::findOrFail($tenant_id);
        
        return view('webapp.concerns.create', compact('tenant', 'contracts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_details(Request $request, $property_id, $unit_id)
    {
   
        Session::put('current-page', 'concerns');

        $request->validate([
            'reported_at' => 'required', 
            'concern_unit_id' => 'required',
            'contact_no' => 'required',
            'concern_tenant_id' => 'required',
            'details' => 'required',
        ]);

             $explode = explode("-", $request->concern_tenant_id);

             $reported_by_user = $explode[0];

             if($reported_by_user === 'tenant'){
              $concern = new Concern();
              $concern->reported_at = $request->reported_at;
              $concern->concern_unit_id = $request->concern_unit_id;
              $concern->contact_no = $request->contact_no;
              $concern->concern_tenant_id = $explode[1];
              $concern->details = $request->details;
              $concern->status = 'pending';
              $concern->save();
             }else{
             $concern = new Concern();
             $concern->reported_at = $request->reported_at;
             $concern->concern_unit_id = $request->concern_unit_id;
             $concern->contact_no = $request->contact_no;
             $concern->owner_id_foreign = $explode[1];
             $concern->details = $request->details;
             $concern->status = 'pending';
             $concern->save();
             }

        
             $new_concern_id = $concern->concern_id;


        //store all the input fields to the input
        // $input = $request->all();

        //insert a new concern to the database
        // $new_concern_id = Concern::create($input)->concern_id;
        
        $unit = Unit::findOrFail($unit_id)->unit_no;
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        
        $notification->message = Auth::user()->name. ' adds a concern in '.$unit.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
          return
          redirect('/property/'.$property_id.'/room/'.$unit_id.'/tenant/'.$explode[1].'/concern/'.$new_concern_id.'/assessment')->with('success',
          'Concern is added sucessfully.');
         
        //  return redirect('/property/'.$property_id.'/room/'.$unit_id.'/tenant/'.$request->concern_tenant_id.'/concern/'.$new_concern_id.'/materials')->with('success', 'Concern is added sucessfully.');
    }

        public function create_assessment($property_id, $unit_id, $tenant_id, $concern_id)
        {
            $room = Unit::findOrFail($unit_id);

            $tenant = Tenant::findOrFail($tenant_id);

            $concern = Concern::findOrFail($concern_id);

            $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->whereNotIn('user_type' ,['tenant', 'owner'])
            ->get();

            $concern = Concern::findOrFail($concern_id);

             $personnels = Personnel::where('property_id_foreign', $property_id)->get();
            
            return view('webapp.concerns.create-assessment', compact('room','users', 'tenant','concern','personnels'));
        }

            public function store_assessment(Request $request, $property_id, $unit_id, $tenant_id, $concern_id)
            {
       

            $request->validate([
                'assessed_by_id' => 'required',
                'assessed_at' => 'required',
            'category' => 'required',
            'urgency' => 'required',
            'is_warranty' => 'required',
            'assessment' => 'required',
            ]);

            Concern::where('concern_id', $concern_id)
            ->update(
                [
                    'category' => $request->category,
                    'assessed_by_id' => $request->assessed_by_id,
                    'assessed_at' => $request->assessed_at,
                    'urgency' => $request->urgency,
                    'is_warranty' => $request->is_warranty,
                    'assessment' => $request->assessment,
                    'status' => 'assessed',
                ]
                );

            return
            redirect('/property/'.$property_id.'/room/'.$unit_id.'/tenant/'.$tenant_id.'/concern/'.$concern_id.'/scope_of_work')->with('success',
            'Assessment is added sucessfully.');

            }

         public function create_scope_of_work($property_id, $unit_id, $tenant_id, $concern_id)
         {

            $room = Unit::findOrFail($unit_id);

            $tenant = Tenant::findOrFail($tenant_id);

            $concern = Concern::findOrFail($concern_id);

            $users = DB::table('users_properties_relations')
            ->join('users','user_id_foreign','id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->whereNotIn('user_type' ,['tenant', 'owner'])
            ->get();

            $concern = Concern::findOrFail($concern_id);

            $personnels = Personnel::where('property_id_foreign', $property_id)->get();

            return view('webapp.concerns.create-scope-of-work', compact('room','users', 'tenant','concern','personnels'));
         }

          public function store_scope_of_work(Request $request, $property_id, $unit_id, $tenant_id, $concern_id)
          {

          $request->validate([
          'scheduled_at' => 'required',
          'ended_on' => 'required',
          'concern_user_id' => 'required',
          'scope_of_work' => 'required',
          ]);

          Concern::where('concern_id', $concern_id)
          ->update(
          [
          'scheduled_at' => $request->scheduled_at,
          'ended_on' => $request->ended_on,
          'concern_user_id' => $request->concern_user_id,
          'scope_of_work' => $request->scope_of_work,
          'status' => 'waiting for approval',
          ]
          );

          return
          redirect('/property/'.$property_id.'/room/'.$unit_id.'/tenant/'.$tenant_id.'/concern/'.$concern_id.'/materials')->with('success',
          'Scope of work is added sucessfully.');

          }

           public function create_materials($property_id, $unit_id, $tenant_id, $concern_id)
           {

          $particulars = DB::table('particulars')
          ->join('property_bills', 'particular_id', 'particular_id_foreign')
          ->where('property_id_foreign', Session::get('property_id'))
          ->orderBy('particular', 'asc')
          ->get();

          $materials = DB::table('materials_for_concerns')
          ->where('concern_id_foreign', $concern_id)
          ->get();

          $room = Unit::findOrFail($unit_id);

          $tenant = Tenant::findOrFail($tenant_id);

          $concern = Concern::findOrFail($concern_id);

           return view('webapp.concerns.create-materials', compact('particulars','materials',
           'room','tenant','concern'));
           }

      public function store_materials(Request $request, $property_id, $room_id, $tenant_id, $concern_id){

      $request->validate([
      'material' => 'required',
      'quantity' => 'required',
      'price' => 'required',
      'total_cost' => 'required',
      ]);

      DB::table('materials_for_concerns')
      ->insert(
      [
      'description' => $request->material,
      'quantity' => $request->quantity,
      'price' => $request->price,
      'total_cost' => $request->total_cost,
      'concern_id_foreign' => $concern_id,
      'created_at' => Carbon::now(),
      'status' => 'waiting for approval',
      ]
      );

      //get the last added bill no of the property
      $current_bill_no = DB::table('contracts')
      ->join('units', 'unit_id_foreign', 'unit_id')
      ->join('tenants', 'tenant_id_foreign', 'tenant_id')
      ->join('bills', 'tenant_id', 'bill_tenant_id')
      ->where('property_id_foreign', Session::get('property_id'))
      ->max('bill_no') + 1;

      Bill::create([
      'bill_no' => $current_bill_no,
      'bill_tenant_id' => $tenant_id,
      'date_posted' => Carbon::now(),
      'particular_id_foreign' => '20',
      'amount'=> $request->total_cost,
      ]);


          return
          back()->with('success',
          'Material is added sucessfully.');
      }

      public function remove_material($material_id){
          DB::table('materials_for_concerns')
          ->where('material_id',$material_id)
          ->delete();

          return back()->with('success','Material is removed successfully!');
      }

       public function create_approval($property_id, $unit_id, $tenant_id, $concern_id)
       { 

        $concern = Concern::findOrFail($concern_id);

        if($concern->approved_by_tenant_at && $concern->approved_by_owner_at && $concern->approved_by_manager_at){
            Concern::where('concern_id', $concern_id)
            ->update(
            [
            'status' => 'approved',
            ]
            );
        }
                 
        $particulars = DB::table('particulars')
       ->join('property_bills', 'particular_id', 'particular_id_foreign')
       ->where('property_id_foreign', Session::get('property_id'))
       ->orderBy('particular', 'asc')
       ->get();

       $materials = DB::table('materials_for_concerns')
       ->where('concern_id_foreign', $concern_id)
       ->get();

       $room = Unit::findOrFail($unit_id);

       $tenant = Tenant::findOrFail($tenant_id);

       $concern = Concern::findOrFail($concern_id);

        return view('webapp.concerns.create-approval', compact('particulars','materials',
        'room','tenant','concern'));
        }

         public function create_payment_options($property_id, $room_id, $tenant_id, $concern_id){

               $room = Unit::findOrFail($room_id);

               $tenant = Tenant::findOrFail($tenant_id);

               $concern = Concern::findOrFail($concern_id);

            return view('webapp.concerns.create-payment-options', compact('room','tenant','concern'));

        }

        public function store_payment_options(Request $request, $property_id, $room_id, $tenant_id, $concern_id){


        $request->validate([
        'payee' => 'required',
        'payment_options' => 'required',
        ]);

          Concern::where('concern_id', $concern_id)
          ->update(
          [
          'payee' => $request->payee,
          'payment_options' => $request->payment_options,
          ]
          );

        return
        back()->with('success',
        'Payment option is set sucessfully.');
        }
  
    public function store(Request $request, $property_id, $tenant_id)
    {

        $concern = new Concern();
        $concern->reported_at = $request->reported_at;
        $concern->category = $request->concern_department;
        $concern->urgency = $request->urgency;
        $concern->is_warranty = $request->is_warranty;
        $concern->concern_tenant_id = $request->concern_tenant_id;
        $concern->concern_unit_id = $request->concern_unit_id;
        $concern->contact_no = $request->contact_no;
        $concern->details = $request->details;
        $concern->concern_user_id = $request->endorsed_to;
        $concern->resolved_by = $request->resolved_by;
        $concern->remarks = $request->remarks;
        $concern->status = $request->status;
        $concern->action_taken = $request->action_taken;
        $concern->scheduled_at = $request->scheduled_at;
        $concern->save();

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        
        $notification->message = Auth::user()->name. ' adds a concern for reported by '. $tenant->first_name.' '.$tenant->last_name.'.';
        $notification->save();
                
         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);


            if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6'){
                return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#concerns')->with('success', 'Concern is added sucessfully.');
            }else{
                return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#concerns')->with('success', 'Concern is added sucessfully.');
            }
            

           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    public function show_assigned_concerns($property_id, $concern_id, $user_id)
    {
        Session::put('current-page', 'concerns');

            $concern = Concern::findOrFail($concern_id);

             $users = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('users', 'user_id_foreign', 'id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->whereNotIn('user_type', ['tenant', 'owner'])
            ->get();
            
            $concern_details = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('concern_id', $concern_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->limit(1)
            ->get();

            $personnels = Property::findOrFail($property_id)->personnels;

            $responses = Concern::findOrFail($concern_id)->responses;

            // $responses = DB::table('concerns')
            // ->join('responses', 'concern_id', 'concern_id_foreign')
            // ->select('*', 'responses.created_at as created_at')
            // ->where('concern_id', $concern_id)
            // ->orderBy('responses.created_at', 'desc')
            // ->get();

            $property = Property::findOrFail($property_id);
      
       return view('webapp.concerns.show-assigned-concern', compact('concern', 'responses', 'property','concern_details', 'personnels', 'users'));

    }

    public function show($property_id, $concern_id)
    {
        
        Session::put('current-page', 'concerns');

        if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 5 || auth()->user()->role_id_foreign === 3){
        
            // $tenant = Tenant::findOrFail($tenant_id);

            // $unit = Unit::findOrFail($unit_id);

            $concern = Concern::findOrFail($concern_id);

             $users = DB::table('users_properties_relations')
            ->join('properties', 'property_id_foreign', 'property_id')
            ->join('users', 'user_id_foreign', 'id')
            ->where('property_id_foreign', Session::get('property_id'))
            ->whereNotIn('user_type', ['tenant', 'owner'])
            ->get();
            
            $concern_details = DB::table('contracts')
            ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
            ->leftJoin('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->leftJoin('users', 'concern_user_id', 'id')
            ->select('*', 'concerns.status as concern_status')
            ->where('concern_id', $concern_id)
            ->orderBy('reported_at', 'desc')
            ->orderBy('urgency', 'desc')
            ->orderBy('concerns.status', 'desc')
            ->limit(1)
            ->get();

            $personnels = Property::findOrFail($property_id)->personnels;

            $responses = Concern::findOrFail($concern_id)->responses;

            // $responses = DB::table('concerns')
            // ->join('responses', 'concern_id', 'concern_id_foreign')
            // ->select('*', 'responses.created_at as created_at')
            // ->where('concern_id', $concern_id)
            // ->orderBy('responses.created_at', 'desc')
            // ->get();

            $property = Property::findOrFail($property_id);
      
       return view('webapp.concerns.show', compact('concern', 'responses', 'property','concern_details', 'personnels', 'users'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $concern_id)
    {
        
        DB::table('concerns')
        ->where('concern_id', $concern_id)
        ->update([
            'reported_at' => $request->reported_at,
            'title' => $request->title,
            'category' => $request->category,
            'details' => $request->details,
            'urgency' => $request->urgency
        ]);

        $concern = Concern::findOrFail($concern_id);    

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        
        $notification->message = Auth::user()->name.' updates concern '.$concern->concern_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return back()->with('success', 'Changes saved.');
    }

    public function pending()
    {
        Session::put('current-page', 'dashboard');

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

        return view('webapp.concerns.pending', compact('pending_concerns'));
    }

    public function forward(Request $request, $property_id, $concern_id){
        DB::table('concerns')
        ->where('concern_id', $concern_id)
        ->update([
            'concern_user_id' => $request->concern_user_id,
            'urgency' => $request->urgency
        ]);

        $concern = Concern::findOrFail($concern_id);    

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        
        $notification->message = Auth::user()->name.' forward concern '.$concern->concern_id.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        return back()->with('success', 'Concern forwarded successfully.');
    }

    public function closed(Request $request){

        if($request->rating === null){
            return back()->with('danger', 'Please provide a rating for the employee.');
        }else{
            DB::table('concerns')
            ->where('concern_id', $request->concern_id)
            ->update(
                [
                    'status' => 'closed',
                    'rating' => $request->rating,
                    'feedback' => $request->feedback,
                    'updated_at' => Carbon::now(),
                ]
            );

            DB::table('responses')
            ->insertGetId(
                  [
                      'concern_id_foreign' => $request->concern_id,
                      'response' => 'Tenant closes the concern and provides a rating of '.$request->rating.'/5',
                      'posted_by' => Auth::user()->name,
                      'created_at' => Carbon::now(),
                  ]
            );

        $concern = Concern::findOrFail($request->concern_id);

        if($concern->concern_user_id!=null){

            $user = User::findOrFail($concern->concern_user_id); 

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'concern';
            
            $notification->message =  Auth::user()->name.' rates  '.$user->name.' for resolving a concern.';
            $notification->save();
         
        }else{
             
            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'concern';
            
            $notification->message =  Auth::user()->name.' rates no one for resolving a concern.';
            $notification->save();
        }

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
    
        return back()->with('success', 'Concern closed sucessfully.');
        }
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
