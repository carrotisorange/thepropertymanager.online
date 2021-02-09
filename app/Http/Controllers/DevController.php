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
use App\Tenant;
use Illuminate\Support\Facades\Hash;
use App\Issue;
use App\Update;

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
        $activities =  DB::table('activities')
        ->join('users','user_id_foreign', 'id')
        ->join('properties','property_id_foreign', 'property_id')
        ->select('*', 'notifications.created_at as action_made', 'notifications.type as action')
       
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

    public function tenants()
    {
         $tenants = DB::table('tenants')->orderBy('created_at', 'desc')->get();

         $active_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('contracts.status', 'active')
        ->get();

        $inactive_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('contracts.status', 'inactive')
        ->get();

        $pending_tenants = DB::table('contracts')
        ->join('units', 'unit_id_foreign', 'unit_id')
        ->join('tenants', 'tenant_id_foreign', 'tenant_id')
        ->where('contracts.status', 'pending')
        ->get();

        

$moveout_rate_1 = DB::table('contracts')
 ->where('actual_moveout_at', '>=', Carbon::now()->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_2 = DB::table('contracts')
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonth()->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonth()->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_3 = DB::table('contracts')
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(2)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_4 = DB::table('contracts')
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(3)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate_5 = DB::table('contracts')
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(4)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

 $moveout_rate_6 = DB::table('contracts')
 ->where('actual_moveout_at', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
->where('actual_moveout_at', '<=', Carbon::now()->subMonths(5)->endOfMonth())
 ->where('contracts.status', 'inactive')
 ->count();

$moveout_rate = new DashboardChart;
$moveout_rate->displaylegend(false);
$moveout_rate->labels([Carbon::now()->subMonth(5)->format('M Y'),Carbon::now()->subMonth(4)->format('M Y'),Carbon::now()->subMonth(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
$moveout_rate->dataset('Moveouts', 'bar', [
                                                $moveout_rate_6,
                                                $moveout_rate_5,
                                                $moveout_rate_4,
                                                $moveout_rate_3,
                                                $moveout_rate_2,
                                                $moveout_rate_1,
                                           
                                              ]
                )
->color("#858796")
->backgroundcolor("rgba(78, 115, 223, 0.05)")
->fill(false)
->linetension(0.3);

$end_of_contract = DB::table('contracts')
->where('moveout_reason','End of contract')
->get();

$delinquent = DB::table('contracts')
->where('moveout_reason','Delinquent')
->get();

$force_majeure = DB::table('contracts')
->where('moveout_reason','Force majeure')
->get();

$run_away = DB::table('contracts')
->where('moveout_reason','Run away')
->get();

$unruly = DB::table('contracts')
->where('moveout_reason','Unruly')
->get();

$graduated = DB::table('contracts')
->where('moveout_reason','Graduated')
->get();

$reason_for_moving_out_chart = new DashboardChart;
$reason_for_moving_out_chart->displaylegend(true);
$reason_for_moving_out_chart->labels(
                                        [ 'End Of Contract'.' ('.$end_of_contract->count(). ')',
                                          'Graduated'.' ('.$graduated->count(). ')', 
                                          'Delinquent'.' ('.$delinquent->count(). ')', 
                                          'Force Majeure'.' ('.$force_majeure->count(). ')', 
                                          'Run Away'.' ('.$run_away->count(). ')', 
                                          'Unruly'.' ('.$unruly->count(). ')',
                                          'Total'.' ('.$inactive_tenants->count(). ')'
                                          ]
                                    );
$reason_for_moving_out_chart->dataset('', 'pie', 
                                        [
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $end_of_contract->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $graduated->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $delinquent->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $force_majeure->count()/$inactive_tenants->count()) * 100,1),
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $run_away->count()/$inactive_tenants->count()) * 100,1), 
                                            number_format(($inactive_tenants->count() == 0 ? 0 : $unruly->count()/$inactive_tenants->count()) * 100,1),
                                        ]
                                    )
->backgroundColor(
                    [
                        '#008000',
                        '#FFF000', 
                        '#FF0000',
                        '#0E0601',
                        '#DE7835',
                        '#211979'
                    ]
                );

$contracts = DB::table('contracts')
->count();

                
 $facebook = DB::table('contracts')
 ->where('form_of_interaction','Facebook')
 ->count();
 
 $flyers = DB::table('contracts')
 ->where('form_of_interaction','Flyers')
 ->count();
 
 $inhouse = DB::table('contracts')
 ->where('form_of_interaction','In house')
 ->count();
 
 $instagram = DB::table('contracts')
 ->where('form_of_interaction','Instagram')
 ->count();
 
 $website = DB::table('contracts')
 ->where('form_of_interaction','Website')
 ->count();
 
 $walkin = DB::table('contracts')
 ->where('form_of_interaction','Walk in')
 ->count();
 
 $wordofmouth = DB::table('contracts')
 ->where('form_of_interaction','Word of mouth')
 ->count();
 
 $point_of_contact = new DashboardChart;
 $point_of_contact->displaylegend(true);
 $point_of_contact->labels
                             (
                                 [ 
                                     'Facebook'.' ('.$facebook.')',
                                     'Flyers'.' ('.$flyers.')', 
                                     'In house'.' ('.$inhouse.')', 
                                     'Instagram'.' ('.$instagram.')', 
                                     'Website'.' ('.$website.')',
                                     'Walk in'.' ('.$walkin.')', 
                                     'Word of mouth'.' ('.$wordofmouth.')',
                                     'Total'.' ('.$contracts. ')'
                                 ]
                             );
 $point_of_contact->dataset
                             ('', 'pie',
                                 [   
                                     number_format(($contracts == 0 ? 1 : $facebook/$contracts) * 100,1),
                                     number_format(($contracts == 0 ? 1 : $flyers/$contracts) * 100,1),
                                     number_format(($contracts == 0 ? 1 : $inhouse/$contracts) * 100,1),
                                     number_format(($contracts == 0 ? 1 : $instagram/$contracts) * 100,1),
                                     number_format(($contracts== 0 ? 1 : $website/$contracts) * 100,1), 
                                     number_format(($contracts== 0 ? 1 : $walkin/$contracts) * 100,1), 
                                     number_format(($contracts == 0 ? 1 : $wordofmouth/$contracts) * 100,1),
                                 
                                 ]
                             )
 ->backgroundColor
                     (
                         [
                             '#3b5998',
                             '#211939', 
                             '#008000',
                             '#C13584',
                             '#DE7835',
                             '#211979',
                             '#FF0000',
                         ]
                     );
           

                 
 $working = Tenant::where('type_of_tenant', 'working')->count();

 $studying = Tenant::where('type_of_tenant', 'studying')->count();
 
 $status = new DashboardChart;
 $status->displaylegend(true);
 $status->labels
                             (
                                 [ 
                                     'Working'.' ('.$working.')',
                                     'Studying'.' ('.$studying.')', 
                                     'Total'.' ('.$tenants->count(). ')'
                                 ]
                             );
 $status->dataset
                             ('', 'pie',
                                 [   
                                     number_format(( $working/$tenants->count()) * 100,1),
                                     number_format(( $studying/$tenants->count()) * 100,1),                                 
                                 ]
                             )
 ->backgroundColor
                     (
                         [
                             '#008000',
                             '#211939', 
                         ]
                     );

                     $occupancy_rate_6 = DB::table('occupancy_rate')
            
                     ->where('occupancy_date', '>=', Carbon::now()->firstOfMonth())
                     ->where('occupancy_date', '<=', Carbon::now()->endOfMonth())
                     ->max('occupancy_rate');

                     $occupancy_rate_5 = DB::table('occupancy_rate')
                  
                     ->where('occupancy_date', '>=', Carbon::now()->subMonth()->firstOfMonth())
                     ->where('occupancy_date', '<=', Carbon::now()->subMonth()->endOfMonth())
                     ->max('occupancy_rate');
                     
                      $occupancy_rate_4 = DB::table('occupancy_rate')
              
                     ->where('occupancy_date', '>=', Carbon::now()->subMonths(2)->firstOfMonth())
                     ->where('occupancy_date', '<=', Carbon::now()->subMonths(2)->endOfMonth())
                     ->max('occupancy_rate');
                     
                      $occupancy_rate_3 = DB::table('occupancy_rate')
                     
                     ->where('occupancy_date', '>=', Carbon::now()->subMonths(3)->firstOfMonth())
                     ->where('occupancy_date', '<=', Carbon::now()->subMonths(3)->endOfMonth())
                     ->max('occupancy_rate');
                     
                       $occupancy_rate_2 = DB::table('occupancy_rate')
                    
                     ->where('occupancy_date', '>=', Carbon::now()->subMonths(4)->firstOfMonth())
                     ->where('occupancy_date', '<=', Carbon::now()->subMonths(4)->endOfMonth())
                     ->max('occupancy_rate');
                     
                     $occupancy_rate_1 = DB::table('occupancy_rate')
                 
                     ->where('occupancy_date', '>=', Carbon::now()->subMonths(5)->firstOfMonth())
                     ->where('occupancy_date', '<=', Carbon::now()->subMonths(5)->endOfMonth())
                     ->max('occupancy_rate');
                     
                     $movein_rate = new DashboardChart;
                     $movein_rate->barwidth(0.0);
                     $movein_rate->displaylegend(false);
                     $movein_rate->labels([Carbon::now()->subMonths(5)->format('M Y'),Carbon::now()->subMonths(4)->format('M Y'),Carbon::now()->subMonths(3)->format('M Y'),Carbon::now()->subMonths(2)->format('M Y'),Carbon::now()->subMonth()->format('M Y'),Carbon::now()->format('M Y')]);
                     $movein_rate->dataset('Occupancy Rate: ', 'line',
                                                             [ 
                                                                 $occupancy_rate_1,
                                                                 $occupancy_rate_2,
                                                                 $occupancy_rate_3,
                                                                 $occupancy_rate_4,
                                                                 $occupancy_rate_5,
                                                                 $occupancy_rate_6,
                                                             ]
                     
                                             )
                         ->color("#858796")
                         ->backgroundcolor("rgba(78, 115, 223, 0.05)")
                         ->fill(false)
                         ->linetension(0.3);
                     
                     
           


        return view('layouts.dev.tenants', compact('tenants', 'active_tenants', 'inactive_tenants', 'pending_tenants', 'moveout_rate', 'reason_for_moving_out_chart', 'point_of_contact', 'status', 'movein_rate'));
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

        return back()->with('success', 'Added successfully.');
    }

    public function post_user(Request $request, $user_id)
    { 
        if($request->email_verified_at == null){
            $email_verified_at  = null;
        }else{
            $email_verified_at  = $request->email_verified_at;
        }

        if($request->password == null){
            $password  =  User::findOrFail($user_id)->password;
        }else{
            $password  = Hash::make($request->password);
        }

         $user = User::findOrFail($user_id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->user_type = $request->user_type;
         $user->account_type = $request->account_type;
         $user->password = $password;
         $user->email_verified_at = $email_verified_at;
         $user->save();

        return redirect('/dev/users')->with('success','Changes saved.');
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
        $updates = Update::orderBy('created_at', 'desc')->get();

        return view('layouts.dev.updates', compact('updates'));
    }

    public function issues()
    {
          $issues = DB::table('issues')
        ->join('users', 'user_id_foreign', 'id')
        ->leftJoin('issue_responses', 'issues.issue_id', 'issue_responses.issue_id')
        ->select('*', 'issues.status as issue_status', DB::raw('count(issue_responses.id) as responses'))
        ->groupBy('issues.issue_id')
        ->orderBy('issues.created_at', 'desc')
        ->get();

        return view('layouts.dev.issues', compact('issues'));
    }

    public function edit_issue($issue_id)
    {

        $issue = Issue::findOrFail($issue_id);

        $responses = DB::table('issue_responses')
        ->join('issues', 'issues.issue_id', 'issue_responses.issue_id')
        ->join('users', 'issue_responses.user_id', 'users.id')
        ->select('*', 'issue_responses.created_at as responded_at')
        ->where('issue_responses.issue_id', $issue_id)
        ->orderBy('issue_responses.created_at', 'desc') 
        ->get();

        return view('layouts.dev.edit_issue', compact('issue', 'responses'));
    }

    public function add_response(Request $request, $issue_id)
    {   

        $request->validate([
            'response' => ['required'],
        ]);

        DB::table('issue_responses')->insert(
            [
               'issue_id' => $issue_id, 
               'user_id' => Auth::user()->id,
               'response' => $request->response,
               'created_at' => Carbon::now(),
            ]
        );


        return back()->with('success', 'Response is successfully sent!');
    }

    
    public function update_issue(Request $request, $issue_id)
    {   
        $issue = Issue::findOrFail($issue_id);
        $issue->status = $request->status;
        $issue->details = $request->details;
        $issue->save();

        return redirect('/dev/issues')->with('success', 'Changes saved.');
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
