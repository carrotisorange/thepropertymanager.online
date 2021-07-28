<?php

namespace App\Http\Controllers;

use App\Violation;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Tenant;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('current-page', 'violations');

        $violations = DB::table('contracts')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('violations', 'tenants.tenant_id', 'violations.tenant_id_foreign')
        ->join('violation_types','violation_type_id', 'violation_type_id_foreign')
        ->where('property_id_foreign', Session::get('property_id'))
        ->orderBy('violations.created_at', 'desc')
       
        ->get();

        return view('webapp.violations.index', compact('violations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $tenant_id)
    {
        Session::put('current-page', 'violations');

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
        
        return view('webapp.violations.create', compact('tenant', 'contracts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $tenant_id)
    {
        //return $request->all();

        $violation = new Violation();
        $violation->tenant_id_foreign = $request->tenant_id;
        $violation->status = $request->status;
        $violation->frequency = $request->frequency;
        $violation->severity = $request->severity;
        $violation->summary = $request->summary;
        $violation->created_at = $request->created_at;
        $violation->save();

        return redirect('/property/'.$property_id.'/tenant/'.$tenant_id.'#violations')->with('success', 'Violation is added sucessfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function show(Violation $violation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function edit(Violation $violation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Violation $violation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Violation $violation)
    {
        //
    }
}
