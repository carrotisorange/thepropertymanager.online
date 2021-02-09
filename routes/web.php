<?php

use App\Unit, App\Owner, App\Tenant, App\User, App\Bill, App\Property;
use Carbon\Carbon;
use App\Charts\DashboardChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantRegisteredMail;
use App\Mail\SendContractAlertEmail;
use App\Concern;
use App\Session;
use App\Certificate;
use App\Guardian;
use Illuminate\Support\Facades\Hash;
use App\Room;
use App\Update;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify'=> true]);

Route::get('/blogs', 'BlogController@index');

Route::post('ckeditor/image_upload', 'BlogController@upload')->name('upload');

Route::get('property/{property_id}/system-updates', function($property_id){

    $updates = Update::orderBy('created_at', 'desc')->get();

    $property = Property::findOrFail($property_id);

    return view('webapp.properties.system-updates',compact('property','updates'));
});

Route::get('property/{property_id}/getting-started', function($property_id){
    $property = Property::findOrFail($property_id);

    return view('webapp.properties.getting-started',compact('property'));
});


Route::get('property/{property_id}/announcements', function($property_id){
    $property = Property::findOrFail($property_id);

    return view('webapp.properties.announcements',compact('property'));
});


//route for issues
Route::get('/property/{property_id}/issues', 'IssueController@index');
Route::get('/property/{property_id}/issue/{issue_id}', 'IssueController@show');
Route::post('/property/{property_id}/issue/create', 'IssueController@store');


//routes for blogs
Route::get('/property/{property_id}/blogs', 'BlogController@index');
Route::post('/property/{property_id}/blog', 'BlogController@store')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/blog/{blog_id}', 'BlogController@show')->middleware(['auth', 'verified']);

//routes for system-users
Route::get('/user/all', 'UserController@index_system_user')->middleware(['auth', 'verified']);
Route::get('/user/create', 'UserController@create_system_user')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}', 'UserController@show_system_user')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/edit', 'UserController@edit_system_user')->middleware(['auth', 'verified']);
Route::put('/user/{user_id}', 'UserController@update_system_user')->middleware(['auth', 'verified']);
Route::post('/user/store', 'UserController@store_system_user')->middleware(['auth', 'verified']);

//routes for properties 
Route::get('/property/all', 'PropertyController@index')->middleware(['auth', 'verified']);
Route::get('/property/create', 'PropertyController@create')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}', 'PropertyController@show')->middleware(['auth', 'verified']);
Route::post('/property/', 'PropertyController@store')->middleware(['auth', 'verified']);
Route::post('/property/select', 'PropertyController@select')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/search', 'PropertyController@search')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/edit', 'PropertyController@edit')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/', 'PropertyController@update')->middleware(['auth', 'verified']);


//routes for dashboard
Route::get('/property/{property_id}/dashboard', 'PropertyController@show')->middleware(['auth', 'verified']);

//routes for occupants
Route::get('/property/{property_id}/occupants', 'OccupantController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/occupant/{tenant_id}', 'OccupantController@show')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/occupant/{tenant_id}/edit', 'OccupantController@edit')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/occupant/{tenant_id}', 'OccupantController@update')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/unit/{unit_id}/occupant', 'OccupantController@create')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/unit/{unit_id}/occupant', 'OccupantController@store')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/unit/{unit_id}/occupant/prefilled', 'OccupantController@create_prefilled')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/unit/{unit_id}/occupant/prefilled', 'OccupantController@store_prefilled')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/occupants/search', 'OccupantController@index')->middleware(['auth', 'verified']);

//routes for tenants
Route::get('/property/{property_id}/tenants', 'TenantController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}', 'TenantController@show')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/edit', 'TenantController@edit')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/tenant/{tenant_id}', 'TenantController@update')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/room/{unit_id}/tenant', 'TenantController@create')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/room/{unit_id}/tenant', 'TenantController@store')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenants/search', 'TenantController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend_post')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/request', 'TenantController@request')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/approve', 'TenantController@approve')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/tenant/{tenant_id}/upload/img','TenantController@upload_img')->middleware(['auth', 'verified']);

//routes for contracts
Route::post('/property/{property_id}/tenant/{tenant_id}/contract/create', 'ContractController@create')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/contract/add', 'ContractController@store')->middleware(['auth', 'verified']);

//upload img
//post F image


Route::post('/property/{property_id}/tenant/{tenant_id}/guardian', 'GuardianController@store')->middleware(['auth', 'verified']);

Route::post('property/{property_id}/tenant/{tenant_id}/user/create', 'TenantController@create_user_access')->middleware(['auth', 'verified']);

Route::post('property/{property_id}/owner/{owner_id}/user/create', 'OwnerController@create_user_access')->middleware(['auth', 'verified']);

//routes for owners
Route::get('/property/{property_id}/owners', 'OwnerController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/owners/search', 'OwnerController@search')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/owner/{owner_id}/edit', 'OwnerController@edit')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/owner/{owner_id}', 'OwnerController@show')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/owner/{owner_id}', 'OwnerController@update')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/room/{unit_id}/owner', 'OwnerController@store')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/owner/{owner_id}/upload/img','OwnerController@upload_img')->middleware(['auth', 'verified']);

Route::delete('/property/{property_id}/owner/{owner_id}/delete', 'OwnerController@destroy')->middleware(['auth', 'verified']);


Route::post('/property/{property_id}/owner/{owner_id}/certificate/store', 'CertificateController@store')->middleware(['auth', 'verified']);

Route::get('/asa', function(){

    // $rooms = Property::findOrFail('4b3cc400-181c-11eb-b718-f9aa30fde187')->units;

    // for ($i=1; $i <=$rooms->count(); $i++) { 
    //     if (Unit::where('property_id_foreign', '4b3cc400-181c-11eb-b718-f9aa30fde187')->exists()) {

    //     }
    //     $room = new Room();
    //  }

 

    //  $user = DB::table('tenants')
    //  ->leftJoin('users', 'user_id_foreign', 'id')
    //  ->where('tenant_id', $tenant_id)
    //  ->get('user_id_foreign');

    //   $user_id_foreign = Tenant::findOrFail($tenant_id);

    //  if($user == null){
        
    //     $user_id = DB::table('users')
    //     ->insertGetId([
    //         'name' => $user_id_foreign->first_name.' '.$user_id_foreign->last_name,
    //         'email' => $user_id_foreign->tenant_unique_id.'@thepropertymanager.online',
    //         'password' => Hash::make('12345678'),
    //         'user_type' => 'tenant',
    //         'email_verified_at' => Carbon::now()
            
    //     ]);

    //     DB::table('tenants')
    //     ->where('tenant_id', $tenant_id)
        
    //     ->update(
    //         [
    //             'user_id_foreign' => $user_id,
    //         ]
    //         );

    //         DB::table('users_properties_relations')
    //         ->insert
    //                 (
    //                     [
    //                         'user_id_foreign' => $user_id,
    //                         'property_id_foreign' => $property_id,
    //                     ]
    //                 ); 


    //  }else{
 
    //         DB::table('users_properties_relations')
    //         ->insert
    //                 (
    //                     [
    //                         'user_id_foreign' => $user_id_foreign->user_id_foreign,
    //                         'property_id_foreign' => $property_id,
    //                     ]
    //                 ); 
    //  }

    

    // return $user_id_foreign->user_id_foreign;

    // return DB::table('users_properties_relations')
    // ->where('user_property_id','>', '8')
    // ->delete();

//    return DB::table('users')
//     ->where('id','>=','44' )   
//     ->delete();



    // DB::table('users_properties_relations')
    // ->where('user_id_foreign', $user_id)
    // ->update(
    //     [
    //         'property_id_foreign'=> $property_id
    //     ]   
    //     );

    // $sessions = User::findOrFail(Auth::user()->id)->sessions;

    //  $sessions->count();
    // if($sessions->count() <= 0){
    //     return 'isnert';
    // }else{
    //     return 'dont insert';
    // }

//    return DB::table('units')

//     ->join('unit_owners', 'unit_id', 'unit_id_foreign')
 
//     ->where('unit_property', Auth::user()->property)
//     ->update([
//         'unit_unit_owner_id' => 'unit_id_foreign'
//     ]);

    // DB::table('users')
    //  ->where('property', Auth::user()->property)
    //  ->where('id','<>',Auth::user()->id )
    // ->update([
    //     'lower_access_user_id' => Auth::user()->id
    // ]);

//     DB::table('users')
//    ->update([
//        'trial_ends_at' => Carbon::now()->addMonth()
//    ]);

//     DB::table('users')
//    ->update([
//        'trial_ends_at' => Carbon::now()->addMonths(2)
//    ]);

//  $uuid = Uuid::generate()->string;

//  $owners = UnitOwner::all()->max('unit_owner_id');

// for ($i=1; $i <=$owners ; $i++) { 

//         if (UnitOwner::where('unit_owner_id', $i)->exists()) {
//           $owner = UnitOwner::findOrFail($i);

//           $certificate = new Certificate();
//           $certificate->certificate_id =  Uuid::generate()->string;
//           $certificate->unit_id_foreign =  $owner->unit_id_foreign;
//           $certificate->owner_id_foreign =  $owner->unit_owner_id;
//           $certificate->date_purchased =  Carbon::now();
//           $certificate->date_accepted =  Carbon::now();
//           $certificate->status =  'active';
//           $certificate->save();
//          }
//         }

//  $tenants = Tenant::all()->max('tenant_id');

// for ($i=1; $i <=$tenants ; $i++) { 

//         if (Tenant::where('tenant_id', $i)->exists()) {
//           $tenant = Tenant::findOrFail($i);

//             $tenant = new Tenant($tenant->tenant_id);
//             $tenant->name = $tenant->first_name.$tenant->middle_name.$tenant->last_name;
//             $tenant->save();

//          }
//         }



        return back()->with('success', 'Credentials are created successfully!');


});

//routes for concerns
Route::get('/property/{property_id}/concerns', 'ConcernController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/concern', 'ConcernController@store')->middleware(['auth', 'verified']);

Route::post('/property/{property_id}/home/{unit_id}/concern', 'ConcernController@store_room_concern')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/concern/{concern_id}', 'ConcernController@show')->middleware(['auth', 'verified']);

//routes for contracts
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}', 'ContractController@show')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/edit', 'ContractController@edit')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/update', 'ContractController@update')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/preterminate', 'ContractController@preterminate')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/preterminate_post', 'ContractController@preterminate_post')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/moveout', 'ContractController@moveout_get')->middleware(['auth', 'verified']);
Route::delete('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}', 'ContractController@destroy')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/moveout', 'ContractController@moveout_post')->middleware(['auth', 'verified']);

Route::get('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/alert', 'ContractController@send_contract_alert')->middleware(['auth', 'verified']);

Route::post('/property/{property_id}/concern/{concern_id}/joborder', 'JobOrderController@store')->middleware(['auth', 'verified']);

//routes for job orders
Route::get('/property/{property_id}/joborders', 'JobOrderController@index')->middleware(['auth', 'verified']);

//routes for personnels
Route::get('/property/{property_id}/personnels', 'PersonnelController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/personnel', 'PersonnelController@store')->middleware(['auth', 'verified']);
Route::delete('/property/{property_id}/personnel/{personnel_id}/', 'PersonnelController@destroy')->middleware(['auth', 'verified']);

//routes for bills
Route::get('/property/{property_id}/bills', 'BillController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/bills/edit', 'BillController@edit_tenant_bills')->middleware(['auth', 'verified']);


Route::get('/property/{property_id}/unit/{home_id}/bills/edit', 'BillController@edit_occupant_bills')->middleware(['auth', 'verified']);

//export bills
Route::get('/property/{property_id}/tenant/{tenant_id}/bills/export', 'BillController@export')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/home/{unit_id}/bills/export', 'BillController@export_occupant_bills')->middleware(['auth', 'verified']);


Route::put('/property/{property_id}/tenant/{tenant_id}/bills/update', 'BillController@post_edited_bills')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/home/{unit_id}/bills/update', 'BillController@update_occupant_bills')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/rent/{date}', 'BillController@post_bills_rent')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/condodues/{date}', 'BillController@post_bills_condodues')->middleware(['auth', 'verified']);

Route::post('property/{property_id}/bills/create', 'BillController@store')->middleware(['auth', 'verified']);

Route::post('property/{property_id}/tenant/{tenant_id}/bills/create', 'BillController@post_tenant_bill')->middleware(['auth', 'verified']);


Route::post('property/{property_id}/unit/{unit_id}/bills/create', 'BillController@post_unit_bill')->middleware(['auth', 'verified']);

Route::post('property/{property_id}/bills/electric/{date}', 'BillController@post_bills_electric')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/water/{date}', 'BillController@post_bills_water')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/surcharge/{date}', 'BillController@post_bills_surcharge')->middleware(['auth', 'verified']);



//routes for collections
Route::get('/property/{property_id}/collections', 'CollectionController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/collection', 'CollectionController@store')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/home/{unit_id}/collection', 'CollectionController@collect_unit_payment')->middleware(['auth', 'verified']);

//routes for financials
Route::get('/property/{property_id}/financials', 'FinancialController@index')->middleware(['auth', 'verified']);

//routes for payables
Route::get('/property/{property_id}/payables', 'PayableController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable', 'PayableController@store')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable/request', 'PayableController@request')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable/{payable_id}/approve', 'PayableController@approve')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable/{payable_id}/decline', 'PayableController@decline')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable/{payable_id}/release', 'PayableController@release')->middleware(['auth', 'verified']);

//routes for tenant users
Route::get('/property/{property_id}/users', 'UserController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/user/{user_id}', 'UserController@show')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/user/{user_id}', 'UserController@update')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}', 'UserController@upgrade')->middleware(['auth', 'verified']);

Route::post('/user/{user_id}/tenant/{tenant_id}/dashboard', 'UserController@show_user_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/dashboard', 'UserController@show_user_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/rooms', 'UserController@show_room_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/bills', 'UserController@show_bill_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/payments', 'UserController@show_payment_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/concerns', 'UserController@show_concern_tenant')->middleware(['auth', 'verified']);
Route::post('/user/{user_id}/tenant/{tenant_id}/concerns', 'UserController@store_concern_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/concern/{concern_id}/responses', 'UserController@show_concern_responses')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/tenant/{tenant_id}/profile', 'UserController@show_profile_tenant')->middleware(['auth', 'verified']);
Route::put('/user/{user_id}/tenant/{tenant_id}/profile', 'UserController@show_update_tenant')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/portal/tenant/', 'UserController@show_portal_tenant')->middleware(['auth', 'verified']);


//routes for owner users
Route::get('/property/{property_id}/users', 'UserController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/user/{user_id}', 'UserController@show')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/user/{user_id}', 'UserController@update')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}', 'UserController@upgrade')->middleware(['auth', 'verified']);

Route::post('/user/{user_id}/owner/{owner_id}/dashboard', 'OwnerAccessController@dashboard')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/dashboard', 'OwnerAccessController@dashboard')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/rooms', 'OwnerAccessController@room')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/bills', 'OwnerAccessController@bill')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/payments', 'OwnerAccessController@payment')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/concerns', 'OwnerAccessController@concern')->middleware(['auth', 'verified']);
Route::post('/user/{user_id}/owner/{owner_id}/concerns', 'OwnerAccessController@store_concern')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/concern/{concern_id}/responses', 'OwnerAccessController@show_concern_responses')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/profile', 'OwnerAccessController@profile')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/remittances', 'OwnerAccessController@remittance')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/remittance/{remittance_id}/expenses', 'OwnerAccessController@expense')->middleware(['auth', 'verified']);
Route::put('/user/{user_id}/owner/{owner_id}/profile', 'OwnerAccessController@update_profile')->middleware(['auth', 'verified']);



//routes for dev
Route::get('/dev/activities/', 'DevController@activities')->middleware(['auth', 'verified']);
Route::get('/dev/properties/', 'DevController@properties')->middleware(['auth', 'verified']);
Route::get('/dev/users/', 'DevController@users')->middleware(['auth', 'verified']);
Route::get('/dev/starter/', 'DevController@starter')->middleware(['auth', 'verified']);
Route::get('/dev/announcements\/', 'DevController@announcements')->middleware(['auth', 'verified']);
Route::get('/dev/issues/', 'DevController@issues')->middleware(['auth', 'verified']);
Route::get('/dev/issue/{issue_id}/edit', 'DevController@edit_issue')->middleware(['auth', 'verified']);
Route::post('/dev/issue/{issue_id}/responses', 'DevController@add_response')->middleware(['auth', 'verified']);
Route::put('/dev/issue/{issue_id}/update', 'DevController@update_issue')->middleware(['auth', 'verified']);
Route::get('/dev/updates/', 'DevController@updates')->middleware(['auth', 'verified']);
Route::get('/dev/user/{user_id}', 'DevController@edit_user')->middleware(['auth', 'verified']);
Route::put('/dev/user/{user_id}', 'DevController@post_user')->middleware(['auth', 'verified']);
Route::get('/dev/plans', 'DevController@plans')->middleware(['auth', 'verified']);
Route::get('/dev/tenants', 'DevController@tenants')->middleware(['auth', 'verified']);
Route::post('/plan', 'DevController@post_plan')->middleware(['auth', 'verified']);
Route::get('/dev/user/{user_id}/plans', 'DevController@user_plans')->middleware(['auth', 'verified']);
Route::post('/dev/updates/store', 'UpdateController@store')->middleware(['auth', 'verified']);

Route::get('/register', function(Request $request){
    \Session::put('plan', $request->plan);
    if(\Session::get('plan') == null){
        return redirect('/#pricing');
    }

    return view('auth.register');
});

//routes for responses
Route::post('concern/{concern_id}/response', 'ResponseController@store')->middleware(['auth', 'verified']);

//routes for notifications
Route::get('property/{property_id}/notifications', 'NotificationController@index')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/delinquents', 'CollectionController@delinquents')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/pending-concerns', 'ConcernController@pending')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/expiring-contracts', 'ContractController@expired')->middleware(['auth', 'verified']);

//routes for remittances
Route::get('property/{property_id}/remittances', 'RemittanceController@index')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/remittances/store', 'RemittanceController@store')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/tenant/{tenant_id}/payment/{payment_id}/remittance/create', 'RemittanceController@create')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/room/{unit_id}/remittance/{remittance_id}', 'RemittanceController@show')->middleware(['auth', 'verified']);
Route::put('property/{property_id}/remittance/{remittance_id}/update', 'RemittanceController@update')->middleware(['auth', 'verified']);

//routes for the the layouts.arsha
Route::get('/', function(){
    $users = User::where('user_type','manager')->count();

    $properties = Property::whereNotIn('property_id',['2b5e65e0-1701-11eb-bf70-a74337c91b16'])->count();

    $rooms = Unit::whereNotIn('property_id_foreign',['2b5e65e0-1701-11eb-bf70-a74337c91b16'])->whereNotIn('status',['deleted'])->count();

    $tenants = DB::table('users_properties_relations')
     ->join('properties', 'property_id_foreign', 'property_id')
     ->join('tenants', 'users_properties_relations.user_id_foreign', 'tenants.user_id_foreign')
     ->where('property_id','<>' ,'2b5e65e0-1701-11eb-bf70-a74337c91b16')
     ->count();

    return view('layouts.arsha.index', compact('users','properties', 'rooms', 'tenants'));
});

Route::get('/listings', function(){

    $properties = Property::all()->count();

    return view('layouts.arsha.listings', compact('properties'));
});




//routes for payments
Route::get('units/{unit_id}/tenants/{tenant_id}/payments/{payment_id}', 'CollectionController@show')->name('show-payment')->middleware(['auth', 'verified']);
Route::post('/payments', 'CollectionController@store')->middleware(['auth', 'verified']);
Route::get('/payments/all', 'CollectionController@index')->name('show-all-payments')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/payments/search', 'CollectionController@index')->middleware(['auth', 'verified']);
Route::delete('/property/{property_id}/tenant/{tenant_id}/payment/{payment_id}', 'CollectionController@destroy')->middleware(['auth', 'verified']);

//export payments
Route::get('/property/{property_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export', 'CollectionController@export')->middleware(['auth', 'verified']);



Route::get('/property/{property}/export', function(Request $request){
    $collections = DB::table('units')
    ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
    ->leftJoin('payments', 'tenant_id', 'payment_tenant_id')
    ->leftJoin('bills', 'payment_bill_no', 'bill_no')
    ->where('unit_property', Auth::user()->property)
    ->whereDate('payment_created', Carbon::now())
    ->orderBy('payment_created', 'desc')
    ->orderBy('ar_no', 'desc')
    ->groupBy('payment_id')
    ->get();

    $data = [
        'collections' => $collections,
    ];

$pdf = \PDF::loadView('webapp.collections.export-collections-for-today', $data)->setPaper('a5', 'portrait');

return $pdf->download(Carbon::now().'-'.Auth::user()->property.'-ar'.'.pdf');


})->middleware(['auth', 'verified']);


//print gate pass
Route::get('/units/{unit_id}/tenants/{tenant_id}/print/gatepass', 'TenantController@printGatePass')->middleware(['auth', 'verified']);



Route::get('/units/{unit_id}/tenants/{tenant_id}/bills/send', function($unit_id,$tenant_id){
    $tenant = Tenant::findOrFail($tenant_id);
    $unit = Unit::findOrFail($unit_id);
    $bills = Billing::leftJoin('payments', 'bills.bill_no', '=', 'payments.payment_bill_no')
    ->selectRaw('*, bills.amount - IFNULL(sum(payments.amt_paid),0) as balance')
    ->where('bill_tenant_id', $tenant_id)
    ->groupBy('bill_id')
    ->havingRaw('balance > 0')
    ->get();
    $data = [
        'tenant' => $tenant->first_name.' '.$tenant->last_name ,
        'tenant_status' => $tenant->tenant_status,
        'unit' => $unit->building.' '.$unit->unit_no,
        'bills' => $bills,
];
    $pdf = \PDF::loadView('webapp.bills.soa', $data)->setPaper('a5', 'portrait');
    $pdf->download(Carbon::now().'-'.$tenant->first_name.'-'.$tenant->last_name.'-soa'.'.pdf');
   $pdf->save(storage_path().'_filename.pdf');
})->middleware(['auth', 'verified']);


Route::delete('/tenants/{tenant_id}', 'TenantController@destroy')->middleware(['auth', 'verified']);

Route::get('/owners', function(){
    if( auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){


            $owners = DB::table('owners')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('unit_property', Auth::user()->property)
            ->get();

            $count_owners = DB::table('owners')
            ->join('units', 'unit_id_foreign', 'unit_id')
            ->where('unit_property', Auth::user()->property)
            ->count();

            return view('webapp.owners.index', compact('owners', 'count_owners'));
    }else{
            return view('layouts.arsha.unregistered');
    }

})->middleware(['auth', 'verified']);

Route::get('/collections', function(){
    if(auth()->user()->user_type === 'billing' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'treasury'){

             $collections = DB::table('units')
             ->leftJoin('tenants', 'unit_id', 'unit_tenant_id')
             ->leftJoin('bills', 'tenant_id', 'bill_tenant_id')
             ->leftJoin('payments', 'payment_bill_id', 'bill_id')
            ->where('unit_property', Auth::user()->property)
            ->orderBy('payment_created', 'desc')
            ->orderBy('ar_no', 'desc')
            ->groupBy('payment_id')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->payment_created)->timestamp;
            });

        return view('webapp.collections.collections', compact('collections'));
    }else{
        return view('layouts.arsha.unregistered');
    }

})->middleware(['auth', 'verified']);

Route::get('/bills', function(){
    if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager' || auth()->user()->user_type === 'billing'){


        $bills = DB::table('units')
        ->join('tenants', 'unit_id', 'unit_tenant_id')
        ->join('bills', 'tenant_id', 'bill_tenant_id')
        ->where('unit_property', Auth::user()->property)
        ->orderBy('bill_no', 'desc')
        ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->start)->timestamp;
        });

        return view('webapp.bills.index', compact('bills'));
    }else{
        return view('layouts.arsha.unregistered');
    }

})->middleware(['auth', 'verified']);



Route::get('/housekeeping', function(){
    if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){

        $housekeeping = DB::table('personnels')
        ->where('personnel_property', Auth::user()->property)
        ->where('personnel_type', 'housekeeping')
        ->get();

        return view('webapp.hose.housekeeping', compact('housekeeping'));
    }else{
        return view('layouts.arsha.unregistered');
    }

})->middleware(['auth', 'verified']);

Route::get('/maintenance', function(){
    if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'manager'){

         $maintenance = DB::table('personnels')
        ->where('personnel_property', Auth::user()->property)
        ->where('personnel_type', 'maintenance')
        ->get();

        return view('webapp.personnels.maintenance', compact('maintenance'));
    }else{
        return view('layouts.arsha.unregistered');
    }

})->middleware(['auth', 'verified']);


//routes for bills
Route::get('/units/{unit_id}/tenants/{tenant_id}/billings', 'TenantController@show_billings')->name('show-billings')->middleware(['auth', 'verified']);
Route::get('/units/{unit_id}/tenants/{tenant_id}/billings/edit', 'TenantController@edit_billings')->middleware(['auth', 'verified']);
Route::put('/units/{unit_id}/tenants/{tenant_id}/billings/edit', 'TenantController@post_edited_billings')->middleware(['auth', 'verified']);
Route::delete('property/{property_id}/tenant/{tenant_id}/bill/{bill_id}', 'BillController@destroy')->middleware(['auth', 'verified']);

Route::delete('property/{property_id}/bill/{bill_id}/delete', 'BillController@destroy_bill_from_bills_page')->middleware(['auth', 'verified']);
Route::put('property/{property_id}/bill/{bill_id}/restore', 'BillController@restore_bill')->middleware(['auth', 'verified']);


//route for users
Route::get('/users/search', 'UserController@search')->middleware(['auth', 'verified']);

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->middleware(['auth', 'verified']);

//concerns
Route::post('/concerns', 'ConcernController@store')->middleware(['auth', 'verified']);

//show concerns
Route::get('/units/{unit_id}/tenants/{tenant_id}/concerns/{concern_id}', 'ConcernController@show')->middleware(['auth', 'verified']);

//update concerns
Route::put('/concerns/{concern_id}', 'ConcernController@update')->middleware(['auth', 'verified']);



//routes for personnels
Route::post('/personnels', 'PersonnelController@store')->middleware(['auth', 'verified']);


//routes for loggin in using google
Route::get('sign-in/google', 'Auth\LoginController@google');
Route::get('sign-in/google/redirect', 'Auth\LoginController@googleRedirect');


Route::put('/users/{user_id}/property', function(Request $request){

    $request->validate([
        'property' => 'required|unique:users|max:255',
        'property_ownership' => 'required',
        'property_type' => 'required',
    ]);

    DB::table('users')
    ->where('id', Auth::user()->id)
    ->update([
        'property' => $request->property,
        'property_type' => $request->property_type,
        'property_ownership' => $request->property_ownership
    ]);

    return back();

});

Route::put('/users/{user_id}/plan', function(Request $request){
    DB::table('users')
    ->where('id', Auth::user()->id)
    ->update([
        'account_type' => $request->account_type,
    ]);

    return back();

});

//routes for registration

//post the desired plan
Route::post('/users/{user_id}/charge', function(Request $request){

    if(Auth::user()->account_type === 'Free'){
         Mail::to(Auth::user()->email)->send(new TenantRegisteredMail());

         return back();
    }else{



        $charge = 0;

        if(Auth::user()->account_type === 'Medium'){
            $charge = 95000;
        }elseif(Auth::user()->account_type === 'Large'){
            $charge = 180000;
        }elseif(Auth::user()->account_type === 'Enterprise'){
            $charge = 240000;
        }elseif(Auth::user()->account_type === 'Corporate'){
            $charge = 480000;
        }

       try{
       

        Mail::to(Auth::user()->email)->send(new TenantRegisteredMail());

        return back();

       }catch(\Exception $e){
           return back()->with('danger', $e->getMessage());
       }
    }

});

//routes for rooms
Route::get('/property/{property_id}/rooms', 'RoomController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/room/{unit_id}', 'RoomController@show')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/rooms/{date}/edit', 'RoomController@edit_all')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/rooms/{date}/update', 'RoomController@update_all')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/room/store', 'RoomController@store')->middleware(['auth', 'verified']);
Route::delete('/property/{property_id}/room/{unit_id}/delete', 'RoomController@destroy')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/room/{unit_id}/restore', 'RoomController@restore')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/room/{room_id}/update', 'RoomController@update')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/room/{room_id}/upload', 'RoomController@upload')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/rooms/filter', 'RoomController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/rooms/clear', 'RoomController@clear')->middleware(['auth', 'verified']);


//routes for units
Route::get('/property/{property_id}/units', 'UnitController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/unit/{unit_id}', 'UnitController@show')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/units/{date}/edit', 'UnitController@edit_all')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/units/{date}/update', 'UnitController@update_all')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/unit/store', 'UnitController@store')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/unit/{unit_id}', 'UnitController@update')->middleware(['auth', 'verified']);






//routes for resources in landing page

//show privacy policy
Route::get('/privacy-policy', function(){
    return view('layouts.arsha.privacy-policy');
});

//show terms of service
Route::get('/terms-of-service', function(){
    return view('layouts.arsha.terms-of-service');
});


//show acceptable use policy
Route::get('/acceptable-use-policy', function(){
    return view('layouts.arsha.acceptable-use-policy');
});


//close concern 
Route::put('/concern/{concern_id}/closed', 'ConcernController@closed')->middleware(['auth', 'verified']);

//routes for logging in using facebook
Route::get('/login/google', 'Auth\LoginController@redirectToProvider');
Route::get('/login/google/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('listing', ['as' => 'listing', 'uses'=>'AdsController@listing']);