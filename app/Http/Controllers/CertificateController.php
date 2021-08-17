<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use Uuid;
use Carbon\Carbon;
use Session;
use App\Owner;
use App\Unit;

class CertificateController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']);
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $owner_id)
    {
        $owner = Owner::findOrFail($owner_id);

        $all_rooms = Unit::where('property_id_foreign', Session::get('property_id'))
        ->orderBy('building', 'asc')
        ->orderBy('unit_no', 'asc')
        ->get();
        
        return view('webapp.certificates.create', compact('owner', 'all_rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $property_id, $owner_id)
    {

        return $request->all();
        

        $this->validate($request, [
            'date_purchased' => 'required',
            'unit_id_foreign' => 'required',
            'payment_type' =>  'required',
            'price' => 'required',
        ]);

        Certificate::create([
            'date_purchased' => $request->date_purchased,
            'unit_id_foreign' => $request->unit_id_foreign,
            'owner_id_foreign' => $owner_id,
            'certificate_id' => Uuid::generate()->string,
            'payment_type' => $request->payment_type,
            'price' => $request->price,
            'status' => 'active',
        ]);

        return redirect('/property/'.Session::get('property_id').'/owner/'.$owner_id.'/#certificates')->with('success', 'Certificates is added succesfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        //
    }
}
