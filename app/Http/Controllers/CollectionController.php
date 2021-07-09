<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;
use App\Charts\DashboardChart;
use App\Unit, App\Owner, App\Tenant, App\User, App\Payment, App\Bill;
use Carbon\Carbon;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;
use App\Property;
use App\Contract;
use Session;
use App\Notification;
use App\OccupancyRate;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function delinquents()
    {

        Session::put('current-page', 'dashboard');

        $delinquents = Tenant::leftJoin('bills', 'tenant_id','bill_tenant_id')
        ->leftJoin('payments', 'bill_id','payment_bill_id')
      ->leftJoin('contracts', 'tenant_id', 'tenant_id_foreign')
    
      ->leftJoin('units', 'unit_id_foreign', 'unit_id')
        ->selectRaw('*,sum(amount) - IFNULL(sum(payments.amt_paid),0) as balance, contracts.status as contract_status')
        ->where('property_id_foreign',Session::get('property_id'))
        ->groupBy('tenant_id')
        ->orderBy('balance', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        return view('webapp.collections.delinquents', compact('delinquents'));
    }

    public function index(Request $request, $property_id)
    {
        // $existence =  Carbon::now()->year - Auth::user()->created_at->year;

        //  $days = Payment::whereBetween('payment_created', [now()->subYears( $existence),now()])
        // ->orderBy('payment_created')
        // ->get()
        // ->groupBy(function ($val) {
        //     return Carbon::parse($val->payment_created)->format('d');
        // });

        Session::put('current-page', 'daily-collection-report');

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        
        $notification->message = Auth::user()->name.' opens collections page.';
        $notification->save();
                    
        Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $search = $request->search;

        Session::put(Auth::user()->id.'date', $search);

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Apartment Rentals'){
            if($search  === null){
              $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
                ->join('tenants', 'bill_tenant_id', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('particulars','particular_id_foreign', 'particular_id')
                ->where('property_id_foreign', $property_id)
                ->groupBy('payment_id')
                ->orderBy('payment_created', 'desc')
               ->get();

               
            }else{

                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
                ->join('tenants', 'bill_tenant_id', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->join('particulars','particular_id_foreign', 'particular_id')
                ->where('property_id_foreign', $property_id)
                ->where('payment_created', $search)
                ->groupBy('payment_id')
                ->orderBy('payment_created', 'desc')
               ->get();
            
            }
        }else{
            if($search  === null){
                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_unit_id', 'unit_id_foreign')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
               
                ->groupBy('payment_id')
                ->orderBy('payment_created', 'desc')
               ->get();

            //     $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
            //     ->join('contracts', 'bill_unit_id', 'unit_id_foreign')
            //     ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            //     ->join('units', 'unit_id_foreign', 'unit_id')
            //     ->join('particulars','particular_id_foreign', 'particular_id')
            //     ->where('property_id_foreign', $property_id)
            //     ->groupBy('payment_id')
            //     ->orderBy('payment_created', 'desc')
            //    ->get();
            }else{
            
                $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
                ->join('contracts', 'bill_unit_id', 'unit_id_foreign')
                ->join('tenants', 'tenant_id_foreign', 'tenant_id')
                ->join('units', 'unit_id_foreign', 'unit_id')
                ->where('property_id_foreign', $property_id)
                ->where('payment_created', $search)
                ->groupBy('payment_id')
                ->orderBy('payment_created', 'desc')
               ->get();
            }
        }

       return view('webapp.collections.index', compact('collections'));
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

    public function action(Request $request, $property_id, $room_id, $contract_id, $tenant_id,$bill_id, $payment_id)
    {
        if($request->collection_option == 'remit'){
            return redirect('/property/'.$request->property_id.'/room/'.$room_id.'/contract/'.$contract_id.'/tenant/'.$tenant_id.'/bill/'.$bill_id.'/payment/'.$payment_id.'/remittance/create');
        }elseif($request->collection_option == 'Credit memo'){
            $payment = Payment::findOrFail($payment_id);
            $tenant = Tenant::findOrFail($tenant_id);
            return view('webapp.collections.credit-memo', compact('payment', 'tenant'));
        }elseif($request->collection_option == 'export'){

        }
    }

    public function credit_memo(Request $request, $property_id, $tenant_id, $payment_id){
        $payment_ctr = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
        ->where('property_id_foreign',Session::get('property_id'))
        ->max('ar_no') + 1;

        $payment = Payment::findOrFail($payment_id);

        DB::table('payments')->insert(
            [
                'payment_tenant_id' => $tenant_id, 
                'payment_bill_no' => $payment->payment_bill_no, 
                'payment_bill_id' => $payment->payment_bill_id,
                'amt_paid' => $request->amt_paid,
                'payment_created' => $request->payment_created,
                'ar_no' => $payment_ctr,
                'form' => 'Credit memo',
                'created_at' => NULL
            ]
       );

       return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', 'Credit memo is posted successfully!');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $tenant_id){ 

        $pending_contract = Tenant::findOrFail($tenant_id)->contracts->where('status', 'pending');

        $no_of_payments = (int) $request->no_of_payments; 

        if($no_of_payments <= 1){
                return back()->with('danger', 'Please add at least one payment.');
        }

         $payment_ctr = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
        ->where('property_id_foreign',Session::get('property_id'))
        ->max('ar_no') + 1;


        //add all the payment to the database.
        for($i = 1; $i<$no_of_payments; $i++){
             $explode = explode("-", $request->input('bill_no'.$i));
             if($particular = $request->input('form'.$i) === 'Credit memo'){
                $amount =  $request->input('amt_paid'.$i)*-1;
            }else{
               $amount =  $request->input('amt_paid'.$i);
            }
            DB::table('payments')->insert(
                [
                    'payment_tenant_id' => $tenant_id, 
                    'payment_bill_no' => $explode[0], 
                    'payment_bill_id' => $explode[1],
                    'amt_paid' => $amount,
                    'payment_created' => $request->payment_created,
                    'ar_no' => $payment_ctr,
                    'bank_name' => $request->input('bank_name'.$i),
                    'form' => $request->input('form'.$i),
                    'check_no' => $request->input('cheque_no'.$i),
                    'date_deposited' => $request->date_deposited,
                    'created_at' => Carbon::now(),
                ]
           );
           
        }

        //do the action below if the tenant status is pending.
        if($pending_contract->count() > 0){
            DB::table('contracts')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('tenant_id_foreign', $tenant_id)
            ->where('units.status', 'reserved')
            ->update(
                [
                    'units.status' => 'occupied'
                ]
            );

            DB::table('contracts')
            ->where('tenant_id_foreign', $tenant_id)
            ->where('contracts.status', 'pending')
            ->update(
                [
                    'contracts.status' => 'active'
                ]
            );
                      

          
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

            //retrieve all the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $property = Property::findOrFail(Session::get('property_id'));

             //retrieve all the unit information
            // $unit  = Unit::findOrFail($request->unit_tenant_id);

            //assign the value of tenant and unit information to variable data
            $data = array(
                // 'email' => $tenant->email_address,
                'name' => $tenant->first_name,
                'property' => Session::get('property_name'),
                'mobile' => $tenant->contact_no,
                'unit' => ' ',
                'movein_at' => ' ',
                'moveout_at' => ' ', 
            );

            // if($tenant->email_address !== null){
            //     //send welcome email to the tenant

            //     Mail::send('webapp.tenants.user-generated-mail', $data, function($message) use ($data){
            //     $message->to($data['email']);
            //     $message->bcc('customercare@thepropertymanager.online');
            //     $message->subject('Welcome Tenant');
            // });
            // }

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'tenant';
            
            $notification->message = Auth::user()->name. ' moves in '. $tenant->first_name.' '.$tenant->last_name.'.';
            $notification->save();
                        
             Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
           
        }

        $tenant = Tenant::findOrFail($tenant_id);
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        
        $notification->message = Auth::user()->name.' records '. ($no_of_payments-1) .' payment/s made by '.$tenant->first_name.' '.$tenant->last_name.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
    
        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', ($i-1).' payment is recorded successfully!');
 

            
        
        
   
    }

    public function collect_unit_payment(Request $request, $property_id, $home_id){ 

        $no_of_payments = (int) $request->no_of_payments; 

         $payment_ctr = DB::table('units')
        ->join('payments', 'unit_id', 'payment_unit_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->max('ar_no') + 1;



        //add all the payment to the database.
        for($i = 1; $i<$no_of_payments; $i++){
             $explode = explode("-", $request->input('bill_no'.$i));
             
             if($particular = $request->input('form'.$i) === 'Credit memo'){
                 $amount =  $request->input('amt_paid'.$i)*-1;
             }else{
                $amount =  $request->input('amt_paid'.$i);
             }

            DB::table('payments')->insert(
                [
                    'payment_unit_id' => $home_id, 
                    'payment_bill_no' => $explode[0], 
                    'payment_bill_id' => $explode[1],
                    'amt_paid' => $amount,
                    'payment_created' => $request->payment_created,
                    'ar_no' => $payment_ctr,
                    'bank_name' => $request->input('bank_name'.$i),
                    'form' => $request->input('form'.$i),
                    'check_no' => $request->input('cheque_no'.$i),
                    'date_deposited' => $request->date_deposited,
                    'created_at' => Carbon::now(),
                ]
           );
        }

        $unit = Unit::findOrFail($home_id);
        
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        
        $notification->message = Auth::user()->name.' records '. ($no_of_payments-1) .' payment/s made by '.$unit->unit_no.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
    
            return redirect('/property/'.$property_id.'/unit/'.$home_id.'#payments')->with('success', ($i-1).' Payment is added successfully.');
 

            
        
        
   
    }

    public function export_all($property_id, $tenant_id){
        
        $tenant = Tenant::findOrFail($tenant_id);

         $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->where('bill_tenant_id', $tenant_id)
        ->where('form','!=' ,'Credit memo')
        ->groupBy('payment_id')
        ->orderBy('payment_created', 'desc')
       ->get();

        $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance')
        ->where('bill_tenant_id', $tenant_id)
        
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        $room_id = Tenant::findOrFail($tenant_id)->contracts()->first()->unit_id_foreign;

        $current_room = Unit::findOrFail($room_id);
        
        $data = [
                    'tenant' => $tenant->first_name.' '.$tenant->last_name ,
                    'current_room' => $current_room->building.' '.$current_room->unit_no,
                    'collections' => $collections,
                    'balance' => $balance
                ];

            
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        
        $notification->message = Auth::user()->name.' exports '.$tenant->first_name.' '.$tenant->last_name.' payments.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

         $pdf = \PDF::loadView('webapp.collections.export-all', $data)
         ->setPaper('a5', 'portrait');
 
        // $pdf->setPaper('L');
         $pdf->output();
         $canvas = $pdf->getDomPDF()->getCanvas();
         $height = $canvas->get_height();
         $width = $canvas->get_width();
         $canvas->set_opacity(.1,"Multiply");
         $canvas->page_text($width/5, $height/4 , Session::get('property_name'), null,
          28, array(0,0,0),5,0,0);
         return $pdf->stream();
    }

    public function export_collection_per_day($property_id, $payment_created){

         $collections = DB::table('contracts')
        ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
        ->leftJoin('units', 'unit_id_foreign', 'unit_id')
        ->leftJoin('bills', 'tenant_id', 'bill_tenant_id')
        ->leftJoin('payments', 'payment_bill_id', 'bill_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->where('property_id_foreign', Session::get('property_id'))
        ->whereDate('payment_created', $payment_created)
        ->orderBy('payment_created', 'desc')
        ->orderBy('ar_no', 'desc')
        ->groupBy('payment_id')
        ->get();

    
        $data = [
            'collections' => $collections,
            'date' => $payment_created,
        ];

        
        $pdf = \PDF::loadView('webapp.collections.export-collections-for-today', $data)
        ->setPaper('a5', 'landscape');

       // $pdf->setPaper('L');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();
        $canvas->set_opacity(.1,"Multiply");
        $canvas->page_text($width/5, $height/2, Session::get('property_name'), null,
         28, array(0,0,0),2,2,0);
        return $pdf->stream();
    
   // $pdf = \PDF::loadView('webapp.collections.export-collections-for-today', $data)->setPaper('a5', 'portrait');
    
    return $pdf->download(Carbon::now().'-'.Auth::user()->property.'-ar'.'.pdf');
    }

    public function export_collection_per_month($property_id, $month, $year){

        $collections = DB::table('contracts')
       ->leftJoin('tenants', 'tenant_id_foreign', 'tenant_id')
       ->leftJoin('units', 'unit_id_foreign', 'unit_id')
       ->leftJoin('bills', 'tenant_id', 'bill_tenant_id')
       ->leftJoin('payments', 'payment_bill_id', 'bill_id')
       ->where('property_id_foreign', Session::get('property_id'))
       ->whereMonth('payment_created', $month)
       ->whereYear('payment_created', $year)
       ->orderBy('payment_created', 'desc')
       ->orderBy('ar_no', 'desc')
       ->groupBy('payment_id')
       ->get();

   
       $data = [
           'collections' => $collections,
           'date' => Carbon::create()->month($month)->format('M').', '.$year,
       ];
   
   $pdf = \PDF::loadView('webapp.collections.export-collections-per-month', $data)->setPaper('a5', 'portrait');
   
   return $pdf->download(Carbon::now().'-'.Auth::user()->property.'-ar'.'.pdf');
   }


   public function export_unit_bills($property_id, $unit_id, $tenant_id, $payment_id, $payment_created){

    $tenant = Tenant::findOrFail($tenant_id);

    $room = Unit::findOrFail($unit_id);

    $payment = Payment::findOrFail($payment_id);

     $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
    ->where('bill_unit_id', $unit_id)
    ->where('payment_created', $payment_created)
    ->groupBy('payment_id')
    ->orderBy('payment_created', 'desc')
    ->get();

    $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
    ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance')
    ->where('bill_unit_id', $unit_id)
    
    ->groupBy('bill_id')
    ->orderBy('bill_no', 'desc')
    ->havingRaw('balance > 0')
    ->get();

    
    $data = [
                'tenant' => $tenant->first_name.' '.$tenant->last_name ,
                'current_room' => $room->building.' '.$room->unit_no,
                'collections' => $collections,
                'balance' => $balance,
                'payment_date' => $payment->payment_created,
                'payment_ar' => $payment->ar_no
            ];

        
    $notification = new Notification();
    $notification->user_id_foreign = Auth::user()->id;
    $notification->property_id_foreign = Session::get('property_id');
    $notification->type = 'payment';
    
    $notification->message = Auth::user()->name.' exports '.$tenant->first_name.' '.$tenant->last_name.' payments.';
    $notification->save();

     Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

    $pdf = \PDF::loadView('webapp.collections.export', $data)->setPaper('a5', 'portrait');

    return $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-ar'.'.pdf');
}



    public function export($property_id, $room_id, $tenant_id, $payment_id, $payment_created){

        $tenant = Tenant::findOrFail($tenant_id);

        $room = Unit::findOrFail($room_id);

        $payment = Payment::findOrFail($payment_id);

       
        $collections = Bill::leftJoin('payments', 'bills.bill_id', 'payments.payment_bill_id')
        ->join('contracts', 'bill_tenant_id', 'tenant_id_foreign')
        
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('particulars','particular_id_foreign', 'particular_id')
        ->where('bill_tenant_id', $tenant_id)
        ->groupBy('payment_id')
        ->orderBy('payment_created', 'desc')
       ->get();

        $balance = Bill::leftJoin('payments', 'bills.bill_id', '=', 'payments.payment_bill_id')
        ->selectRaw('*, amount - IFNULL(sum(payments.amt_paid),0) as balance')
        ->where('bill_tenant_id', $tenant_id)
        
        ->groupBy('bill_id')
        ->orderBy('bill_no', 'desc')
        ->havingRaw('balance > 0')
        ->get();

        
        $data = [
                    'tenant' => $tenant->first_name.' '.$tenant->last_name ,
                    'current_room' => $room->building.' '.$room->unit_no,
                    'collections' => $collections,
                    'balance' => $balance,
                    'payment_date' => $payment->payment_created,
                    'payment_ar' => $payment->ar_no
                ];

            
        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        
        $notification->message = Auth::user()->name.' exports '.$tenant->first_name.' '.$tenant->last_name.' payments.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

         $pdf = \PDF::loadView('webapp.collections.export', $data)
         ->setPaper('a5', 'portrait');
 
        // $pdf->setPaper('L');
         $pdf->output();
         $canvas = $pdf->getDomPDF()->getCanvas();
         $height = $canvas->get_height();
         $width = $canvas->get_width();
         $canvas->set_opacity(.1,"Multiply");
         $canvas->page_text($width/5, $height/2, Session::get('property_name'), null,
          28, array(0,0,0),2,2,0);
         return $pdf->stream();

        // $pdf = \PDF::loadView('webapp.collections.export', $data)->setPaper('a5', 'portrait');
  
        // return $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-ar'.'.pdf');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($unit_id, $tenant_id, $payment_id)
    {

        if(Auth::user()->status === 'unregistered')
             return view('layouts.arsha.unregistered'); 

         else
             $payment = DB::table('units')
             ->join('tenants', 'unit_id', 'unit_tenant_id')
             ->join('payments', 'tenant_id', 'payment_tenant_id')
             ->where('payment_id', $payment_id)
             ->where('amt_paid','>',0)
            ->get();

         return view('treasury.show-payment', compact('payment'));
        
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
    public function destroy($property_id, $tenant_id, $payment_id)
    {

        $payment = Payment::findOrFail($payment_id);

        $tenant = Tenant::findOrFail($tenant_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'payment';
        
        $notification->message = Auth::user()->name.' deletes payment made by '.$tenant->first_name.' '.$tenant->last_name.'.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);

        $bill = Payment::findOrFail($payment_id);
        $bill->payment_status = 'deleted';
        $bill->save();

        if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
            return redirect('/property/'.$property_id.'/occupant/'.$tenant_id.'#payments')->with('success', ' Payment is deleted successfully.');
        }else{
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', ' Payment is deleted successfully.');
        }
    }

}
