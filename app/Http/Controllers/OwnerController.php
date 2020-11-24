<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\UnitOwner, App\Unit, App\Billing;
use Illuminate\Support\Facades\Auth;
use App\Property;
use App\Certificate;
use Uuid;
use Carbon\Carbon;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
             $owners = DB::table('certificates')
            ->join('unit_owners', 'owner_id_foreign', 'unit_owner_id')
            ->join('units', 'certificates.unit_id_foreign', 'unit_id')
            ->where('property_id_foreign', $property_id)
            ->get();

            $count_owners = DB::table('certificates')
            ->join('unit_owners', 'owner_id_foreign', 'unit_owner_id')
            ->join('units', 'certificates.unit_id_foreign', 'unit_id')
            ->where('property_id_foreign', $property_id)
            ->count();
    

        $property = Property::findOrFail($property_id);
        
        return view('webapp.owners.owners', compact('owners','count_owners','property'));
    }

    
    public function search(Request $request,$property_id){   
        
        $search = $request->get('search');

        //create session for the search
        $request->session()->put(Auth::user()->id.'search_owner', $search);

      
        $owners = DB::table('certificates')
        ->join('unit_owners', 'owner_id_foreign', 'unit_owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("unit_owner like '%$search%' ")
        ->get();

        $count_owners = DB::table('certificates')
        ->join('unit_owners', 'owner_id_foreign', 'unit_owner_id')
        ->join('units', 'certificates.unit_id_foreign', 'unit_id')
        ->where('property_id_foreign', $property_id)
        ->whereRaw("unit_owner like '%$search%' ")
        ->count();

         $property = Property::findOrFail($property_id);

        return view('webapp.owners.owners', compact('owners', 'count_owners', 'property'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $unit_id)
    {

         $owner_id = DB::table('unit_owners')
        ->insertGetId
        (
            [
                'unit_owner' => $request->name,
                'investor_email_address' => $request->email,
                'investor_contact_no' => $request->mobile,
            ]
            );

        $certificate = new Certificate();
        $certificate->certificate_id = Uuid::generate()->string;
        $certificate->status = 'active';
        $certificate->unit_id_foreign = $unit_id;
        $certificate->owner_id_foreign = $owner_id;
        $certificate->save();

        return redirect('/property/'.$property_id.'/owner/'.$owner_id.'/edit')->with('success', 'new owner has been added! Please complete the fields below...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id,$owner_id)
    {
        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){

            $owner = UnitOwner::findOrFail($owner_id);

            $investor_billings = DB::table('units')
           ->join('unit_owners', 'unit_id', 'unit_unit_owner_id')
           ->join('billings', 'unit_owner_id', 'billing_tenant_id')
           ->get();

           $rooms = DB::table('certificates')
           ->join('units', 'certificates.unit_id_foreign', 'unit_id')
           ->where('owner_id_foreign', $owner_id)
           ->get();
  
        //    $bills = Billing::leftJoin('payments', 'billings.billing_no', '=', 'payments.payment_billing_no')
        //    ->join('tenants', 'billing_tenant_id', 'tenant_id')
           
        // //    ->selectRaw('*, billings.billing_amt - IFNULL(sum(payments.amt_paid),0) as balance')
        // //    ->where('unit_tenant_id', $unit_id)
        // //    ->groupBy('billing_id')
        // //    ->orderBy('billing_no', 'desc')
        // //    ->havingRaw('balance > 0')
        // //    ->get();
    
        $property = Property::findOrFail($property_id);
   
            return view('webapp.owners.show-investor', compact('owner','rooms','property'));
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
    public function edit($property_id,$owner_id)
    {
        $owner = UnitOwner::findOrFail($owner_id);

        $property = Property::findOrFail($property_id);
        
        return view('webapp.owners.edit-investor', compact('owner', 'property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $owner_id)
    {

        DB::table('unit_owners')
        ->where('unit_owner_id',$owner_id )
        ->update([
            'unit_owner' => $request->unit_owner,
            'investor_contact_no' => $request->investor_contact_no,
            'investor_email_address' => $request->investor_email_address,
            'investor_address' => $request->investor_address,
            'investor_representative' => $request->investor_representative,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        DB::table('certificates')
        ->where('owner_id_foreign', $owner_id)
        ->update([
            'date_purchased' => $request->date_purchased,
            'price' => $request->price,
            'payment_type' => $request->payment_type, 
            'updated_at' => Carbon::now()
        ]);

        return redirect('/property/'.$property_id.'/owner/'.$owner_id)->with('success', 'changes have been saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('unit_owners')->where('unit_owner_id', $id)->delete();

        return back();
    }
}
