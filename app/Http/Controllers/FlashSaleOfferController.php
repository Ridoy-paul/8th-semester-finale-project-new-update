<?php

namespace App\Http\Controllers;

use App\Models\FlashSaleOffer;
use App\Models\FlashSaleOfferProducts;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use Image;
use File;
use Alert;
use Illuminate\Support\Facades\Redirect;

class FlashSaleOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $flash_sales = FlashSaleOffer::orderBy('id', 'DESC')->get();
            return view('admin.product.flash_sale', compact('flash_sales'));
        }
        else{
            Alert::toast('Access Denied !', 'error');
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
            return view('admin.product.create_flash_sale_offer');
        }
        else{
            Alert::toast('Access Denied !', 'error');
            return back();
        }
    }


    public function search_product(Request $request) {
        $title = $request->title;
        
        $output = '';
        $products = Product::where('title', 'like', '%' . $title . '%')->limit(15)->get();
        
        if($title != '') {
            if($products->isNotEmpty()) {                
                foreach($products as $product) {
                    $type = 'simple';
                        $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->title.'\', \''.$product->thumbnail_image.'\', \''.$product->discount_type.'\', \''.$product->discount_amount.'\')" title="Add me">
                        <div class="row" id="product_text">
                            <div class="col-md-4">
                                <img src="'.asset('/images/product/'.$product->thumbnail_image).'" alt="'.$product->title.'" width="100%" class="shadow rounded p-1">
                            </div>
                            <div class="col-md-8">
                                <span>'.$product->title.'</span>
                            </div>
                        </div>
                        <div class="">
                            <small class="text-primary">Brand: '.optional($product->brand)->title.'</small>
                        </div>
                        
                    </li>';
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        return response()->json($output);

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

        $flash_sales = new FlashSaleOffer;
        $flash_sales->title = $request->title;
        $flash_sales->description = $request->description;
        $flash_sales->start_date_time = $request->start_date_time;
        $flash_sales->end_date_time = $request->end_date_time;
        $flash_sales->is_active = 1;

        // image save
        if ($request->image){
            $image = $request->file('image');
            $img = time().rand().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/product/'.$img);
            Image::make($image)->save($location);
            $flash_sales->image = $img;
        }

        $status = $flash_sales->save();

        if($status) {
            if(!is_null($request->pid)) {
                $pid = $request->pid;
                foreach($pid as $key => $item) {
                    $offer_product = new FlashSaleOfferProducts;
                    $offer_product->flash_sale_id = $flash_sales->id;
                    $offer_product->product_id = $pid[$key];
                    $offer_product->save();

                    $product = Product::find($pid[$key]);
                    $product->discount_type = $request->discount_type[$key];
                    $product->discount_amount = $request->discount_amount[$key];
                    $product->save();
                }
            }
        }

        Alert::toast('New Flash Sale Offer Added.', 'success');
        return Redirect()->route('flash.sale.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FlashSaleOffer  $flashSaleOffer
     * @return \Illuminate\Http\Response
     */
    public function show(FlashSaleOffer $flashSaleOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FlashSaleOffer  $flashSaleOffer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = FlashSaleOffer::find($id);
        return view('admin.product.edit_flash_sale_offer', compact('offer'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FlashSaleOffer  $flashSaleOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $flash_sales = FlashSaleOffer::find($id);

        if(is_null($flash_sales)) {
            Alert::toast('No Offer Found.', 'error');
            return Redirect()->back();
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable',
        ]);

        $flash_sales->title = $request->title;
        $flash_sales->description = $request->description;
        $flash_sales->start_date_time = $request->start_date_time;
        $flash_sales->end_date_time = $request->end_date_time;
        $flash_sales->is_active = $request->is_active;

        // image save
        if ($request->image){

            if (File::exists('images/product/'.$flash_sales->image)){
                File::delete('images/product/'.$flash_sales->image);
            }

            $image = $request->file('image');
            $img = time().rand().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/product/'.$img);
            Image::make($image)->save($location);
            $flash_sales->image = $img;
        }

        $status = $flash_sales->save();

        if($status) {
            if(!is_null($request->pid)) {

                foreach ($flash_sales->products as $product) {
                    $product->delete();
                }

                $pid = $request->pid;
                foreach($pid as $key => $item) {
                    $offer_product = new FlashSaleOfferProducts;
                    $offer_product->flash_sale_id = $flash_sales->id;
                    $offer_product->product_id = $pid[$key];
                    $offer_product->save();

                    $product = Product::find($pid[$key]);
                    $product->discount_type = $request->discount_type[$key];
                    $product->discount_amount = $request->discount_amount[$key];
                    $product->save();
                }
            }
        }

        Alert::toast('Flash Sale Offer Updated.', 'success');
        return Redirect()->route('flash.sale.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FlashSaleOffer  $flashSaleOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flash_sales = FlashSaleOffer::find($id);

        if(is_null($flash_sales)) {
            Alert::toast('No Offer Found.', 'error');
            return Redirect()->back();
        }

        foreach ($flash_sales->products as $product) {
            $product->delete();
        }

        $flash_sales->delete();

        Alert::toast('Flash Sale Offer Deleted.', 'success');
        return Redirect()->route('flash.sale.index');

    }
}
