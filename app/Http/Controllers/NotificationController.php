<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use Session;
use DB;
use Auth;

class NotificationController extends Controller
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

          $notifications =  DB::table('activities')
        ->join('users','user_id_foreign', 'id')
        ->join('properties','property_id_foreign', 'property_id')
        ->select('*', 'activities.created_at as action_made', 'activities.type as action')
        ->where('property_id_foreign', Session::get('property_id'))
        
        ->orderBy('notification_id', 'desc')
        ->get();

        //   DB::table('activities')->where('property_id_foreign', Session::get('property_id'))->update(['isOpen' => 1]);

          Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications);
        
        return view('webapp.notifications.index', compact('notifications'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
