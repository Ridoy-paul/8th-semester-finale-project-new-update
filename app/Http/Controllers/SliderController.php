<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\HomePageFourBanner;
use Illuminate\Http\Request;
use Auth;
use File;
use Image;
use Alert;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $sliders = Slider::OrderBy('serial_number', 'ASC')->get();
            return view('admin.slider.index', compact('sliders'));
        }
        else {
            return back();
        }
    }

    public function home_page_four_banner_show()
    {
        if (Auth::user()->type == 1) {
            $banners = HomePageFourBanner::all();
            return view('admin.home_page_four_banner.index', compact('banners'));
        }
        else {
            return back();
        }
    }
    
    public function home_page_four_banner_update(Request $request)
    {
        
        $validatedData = $request->validate([
            'position' => 'required|integer',
            'image' => 'image',
            'link' => 'nullable',
        ]);

        $banner = HomePageFourBanner::find($request->position);
        
        if (is_null($banner)) {
            $banner = new HomePageFourBanner;
        }
        
        // image save
        if ($request->image){
            if (File::exists('images/slider/'.$banner->image)){
                File::delete('images/slider/'.$banner->image);
            }
            $image = $request->file('image');
            $img = time().rand().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/slider/'. $img);
            Image::make($image)->save($location);
            $banner->image = $img;
        }
        if ($request->link != null) {
            $banner->link = $request->link;
        }
        if ($request->title != null) {
            $banner->title = $request->title;
        }
        if ($request->description != null) {
            $banner->description = $request->description;
        }
        
        $banner->save();
        
        Alert::toast('Banner has been changed', 'success');
        return redirect()->route('f.banner.show');
        
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
        $validatedData = $request->validate([
            'serial_number' => 'required|integer',
            'image' => 'image',
            'link' => 'nullable',
        ]);

        $slider = new Slider;
        $slider->title = $request->title;
        $slider->serial_number = $request->serial_number;
        $slider->description = $request->description;
        $slider->link = $request->link;
        
        if ($request->image){
            if (File::exists('images/slider/'.$slider->image)){
                File::delete('images/slider/'.$slider->image);
            }
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/slider/'. $img);
            Image::make($image)->save($location);
            $slider->image = $img;
        }

        $slider->save();

        Alert::toast('New Slider Added Successfully.', 'success');
        return redirect()->route('slider.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        if(!is_null($slider)) {
            return view('admin.slider.edit', compact('slider'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'serial_number' => 'required|integer',
            'image' => 'image',
            'link' => 'nullable',
        ]);

        $slider = Slider::find($id);

        if (!is_null($slider)) {

            $slider->title = $request->title;
            $slider->serial_number = $request->serial_number;
            $slider->description = $request->description;
            $slider->link = $request->link;

            // image save
            if ($request->image){
                if (File::exists('images/slider/'.$slider->image)){
                    File::delete('images/slider/'.$slider->image);
                }
                $image = $request->file('image');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/slider/'. $img);
                Image::make($image)->save($location);
                $slider->image = $img;
            }

            $slider->save();
            
            Alert::toast('Slide Info has been changed', 'success');
            return redirect()->route('slider.index');
        }
        else {
            Alert::toast('Something went wrong!', 'error');
            return redirect()->route('slider.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
