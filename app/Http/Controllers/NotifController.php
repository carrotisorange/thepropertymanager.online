<?php

namespace App\Http\Controllers;

use App\Notif;
use Illuminate\Http\Request;
use Session;
use DB;

class NotifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('current-page', 'audit-trails');

         $notifs = DB::table('notifs')
        ->join('users', 'user_id_foreign', 'id')
        ->join('properties', 'property_id_foreign', 'property_id')
        ->select('*', 'notifs.type as action_type', 'users.name as user_name', 'notifs.created_at as triggered_at')
        ->where('property_id_foreign', Session::get('property_id'))
        ->whereNull('deleted_at')
        ->orderBy('notifs.created_at', 'desc')
        ->paginate(5);

        return view('webapp.notifs.index', compact('notifs'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notif  $notif
     * @return \Illuminate\Http\Response
     */
    public function show(Notif $notif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notif  $notif
     * @return \Illuminate\Http\Response
     */
    public function edit(Notif $notif)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notif  $notif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notif $notif)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notif  $notif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notif $notif)
    {
        //
    }
}
