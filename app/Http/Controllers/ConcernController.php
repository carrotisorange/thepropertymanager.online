<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, App\Tenant, App\Unit, App\Concern, Auth, Carbon\Carbon;
use App\Property;
use App\Response;

class ConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($property_id)
    {
         $concerns = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->where('property_id_foreign', $property_id)
            ->orderBy('date_reported', 'desc')
            ->orderBy('concern_urgency', 'desc')
            ->orderBy('concern_status', 'desc')
            ->get();

        $property = Property::findOrFail($property_id);

        return view('webapp.concerns.concerns', compact('concerns', 'property'));
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
    public function store_room_concern(Request $request, $property_id, $unit_id)
    {
        $concern = new Concern();
        $concern->date_reported = $request->date_reported;
        $concern->concern_tenant_id = $request->reported_by;
        $concern->concern_type = $request->concern_type;

        $concern->concern_status = 'pending';
        $concern->concern_urgency = $request->concern_urgency;
        $concern->concern_item = $request->concern_item;
        $concern->concern_desc = $request->concern_desc;
        $concern->concern_user_id = $request->concern_user_id;
        $concern->save();

        return redirect('/property/'.$property_id.'/home/'.$unit_id.'#concerns')->with('success', 'concern has been saved!');

    }
  
    public function store(Request $request, $property_id, $tenant_id)
    {
       $concern_id = DB::table('concerns')->insertGetId(
            [
                'concern_tenant_id' => $tenant_id,
                'date_reported' => $request->date_reported,
                'concern_type'=> $request->concern_type,
                'concern_urgency' => $request->concern_urgency,
                'concern_item' => $request->concern_item,
                'concern_desc' => $request->concern_desc,
                'concern_status' => 'pending',
                'concern_user_id' => $request->concern_user_id,
            ]);

            return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#concerns')->with('success', 'concern has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $concern_id)
    {
        
        if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'treasury' || auth()->user()->user_type === 'billing'){
        
            // $tenant = Tenant::findOrFail($tenant_id);

            // $unit = Unit::findOrFail($unit_id);

            $concern = Concern::findOrFail($concern_id);

            
            $concern_details = DB::table('contracts')
            ->join('tenants', 'tenant_id_foreign', 'tenant_id')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->join('concerns', 'tenant_id', 'concern_tenant_id')
            ->join('users', 'concern_user_id', 'id')
            ->where('concern_id', $concern_id)
            ->orderBy('date_reported', 'desc')
            ->orderBy('concern_urgency', 'desc')
            ->orderBy('concern_status', 'desc')
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
      
       return view('webapp.concerns.show', compact('concern', 'responses', 'property','concern_details', 'personnels'));
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
            'date_reported' => $request->date_reported,
            'concern_item' => $request->concern_item,
            'concern_type' => $request->concern_type,
            'concern_desc' => $request->concern_desc,
            'concern_urgency' => $request->concern_urgency
        ]);

        return back()->with('success', 'changes have been saved!');
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
