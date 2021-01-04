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
use App\Plan;

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

    public function edit_user($user_id)
    {
         $user = User::findOrFail($user_id);

        return view('layouts.dev.edit_user', compact('user'));
    }

    public function user_plans($user_id)
    {
         $user = User::findOrFail($user_id);

        return view('layouts.dev.user_plans', compact('user'));
    }

    public function plans()
    {
         $plans = Plan::all();

        return view('layouts.dev.plans', compact('plans'));
    }

    public function post_plan(Request $request)
    {
         $plan = new Plan();
         $plan->plan = $request->plan;
         $plan->price_per_month = $request->price_per_month;
         $plan->price_per_year = $request->price_per_year;
         $plan->room_limit = $request->room_limit;
         $plan->user_limit = $request->user_limit;
         $plan->property_limit = $request->property_limit;
         $plan->trial_expired_at = $request->trial_expired_at;
         $plan->save();

        return back()->with('success', 'Added succesfully!');
    }

    public function post_user(Request $request, $user_id)
    {
        if($request->email_verified_at == null){
            $email_verified_at  = null;
        }else{
            $email_verified_at  = $request->email_verified_at;
        }

         $user = User::findOrFail($user_id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->user_type = $request->user_type;
         $user->account_type = $request->account_type;
         $user->email_verified_at = $email_verified_at;
         $user->save();

        return redirect('/dev/users')->with('success','Changes have been saved!');
    }


    public function users()
    {
        
        $users = DB::table('users')
      
        ->where('user_type','<>', 'tenant')
        ->orderBy('created_at', 'desc')
        ->get();

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
