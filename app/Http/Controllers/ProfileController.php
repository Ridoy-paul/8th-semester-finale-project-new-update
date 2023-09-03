<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
use Image;
use File;
use Alert;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {
    	$user = Auth::user();
    	return view('admin.profile.index', compact('user'));
    }

    public function profile_update(Request $request)
    {
    	$user = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|max:255|unique:users,phone,'.$user->id,
            'image' => 'nullable|image',
        ]);
    	if (!is_null($user)) {
    		$user->name = $request->name;
	        $user->last_name = $request->last_name;
	        $user->email = $request->email;
	        $user->phone = $request->phone;
            $user->city = $request->city;
	        // $user->dob = $request->dob;
         //    $user->gender = $request->gender;
         //    $user->country = $request->country;
	        // if (Auth::user()->type != 3) {
	        // 	$user->description = $request->description;
	        	

        	
	        // }
            // image save
            if ($request->image){
                if (Auth::user()->type == 1) {
                    if (File::exists('images/admin/'.$user->image)){
                        File::delete('images/admin/'.$user->image);
                    }
                    $image = $request->file('image');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $location = public_path('images/admin/'. $img);
                    Image::make($image)->save($location);
                    $user->image = $img;
                }
                
            }
	        $user->save();
            Alert::toast('Profile has been updated', 'success');
        	return redirect()->route('user.profile');
    	}
    }

    public function change_password(Request $request)
    {
    	$user = Auth::user();
    	$c_password = $request->c_password;
    	$n_password = $request->n_password;
    	$cf_password = $request->cf_password;
    	//dd(Hash::make($c_password));
    	if (Hash::check($request->c_password, $user->password)) {
    		if ($n_password == $cf_password) {
    			$user->password = Hash::make($n_password);
    			$user->save();
                Alert::toast('Password has been updated', 'success');
        		return redirect()->route('user.profile');
    		}
    		else {
                Alert::toast('Password do not match !', 'error');
        		return redirect()->route('user.profile');
    		}
    	}
    	else{
            Alert::toast('Your current password is wrong !', 'error');
        	return redirect()->route('user.profile');
    	}
    }
}
