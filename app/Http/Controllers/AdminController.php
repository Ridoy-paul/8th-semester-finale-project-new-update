<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use Image;
Use File;
use Alert;
use Illuminate\Support\Facades\Redirect;
use App\Models\AboutUs;
use App\Models\WalletTransactions;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function custom_registration(Request $request) {

        session(['register_type' => $request->register_type]);
        if($request->register_type == 'phone') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'unique:users'],
                'city' => ['nullable'],
                'address' => ['nullable'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
        else if($request->register_type == 'email') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'phone' => ['nullable', 'string', 'unique:users'],
                'city' => ['nullable'],
                'address' => ['nullable'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->type = 2; // type 2 is customer
        $user->password = Hash::make($request->password);
        $user->save();

        $point_check = DB::table('registration_points')->where(['is_active'=>1])->where('valid_from', '<=', date('Y-m-d'))->where('valid_to', '>=', date('Y-m-d'))->first(['point']);
        if(!is_null($point_check)) {
            $user->wallet_point += ($point_check->point + 0);
            $user->save();
            $wallet_transactions = new WalletTransactions;
            $wallet_transactions->user_id = $user->id;
            $wallet_transactions->in_or_out = 'in';
            $wallet_transactions->point_or_wallet_tk = 'point';
            $wallet_transactions->amount = $point_check->point;
            $wallet_transactions->for_which = 'Registration Point';
            $wallet_transactions->date = now();
            $wallet_transactions->save();
        }

        return $this->check_auth_varification($user);
        //Auth::login($user);
     }

     public function custom_login(Request $request) {

        $request->validate([
            'userName' => 'required',
            'password' => 'required',
        ]);

        $userName = $request->userName;
        $user = User::where('phone', $userName)->orWhere('email', $userName)->first();
        if(!is_null($user)) {
            if (Hash::check($request->password, $user->password)) {
                return $this->check_auth_varification($user);
            }
            else {
                return Redirect()->back()->with('error', 'Invalid Password!');
            }
        }
        else {
            return Redirect()->back()->with('error', 'No User Found!');
        }
     }


     public function check_auth_varification($data) {

        if($data->phone <> null){
            if($data->is_phone_verified == 1) {
                Auth::login($data);
            }
            else {
                $this->send_otp($data);
                session(['user_id' => $data->id]);
                return Redirect()->route('auth.phone.verify');
            }
        }
        else if($data->email <> null) {
            Auth::login($data);
        }

        if($data->type == 1 || $data->type == 3) {
            return Redirect()->route('home')->with('success', 'Successfully Login.');
        }
        else {
            return Redirect()->route('customer.account')->with('success', 'Successfully Login.');
        }

     }

     public function send_otp($data) {

        $number = $data->phone;
        $otp = rand(100000, 999999);
        $user = User::find($data->id);
        $user->verification_code = $otp;
        $user->save();

        $msg = "ভেরিফিকেশন কোড: ".$otp;
        User::send_sms($number, $msg);

        /*
        $number = preg_replace('#[ -]+#', '', $number);
        $number = preg_replace('#[=]+#', '', $number);
        if(strlen($number)==10 || strlen($number)==13){
            $number = "0".$number; 
        }

        $msg = "ভেরিফিকেশন কোড: ".$otp;
         
         $url = "https://isms.mimsms.com/smsapi";
          $data = [
            "api_key" =>env('SMS_API_KEY'),
            "type" => "text",
            "contacts" => $number,
            "senderid" =>env('SMS_SENDER_ID'),
            "msg" => $msg,
          ];
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          $response = curl_exec($ch);
          curl_close($ch);
          return $response;
          */
     }

     public function auth_phone_verify() {
        $user_id = session('user_id');
        $user = User::find($user_id);
        if(!is_null($user)) {
            return view('auth.phone_verify', compact('user_id'));
        }
     }

     public function verify_user_phone(Request $request) {
        $user_id = $request->custom_token;
        $user = User::find($user_id);
        if(!empty($user)) {
            if($request->code == $user->verification_code) {
                $user->is_phone_verified = 1;
                $user->save();
                Auth::login($user);

                if($user->type == 1 || $user->type == 3) {
                    return Redirect()->route('home')->with('success', 'Successfully Login.');
                }
                else {
                    return Redirect()->route('customer.account')->with('success', 'Successfully Login.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Wrong OTP!');
            }
        }
        else {
            return Redirect()->back()->with('error', 'No User Found!');
        }
     }

     public function resend_verification_code(Request $request) {
        $user_id = $request->custom_token;
        $user = User::find($user_id);
        $this->send_otp($user);
        return 'success';
     }


     public function index()
    {
        if (Auth::user()->type == 1) {
            $admins = User::where('type', 1)->orderBy('id', 'DESC')->get();
            return view('admin.admin.index', compact('admins'));
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type == 1) {
            return view('admin.admin.create');
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'phone' => 'required|max:255|unique:users',
            'image' => 'nullable|image',
        ]);
        $admin = new User;
        $admin->name = $request->name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        //$admin->description = $request->description;
        $admin->city = $request->city;
        //$admin->country = $request->country;
        $admin->password = Hash::make($request->password);
        // image save
        if ($request->image){
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/admin/'. $img);
            Image::make($image)->save($location);
            $admin->image = $img;
        }
        $admin->type = 1;
        $admin->is_active = 1;
        $admin->save();
        //$admin->sendEmailVerificationNotification();

        Alert::toast('One admin added !', 'success');
        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->type == 1) {
            $admin = User::find($id);
            if (!is_null($admin)) {
                return view('admin.admin.edit', compact('admin'));
            }
            else{
                session()->flash('error','Something went wrong !');
                return back();
            }
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
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
        $admin = User::find($id);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,'.$admin->id,
            'phone' => 'required|max:255|unique:users,phone,'.$admin->id,
            'image' => 'nullable|image',
        ]);
        $admin->name = $request->name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        // $admin->description = $request->description;
        $admin->city = $request->city;
        // $admin->country = $request->country;
        
        // image save
        if ($request->image){
            if (File::exists('images/admin/'.$admin->image)){
                File::delete('images/admin/'.$admin->image);
            }
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/admin/'. $img);
            Image::make($image)->save($location);
            $admin->image = $img;
        }

        

        $admin->save();

        Alert::toast('Admin Updated !', 'success');
        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = User::find($id);
        if (!is_null($admin)) {
            if (File::exists('images/admin/'.$admin->image)){
                File::delete('images/admin/'.$admin->image);
            }
            $admin->delete();
            Alert::toast('Admin has been deleted !', 'success');
            return redirect()->route('admin.index');
        }
        else {
            session()->flash('error','Something went wrong !');
            return redirect()->route('admin.index');
        }
    }

    public function customer_index()
    {
        if (Auth::user()->type == 1) {
            $customers = User::where('type', 2)->orderBy('id', 'DESC')->get();
            return view('admin.customer.index', compact('customers'));
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function customer_destroy($id)
    {
        $customer = User::find($id);
        if (!is_null($customer)) {
            if (File::exists('images/customer/'.$customer->image)){
                File::delete('images/customer/'.$customer->image);
            }
            $customer->delete();
            Alert::toast('Customer has been deleted !', 'success');
            return redirect()->route('customer.index');
        }
        else {
            session()->flash('error','Something went wrong !');
            return redirect()->route('customer.index');
        }
    }

    public function about_us_setting_index() {
        $info = AboutUs::first();
        return view('admin.about-us.index', compact('info'));
    }

    public function about_us_setting_store(Request $request) {

        $setting = AboutUs::first();

        if(is_null($setting)) {
            $setting = new AboutUs;
        }

        $setting->about_us_text = $request->about_us_text;
        $setting->mission = $request->mission;
        $setting->vission = $request->vission;
        $setting->custom_block_title = $request->custom_block_title;
        $setting->custom_block_details = $request->custom_block_details;

        // Image save
        if ($request->image){
            if (File::exists('images/website/'.$setting->image)){
                File::delete('images/website/'.$setting->image);
            }
            $image = $request->file('image');
            $img = time().rand().'.' . $image->getClientOriginalExtension();
            $location = public_path('images/website/'. $img);
            Image::make($image)->save($location);
            $setting->image = $img;
        }

        $setting->save();

        Alert::toast('About Us Settings has been updated !', 'success');
        return back();

    }

    public function forgot_password_send_otp(Request $request) {
        $output = '';
        $phone = $request->phone;
        $user_info = User::where('phone', $phone)->first();
        
        if(is_null($user_info)) {
            $output = [
                'status' => 'no',
                'reason' => 'Invalid Phone Number.',
            ];
            return Response($output);
        }
        else {
            $this->send_otp($user_info);
            $new_user_info = User::find($user_info->id);
            $output = [
                'status' => 'yes',
                'user_id' => $new_user_info->id,
                'otp' => optional($new_user_info)->verification_code,
                'reason' => 'Verification Code Sent',
            ];
            return Response($output);
        }
    }

    public function password_reset_confirm(Request $request) {
        $user_id = $request->user_id;
        $password = $request->password;
        $confirm_password = $request->confirm_password;
        if($password <> $confirm_password) {
            $output = [
                'status' => 'no',
                'reason' => 'Password Not Mached.',
            ];
            return Response($output);
        }

        $user = User::where('id', $user_id)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);
        
        $output = [
            'status' => 'yes',
            'reason' => 'New Password Set Successfully.',
        ];

        return Response($output);
    }


}
