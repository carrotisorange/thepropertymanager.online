<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Concern;
use Auth;
use Carbon\Carbon;
use App\Notification;
use Session;
use App\Property;

class ResponseController extends Controller
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
    public function store(Request $request, $concern_id)
    {

        if($request->response == null){
            return back()->with('danger', 'Content of the response cannot be empty!');
        }
        DB::table('responses')
        ->insertGetId(
              [
                  'concern_id_foreign' => $request->concern_id,
                  'response' => $request->response,
                  'posted_by' => Auth::user()->name,
                  'created_at' => Carbon::now(),
              ]
        );
    
        $responses_count = Concern::findOrFail($concern_id)->responses->count();
    
        if($responses_count > 0){
            DB::table('concerns')
            ->where('concern_id', $request->concern_id)
            ->update(
                [
                    'status' => 'active',
                    'updated_at' => Carbon::now(),
                ]
            );
    
        }

        $concern = Concern::findOrFail($concern_id);

        $notification = new Notification();
        $notification->user_id_foreign = Auth::user()->id;
        $notification->property_id_foreign = Session::get('property_id');
        $notification->type = 'concern';
        $notification->message = Auth::user()->name.' respond to a concern.';
        $notification->save();

         Session::put('notifications', Property::findOrFail(Session::get('property_id'))->unseen_notifications->where('isOpen', '0'));

    
        return back()->with('success', 'reponse has been saved!');
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
