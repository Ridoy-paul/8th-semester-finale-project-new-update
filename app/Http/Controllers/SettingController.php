<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Image;
use File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $setting = Setting::orderBy('id', 'DESC')->first();
            return view('admin.setting.index', compact('setting'));
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function affiliate_request()
    {
        $affiliates  = User::where('affiliate_applied', 1)->get();
        return view('admin.affiliate.index', compact('affiliates'));
    }

    public function affiliate_status($id, $status)
    {
        if (Auth::user()->type == 1) {
            $customer = User::find($id);
            if ($status == 'approve') {
                $customer->is_affiliate = 1;
                $customer->affiliate_applied = 0;
                $customer->save();
                Alert::toast('Application Approved');
                return back();
            }
            if ($status == 'reject') {
                $customer->affiliate_applied = 0;
                $customer->affiliate_rejection = $customer->affiliate_rejection + 1;
                $customer->save();
                Alert::toast('Application Rejected');
                return back();
            }
            else{
                return back();
            }
            dd($customer, $status);
        }
        else{
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function referral_link()
    {
        $link = route('index').'?referral='.Auth::id();
        return view('admin.setting.referral', compact('link'));
    }

    public function config()
    {
        $setting = Setting::find(1);
        return view('admin.setting.affiliate-config', compact('setting'));
    }

    public function reward_point()
    {
        $setting = Setting::find(1);
        return view('admin.setting.reward-point', compact('setting'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);


        $setting = Setting::find(1);

        if(is_null($setting)) {
            $setting = new Setting;
        }
        
        $setting->name = $request->name;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->address = $request->address;

        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->twitter = $request->twitter;
        $setting->youtube = $request->youtube;
        $setting->linkedin = $request->linkedin;

        $setting->meta_title = $request->meta_title;
        $setting->meta_keywords = $request->meta_keywords;
        $setting->meta_tag = $request->meta_tag;
        $setting->meta_description = $request->meta_description;
        

        
        // Header logo save
        if ($request->header_logo){
            if (File::exists('images/website/'.$setting->header_logo)){
                File::delete('images/website/'.$setting->header_logo);
            }
            $image = $request->file('header_logo');
            $img = time().rand().'.' . $image->getClientOriginalExtension();
            $location = public_path('images/website/'. $img);
            Image::make($image)->save($location);
            $setting->header_logo = $img;
        }

        // Footer logo save
        if ($request->footer_logo){
            if (File::exists('images/website/'.$setting->footer_logo)){
                File::delete('images/website/'.$setting->footer_logo);
            }
            $image = $request->file('footer_logo');
            $img = time().rand().'.' . $image->getClientOriginalExtension();
            $location = public_path('images/website/'. $img);
            Image::make($image)->save($location);
            $setting->footer_logo = $img;
        }

        // favicon save
        if ($request->favicon){
            if (File::exists('images/website/'.$setting->favicon)){
                File::delete('images/website/'.$setting->favicon);
            }
            $image = $request->file('favicon');
            $img = 'favicon_'.time().rand().'.' . $image->getClientOriginalExtension();
            $location = public_path('images/website/'. $img);
            Image::make($image)->save($location);
            $setting->favicon = $img;
        }


        $setting->save();
        Alert::toast('Settings has been updated !', 'success');
        return back();
    }

    public function config_update(Request $request, $id)
    {
        $this->validate($request, [
            'affiliate_commision' => 'required|numeric',
        ]);

        $setting = Setting::find($id);
        
        $setting->affiliate_commision = $request->affiliate_commision;
        $setting->save();
        Alert::toast('Affiliate Configuration updated !', 'success');
        return back();
    }

    public function reward_point_update(Request $request, $id)
    {
        $this->validate($request, [
            'minimum_point' => 'required|numeric|min:1',
            'equivalent_point' => 'required|numeric|min:1',
        ]);

        $setting = Setting::find($id);
        
        $setting->minimum_point = $request->minimum_point;
        $setting->equivalent_point = $request->equivalent_point;
        $setting->save();
        Alert::toast('Reward point setting updated !', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
