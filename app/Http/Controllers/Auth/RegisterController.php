<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Mail\TenantRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    protected $redirectTo = '/property/all';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
           
        $data = array(
            'email' => $data['email'],
            'password' => $data['password'],
            'name' => $data['name'],
            'property' => Session::get('property_name'),
        );

                Mail::send('webapp.users.welcome-generated-mail', $data, function($message) use ($data){
                $message->to([$data['email'], 'customercare@thepropertymanager.online']);
                $message->subject('Welcome New User');
            });  

         return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 'manager',
            'status' => 'registered',
            'password' => Hash::make($data['password']),
            'created_at' => Carbon::now(),
            // 'email_verified_at' => Carbon::now(),
            'account_type' => Session::get('plan'),
            'trial_ends_at' => Carbon::now()->addDays(14),
        ]);

    }


}