<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Alert;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $orders = Order::all();
            $yearly_orders = Order::whereYear('created_at', Carbon::now()->year)->get();
            $monthly_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)
                ->get();
            $daily_orders = Order::whereDate('created_at', Carbon::today())->get();
            
            return view('admin.index', compact('orders', 'yearly_orders', 'monthly_orders', 'daily_orders'));
            
        }
        else if(Auth::user()->type == 2){
            return redirect()->route('customer.account');
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }
}
