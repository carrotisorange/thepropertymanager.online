<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;
use App\Charts\DashboardChart;
use App\Unit, App\Owner, App\Tenant, App\User, App\Payment, App\Billing;
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
    public function index(Request $request, $property_id)
    {
        $search = $request->search;

        Session::put(Auth::user()->id.'date', $search);

        if($search  === null){

            $collections = Billing::leftJoin('payments', 'billings.billing_id', 'payments.payment_billing_id')
            ->join('contracts', 'billing_tenant_id', 'tenant_id_foreign')
            ->join('tenants', 'billing_tenant_id', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('property_id_foreign', $property_id)
            ->groupBy('payment_id')
            ->orderBy('ar_no', 'desc')
           ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            });

            //  $collections = DB::table('contracts')
            // ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            // ->join('units', 'unit_id_foreign', 'unit_id')
            // ->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
            // ->join('billings', 'tenant_id_foreign', 'billing_tenant_id')
            // ->where('property_id_foreign', $property_id)
            // ->orderBy('payment_created', 'desc')
            // ->orderBy('ar_no', 'desc')
            // ->groupBy('payment_id')
            // ->get()
            // ->groupBy(function($item) {
            //     return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            // });
            // $collections = DB::table('units')
            // ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
            // ->leftJoin('payments', 'tenant_id', 'payment_tenant_id')
            // ->leftJoin('billings', 'payment_billing_no', 'billing_no')
            // ->where('property_id_foreign', $property_id)
            // ->orderBy('payment_created', 'desc')
            // ->orderBy('ar_no', 'desc')
            // ->groupBy('payment_id')
            // ->get()
            // ->groupBy(function($item) {
            //     return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            // });
        }else{
        
            $collections = Billing::leftJoin('payments', 'billings.billing_id', 'payments.payment_billing_id')
            ->join('contracts', 'billing_tenant_id', 'tenant_id_foreign')
            ->join('tenants', 'billing_tenant_id', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('property_id_foreign', $property_id)
            ->where('payment_created', $search)
            ->groupBy('payment_id')
            ->orderBy('ar_no', 'desc')
           ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            });

       
        }

        $property = Property::findOrFail($property_id);

       return view('webapp.collections.collections', compact('collections', 'property'));
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
    public function store(Request $request, $property_id, $tenant_id){ 

        $pending_contract = Tenant::findOrFail($tenant_id)->contracts->where('status', 'pending');

        $no_of_payments = (int) $request->no_of_payments; 

         $payment_ctr = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('payments', 'tenant_id_foreign', 'payment_tenant_id')
        ->where('property_id_foreign',Session::get('property_id'))
        ->max('ar_no') + 1;


        //add all the payment to the database.
        for($i = 1; $i<$no_of_payments; $i++){
             $explode = explode("-", $request->input('billing_no'.$i));
            DB::table('payments')->insert(
                [
                    'payment_tenant_id' => $tenant_id, 
                    'payment_billing_no' => $explode[0], 
                    'payment_billing_id' => $explode[1],
                    'amt_paid' => $request->input('amt_paid'.$i),
                    'payment_created' => $request->payment_created,
                    'ar_no' => $payment_ctr,
                    'bank_name' => $request->input('bank_name'.$i),
                    'form_of_payment' => $request->input('form_of_payment'.$i),
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

        if($new_occupancy_rate/$current_occupancy_rate !== 1){
            $occupancy = new OccupancyRate();
            $occupancy->occupancy_rate = $new_occupancy_rate;
            $occupancy->occupancy_date = Carbon::now();
            $occupancy->property_id_foreign =  Session::get('property_id');
            $occupancy->save();

        }

            //retrieve all the tenant information
            $tenant = Tenant::findOrFail($tenant_id);

            $property = Property::findOrFail(Session::get('property_id'));

            // //retrieve all the unit information
            // $unit  = Unit::findOrFail($request->unit_tenant_id);

            //assign the value of tenant and unit information to variable data
            $data = array(
                'email' => $tenant->email_address,
                'name' => $tenant->first_name,
                'property' => $property->name,
                'mobile' => $tenant->contact_no,
                // 'movein'  => $pending_contract->movein_at,
                // 'moveout'  => $pending_contract->moveout_at,
                // 'monthly_rent'=> $pending_contract->rent
            );

            if($tenant->email_address !== null){
                //send welcome email to the tenant

                Mail::send('webapp.tenants.user-generated-mail', $data, function($message) use ($data){
                $message->to($data['email']);
                $message->bcc(['landleybernardo@thepropertymanager.online','customercare@thepropertymanager.online']);
                $message->subject('Welcome Tenant');
            });
            }

            $notification = new Notification();
            $notification->user_id_foreign = Auth::user()->id;
            $notification->property_id_foreign = Session::get('property_id');
            $notification->type = 'success';
            $notification->message = $tenant->first_name.' '.$tenant->last_name.' has been marked as active!';
            $notification->save();
                        
            Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
           
        }
            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', ($i-1).' payments have been recorded!');
        
        
   
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
             return view('website.unregistered'); 

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
        DB::table('payments')->where('payment_id', $payment_id)->delete();

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#payments')->with('success', ' payment has been deleted!');
    }

}
