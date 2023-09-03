<?php

namespace App\Http\Controllers;

use App\Models\ProductsReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Alert;

class ProductsReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $reviews = ProductsReviews::orderBy('id', 'DESC')->get();
            return view('admin.review.index', compact('reviews'));
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
     * @param  \App\Models\ProductsReviews  $productsReviews
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsReviews $productsReviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsReviews  $productsReviews
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->type == 1) {
            $review = ProductsReviews::find($id);
            if(is_null($review)) {
                session()->flash('error','No Review Found!');
                return Redirect()->back();
            }
            return view('admin.review.edit', compact('review'));
        }
        else {
            session()->flash('error','Access Denied!');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsReviews  $productsReviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->type == 1) {
            $review = ProductsReviews::find($id);
            if(is_null($review)) {
                Alert::error('No Review Found!', '');
                return Redirect()->back();
            }

            $review->review_star = $request->review_star;
            $review->review_text = $request->review_text;
            $review->is_active = $request->is_active;
            $review->save();
            Alert::success('Review Info Updated.', '');
            return Redirect()->route('product.review.index');
        }
        else {
            Alert::error('Access Denied!', '');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsReviews  $productsReviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsReviews $productsReviews)
    {
        //
    }
}
