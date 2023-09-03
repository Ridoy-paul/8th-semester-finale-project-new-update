<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Image;
use File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $brands = Brand::orderBy('position', 'ASC')->get();
            return view('admin.brand.index', compact('brands'));
        }
        else{
            Alert::toast('Access Denied !', 'error');
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
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable',
        ]);
        $brand = new Brand;
        $brand->title = $request->title;
        $brand->is_featured = $request->is_featured;
        $brand->position = $request->position;
        
        // image save
        if ($request->image){
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/brand/'. $img);
            Image::make($image)->save($location);
            $brand->image = $img;
        }
        $brand->save();
        Alert::toast('One Brand Added !', 'success');
        return redirect()->route('brand.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image'=> 'nullable',
        ]);

        $brand = Brand::find($id);

        $brand->title = $request->title;
        $brand->is_featured = $request->is_featured;
        $brand->position = $request->position;
        
        // image save
        if ($request->image){
            if (File::exists('images/brand/'.$brand->image)){
                File::delete('images/brand/'.$brand->image);
            }
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/brand/'. $img);
            Image::make($image)->save($location);
            $brand->image = $img;
        }

        $brand->save();
        Alert::toast('Brand has been updated !', 'success');
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!is_null($brand)) {
            if (File::exists('images/brand/'.$brand->image)){
                File::delete('images/brand/'.$brand->image);
            }
            $brand->delete();
            Alert::toast('brand has been deleted !', 'success');
            return back();
        }
        else {
            session()->flash('error','Something went wrong !');
            return back();
        }
    }
}
