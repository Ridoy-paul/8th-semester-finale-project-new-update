<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Auth;
use Alert;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $coupons = Coupon::all();
            return view('admin.coupone.index', compact('coupons'));
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
        if (Auth::user()->type == 1) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'discount' => 'required|numeric',
                'coupon_type' => 'required|string',
                'valid_to' => 'required|date',
            ]);
            $coupon = new Coupon;
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            if ($request->coupon_type == 'percent') {
                $coupon->discount = $request->discount;
            }
            if ($request->coupon_type == 'flat') {
                $coupon->amount = $request->discount;
            }
            $coupon->valid_from = date('Y-m-d');
            $coupon->valid_to = $request->valid_to;
            if ($request->has('single_use')) {
                $coupon->single_use = 1;
            }

            $coupon->save();

            Alert::toast('Coupon Added Successfully', 'success');
            return redirect()->route('coupon.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->type == 1) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'discount' => 'required|numeric',
                'valid_to' => 'required|date',
            ]);
            $coupon = Coupon::find($id);
            if (!is_null($coupon)) {
                $coupon->name = $request->name;
                $coupon->code = $request->code;
                $coupon->discount = $request->discount;
                $coupon->valid_to = $request->valid_to;
                if ($request->coupon_type == 'percent') {
                    $coupon->discount = $request->discount;
                    $coupon->amount = NULL;
                }
                if ($request->coupon_type == 'flat') {
                    $coupon->amount = $request->discount;
                    $coupon->discount = NULL;
                }
                $coupon->save();

                Alert::toast('Coupon updated Successfully', 'success');
                return redirect()->route('coupon.index');
            }
            else {
                session()->flash('error','Something went wrong!');
                return back();
            } 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->type == 1) {
            $coupon = Coupon::find($id);
            if (!is_null($coupon)) {
                $coupon->delete();
                Alert::toast('Coupon has been deleted', 'success');
                return redirect()->route('coupon.index');
            }
            else {
                session()->flash('error','Something went wrong!');
                return back();
            }
        }
        else {
            session()->flash('error','Something went wrong!');
            return back();
        }
    }
}
