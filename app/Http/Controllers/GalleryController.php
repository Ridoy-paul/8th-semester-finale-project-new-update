<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Auth;
use Image;
use File;
use Alert;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $galleries = Gallery::orderBy('id', 'DESC')->get();
            return view('admin.gallery.index', compact('galleries'));
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
        if (count($request->image) > 0){
            $i = 0;
            foreach ($request->image as $image){
                $img = time() . $i . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/gallery/'. $img);
                Image::make($image)->resize(1000, 800)->save($location);

                $gallery = new Gallery;
                $gallery->image = $img;
                $gallery->save();
                $i = $i + 1;
            }
        }
        Alert::toast('Images has been uploaded', 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->type == 1) {
            $gallery = Gallery::find($id);
            if (!is_null($gallery)) {
                if (File::exists('images/gallery/'.$gallery->image)){
                    File::delete('images/gallery/'.$gallery->image);
                }
                $gallery->delete();
                Alert::toast('Gallery image has been deleted', 'success');
                return redirect()->route('gallery.index');
            }
            else {
                Alert::toast('Something went wrong!', 'error');
                return back();
            }
        }
        else {
            Alert::toast('Something went wrong!', 'error');
            return back();
        }
    }
}
