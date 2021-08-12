<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use Uuid;
use Carbon\Carbon;
use Session;

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
    public function store(Request $request, $property_id, $owner_id)
    {
        $certificate = new Certificate();
        $certificate->certificate_id =  Uuid::generate()->string;
        $certificate->unit_id_foreign =  $request->unit_id;
        $certificate->owner_id_foreign =  $owner_id;
        $certificate->date_purchased =  $request->date_purchased;
        $certificate->date_accepted =  Carbon::now();
        $certificate->status = 'active';
        $certificate->save();

        return redirect('/property/'.Session::get('property_id').'/owner/'.$owner_id.'#certificates')->with('success',' Certificate created sucessfully!');
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
