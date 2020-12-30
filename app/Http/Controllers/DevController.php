<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Notification;
use App\Property;
use App\User;
use Carbon\Carbon;
use App\Charts\DashboardChart;
use Auth;

class DevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function activities()
    {
        $activities =  DB::table('notifications')
        ->join('users','user_id_foreign', 'id')
        ->select('*', 'notifications.created_at as action_made')
       
        ->orderBy('notification_id', 'desc')
        ->get();

        Session::put('notifications', Notification::orderBy('notification_id', 'desc')->limit(5)->get());

        return view('layouts.dev.activities', compact('activities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function properties()
    {
         $properties = Property::all();

        return view('layouts.dev.properties', compact('properties'));
    }

    public function users()
    {
        
        $users = DB::table('users')
        ->orderBy('email_verified_at', 'desc')
        ->where('user_type','<>', 'tenant')
        ->paginate(10);

        return view('layouts.dev.users', compact( 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function starter()
    {
        return view('layouts.dev.starter');
    }

    public function updates()
    {
        return view('layouts.dev.updates');
    }

    public function issues()
    {
        return view('layouts.dev.issues');
    }

    public function announcements()
    {
        return view('layouts.dev.announcements');
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
