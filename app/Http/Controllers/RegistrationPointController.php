<?php

namespace App\Http\Controllers;

use App\Models\RegistrationPoint;
use Illuminate\Http\Request;
use Auth;
use Alert;

class RegistrationPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $registration_points = RegistrationPoint::all();
            return view('admin.registration-point.index', compact('registration_points'));
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
                'point' => 'required|numeric',
                'valid_from' => 'required|date',
                'valid_to' => 'required|date',
            ]);
            $registration_point = new RegistrationPoint;
            $registration_point->point = $request->point;
            $registration_point->valid_from = $request->valid_from;
            $registration_point->valid_to = $request->valid_to;
            $registration_point->is_active = $request->is_active;

            $registration_point->save();

            Alert::toast('Registration Point Added Successfully', 'success');
            return redirect()->route('registration.point.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegistrationPoint  $registrationPoint
     * @return \Illuminate\Http\Response
     */
    public function show(RegistrationPoint $registrationPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegistrationPoint  $registrationPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistrationPoint $registrationPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegistrationPoint  $registrationPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->type == 1) {
            $validatedData = $request->validate([
                'point' => 'required|numeric',
                'valid_from' => 'required|date',
                'valid_to' => 'required|date',
            ]);
            $registration_point = RegistrationPoint::find($id);
            if (!is_null($registration_point)) {
                $registration_point->point = $request->point;
                $registration_point->valid_from = $request->valid_from;
                $registration_point->valid_to = $request->valid_to;
                $registration_point->is_active = $request->is_active;

                $registration_point->save();

                Alert::toast('Registration Point updated Successfully', 'success');
                return redirect()->route('registration.point.index');
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
     * @param  \App\Models\RegistrationPoint  $registrationPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->type == 1) {
            $registration_point = RegistrationPoint::find($id);
            if (!is_null($registration_point)) {
                $registration_point->delete();
                Alert::toast('Registration Point has been deleted', 'success');
                return redirect()->route('registration.point.index');
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
