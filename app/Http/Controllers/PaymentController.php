<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Auth;
use Alert;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function payment_request()
    {
        if (Auth::user()->type == 1) {
            $payments = Payment::where('paid_amount', NULL)->where('is_paid', 0)->where('is_reject', 0)->get();
            return view('admin.payment.request', compact('payments'));
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function payment_transfer( Request $request, $id)
    {
        if (Auth::user()->type == 1) {
            $payment = Payment::find($id);
            $payment->is_paid = 1;
            $payment->save();

            $new_payment = new Payment;
            $new_payment->customer_id = $payment->customer_id;
            $new_payment->paid_amount = $payment->request_amount;
            $new_payment->is_paid = 1;
            $new_payment->save();
            Alert::toast('Payment Saved');
            return back();
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function payment_reject( Request $request, $id)
    {
        if (Auth::user()->type == 1) {
            $payment = Payment::find($id);
            $payment->is_reject = 1;
            $payment->save();
            Alert::toast('Payment Rejected');
            return back();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
