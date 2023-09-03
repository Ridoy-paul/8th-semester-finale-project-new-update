<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Wallet;
use App\Models\WalletEntry;
use App\Models\RegistrationPoint;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Carbon\Carbon;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'phone' => ['nullable', 'string', 'unique:users'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function check_registration_point()
    {
        $registration_point = RegistrationPoint::where('is_active', 1)->first();
        $status = false;
        $point = 0;
        if (!is_null($registration_point)) {
            $valid_from = Carbon::createFromFormat('Y-m-d H:i:s', $registration_point->valid_from.' 00:00:00');
            $valid_to = Carbon::createFromFormat('Y-m-d H:i:s', $registration_point->valid_to.' 23:59:59');
            if (($valid_from->isPast()) && !($valid_to->isPast())) {
                $status = true;
                $point = $registration_point->point;
            }
            else {
                $status = false;
            }
        }
        else {
            $status = false;
        }

        $point = [
            'status' => $status,
            'point' => $point
        ];

        return $point;
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            //'city' => $data['city'],
            //'address' => $data['address'],
            'type' => 1,
            'password' => Hash::make($data['password']),
        ]);

        // if (Session::has('referral_id')) {
        //     $user->referral_id = Session::get('referral_id');
        //     $user->save();
        // }

        // $wallet = new Wallet;
        // $wallet->customer_id = $user->id;
        // $wallet->save();

        // $entry = new WalletEntry;
        // $entry->wallet_id = $wallet->id;
        // $entry->point_in = 0;
        // $point = $this->check_registration_point();
        // if ($point['status']) {
        //     $entry->point_in = $point['point'];
        // }
        // $entry->save();

        return $user;
    }
}
