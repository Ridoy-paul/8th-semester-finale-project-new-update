<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Colors;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Variation;
use App\Models\ProductStocks;
use Illuminate\Http\Request;
use Auth;
use Image;
use File;
use Alert;
use App\Models\ProductWithCategory;
use Dompdf\Css\Color;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 1) {
            $products = Product::orderBy('id', 'DESC')->get();
            return view('admin.product.index', compact('products'));
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
            $categories = Category::orderBy('id', 'DESC')->get();
            $brands = Brand::orderBy('id', 'DESC')->get();
            $colors = Colors::orderBy('name', 'ASC')->get();
            $variations = Variation::all();
            return view('admin.product.create', compact('categories', 'brands', 'colors', 'variations'));
        }
        else{
            Alert::toast('Access Denied !', 'error');
            return back();
        }
    }

    public function generateUniqueCode()
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }

        if (Product::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;

    }


    public function generate_variation(Request $request) {
        $info = '';
        
        //return $request->attribute;

        if(is_null($request->variation_option) && is_null($request->attribute)){
            $info = [
                    'status'=>'not_selected',
                ];
        }
        else {
            
            $atributes = $request->attribute;
            
            $output = '';
            
            $atribute_output = '';
            
            $colour = $request->colour;
            
            if(!is_null($colour)) {
                $colour_info = Colors::where('code', $colour)->first();
                $color_id = $colour_info->id;
                $colour_output = '<div class="p-2 shadow rounded"><b>Colour: </b> <span style="background-color: '.$colour.'; padding: 5px;">'.$colour_info->name.'</span></div>';
            }
            else {
                $colour_output = '';
                $colour_info = '';
                $color_id = '';
            }

            $generating_id = date("ymdhis");
            
            if(!is_null($atributes)) {
                // foreach($atributes as $atribute) {
                    $atribute_info = Variation::where('id', $atributes)->first();
                    if(!is_null($atribute_info)) {
                        $atribute_output .= '<div>
                        <input type="hidden" name="attribute_id[]" value="'.$atribute_info->id.'">
                        <input type="hidden" name="attribute_id'.$generating_id.'" value="'.$atribute_info->id.'">
                            
                        <label><span class="text-danger">*</span>'.$atribute_info->title.'</label>
                        <input type="text" class="form-control" name="attribute_value[]" value="" required>
                    </div>';
                    }
                    else {
                        $atribute_output .= '<div>
                        <input type="hidden" name="attribute_id[]" value="">
                        <input type="hidden" name="attribute_id'.$generating_id.'" value="">
                        <input type="hidden" name="attribute_value[]" value="">
                        </div>';
                    }
                    
                // }
                
            }
            else {
                $atribute_output = '';
                $atribute_info = '';
            }
            
            
            $output .= '<div class="row p-2 shadow rounded mb-4" id="variation_info_div_'.$generating_id.'">
                        <input type="hidden" id="variation_parent'.$generating_id.'" name="variation_parent[]" value="'.$generating_id.'">
                        <input type="hidden" name="colour_attribute[]" value="'.$color_id.'">
                        <input type="hidden" name="new_or_old[]" value="new">
			              <div class="col-md-5">
			                <div>
                                '.$colour_output.'<br>
                                '.$atribute_output.'
			                </div>
			              </div>
			              <div class="col-md-6 shadow rounded border p-1 px-4">
			                  <div class="form-group">
            				    <label class="col-form-label"><b>Image</b></label>
            				    <input type="file" name="variation_image'.$generating_id.'" class="form-control">
            				  </div>
            				  
            				  <div class="form-group">
            				    <label class="col-form-label"><span class="text-danger">*</span><b>Variant Price</b></label>
            				    <input type="number" name="variant_price[]" class="form-control"required step=any>
            				  </div>
            				  
            				  <div class="form-group">
            				    <label class="col-form-label"><span class="text-danger">*</span><b>Stock Quantity</b></label>
            				    <input type="number" name="variation_stock_qty[]" class="form-control" required>
            				  </div>
			              </div>
			              
			              <div class="col-md-1">
			                  <button type="button" class="btn btn-danger" onclick="remove_variation_div('.$generating_id.')"><i class="fas fa-trash-alt text-light"></i></button>
			              </div>
			          </div>';
            
            $info = [
                    'status'=>'yes',
                    'code'=>$generating_id,
                    'output'=>$output,
                ];
            
        }
        
        
        return Response($info);
        
        
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

        
        $product = new Product;
        $product->title = $request->title;
        $product->category_id = 0;
        $product->sub_category_id = 0;
        $product->brand_id = $request->brand_id;
        $product->unit_type = $request->unit_type;
        $product->is_featured = isset($request->is_featured)? 1 : 0;
        $product->is_tranding = isset($request->is_tranding)? 1 : 0;
        $product->todays_deal = isset($request->todays_deal)? 1 : 0;
        $product->discount_type = $request->discount_type;
        $product->discount_amount = $request->discount_amount;
        $product->type = $request->type;
        $product->feature = $request->feature;
        $product->description = $request->description;
        
        if (!empty($request->code)) {
            $product->code = $request->code;
        }
        else{
            $product->code = $this->generateUniqueCode();
        }

        // image save
        if ($request->image){
            $image = $request->file('image');
            $img = time().rand().'.' . $image->getClientOriginalExtension();
            $location = public_path('images/product/'. $img);
            Image::make($image)->save($location);
            $product->thumbnail_image = $img;
        }

        //Meta info
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->tags = $request->tags;
        $product->meta_description = $request->meta_description;

        $product->save();

        if($request->type == 'variation') {
            $colors = array();
            $attributes = array();
            if($request->has('variation_parent')){
                foreach($request->variation_parent as $key => $row) {
                    $variation_parent = $request->variation_parent[$key];

                    if($request->has('colour_attribute')){
                        //For colors attribute
                        $color = $request->colour_attribute[$key];
                        if(!in_array($color, $colors) && $color != '') {
                            array_push($colors, $color);
                        }
                    }
                    else {
                        $color = '';
                    }

                    if($request->has('attribute_id')){
                        //For variation attribute
                        $attribute = $request->attribute_id[$key];
                        if(!in_array($attribute, $attributes) && $attribute != '') {
                            array_push($attributes, $attribute);
                        }
                        $attribute_value = $request->attribute_value[$key];
                    }
                    else {
                        $attribute = '';
                        $attribute_value = '';
                    }

                    $stock = new ProductStocks;
                    $stock->product_id = $product->id;
                    $stock->color = $color;
                    $stock->variant = $attribute;
                    $stock->variant_output = $attribute_value;
                    $stock->price = $request->variant_price[$key];
                    $stock->qty = $request->variation_stock_qty[$key];

                    // image save
                    $img_v = 'variation_image'.$variation_parent;
                    if ($request->$img_v){
                        $image = $request->file($img_v);
                        $img = time().rand().'.' . $image->getClientOriginalExtension();
                        $location = public_path('images/product/'. $img);
                        Image::make($image)->save($location);
                        $stock->image = $img;
                    }

                    $stock->save();
                }

                $product->colors = $colors;
                $product->attributes = $attributes;
                $product->save();

            }
        }
        else {
            $stock = new ProductStocks;
            $stock->product_id = $product->id;
            $stock->price = $request->price;
            $stock->qty = $request->qty;
            $stock->save();
        }


        if(isset($request->categories)) {
            $categories = $request->categories;
            if (count($categories) > 0){
                foreach($categories as $category) {
                    $new_category = new ProductWithCategory;
                    $new_category->category_id = $category;
                    $new_category->product_id = $product->id;
                    $new_category->save();
                }
            }
        }


        // check if any gallery image then save
        if (count($request->gallery) > 0){
            $i = 0;
            foreach ($request->gallery as $gallery){
                $img = time() . $i . '.' . $gallery->getClientOriginalExtension();
                $location = public_path('images/product/'. $img);
                Image::make($gallery)->save($location);

                $gallery = new ProductImage;
                $gallery->image = $img;
                $gallery->product_id = $product->id;
                $gallery->save();
                $i = $i + 1;
            }
        }

        Alert::toast('Product Added!', 'success');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->type == 1) {
            $product = Product::find($id);
            if (!is_null($product)) {
                $categories = Category::orderBy('id', 'DESC')->get();
                $sub_categories = optional($product->category)->child;

                $brands = Brand::orderBy('id', 'DESC')->get();
                $colors = Colors::orderBy('name', 'ASC')->get();
                $variations = Variation::all();
                return view('admin.product.edit', compact('product','categories', 'colors', 'variations', 'sub_categories', 'brands'));
            }
            else{
                Alert::toast('Page Not Found !', 'error');
                return back();
            }
        }
        else{
            Alert::toast('Access Denied !', 'error');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        
        $product = Product::find($id);

        if (!is_null($product)) {

            $product->title = $request->title;
            $product->category_id = 0; //$request->category_id;
            $product->sub_category_id = 0; //$request->sub_category_id;
            $product->brand_id = $request->brand_id;
            $product->unit_type = $request->unit_type;
            $product->is_featured = isset($request->is_featured)? 1 : 0;
            $product->is_tranding = isset($request->is_tranding)? 1 : 0;
            $product->todays_deal = isset($request->todays_deal)? 1 : 0;
            $product->discount_type = $request->discount_type;
            $product->discount_amount = $request->discount_amount;
            $product->type = $request->type;
            $product->feature = $request->feature;
            $product->description = $request->description;
            

            //Meta info
            $product->meta_title = $request->meta_title;
            $product->meta_keywords = $request->meta_keywords;
            $product->tags = $request->tags;
            $product->meta_description = $request->meta_description;


            if ( !empty($request->code)) {
                $product->code = $request->code;
            }
            else{
                $product->code = $this->generateUniqueCode();
            }

            // image save
            if ($request->image){

                if (File::exists('images/product/'.$product->thumbnail_image)){
                    File::delete('images/product/'.$product->thumbnail_image);
                }

                $image = $request->file('image');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/product/'. $img);
                Image::make($image)->save($location);
                $product->thumbnail_image = $img;
            }

            $product->save();

            // check if any gallery image then save
            if ($request->has('gallery')) {
                if (count($request->gallery) > 0){
                    foreach ($product->product_image as $image) {
                        if (File::exists('images/product/'.$image->image)){
                            File::delete('images/product/'.$image->image);
                        }
                        $image->delete();
                    }
                    $i = 0;
                    foreach ($request->gallery as $gallery){
                        $img = time() . $i . '.' . $gallery->getClientOriginalExtension();
                        $location = public_path('images/product/'. $img);
                        Image::make($gallery)->save($location);

                        $gallery = new ProductImage;
                        $gallery->image = $img;
                        $gallery->product_id = $product->id;
                        $gallery->save();
                        $i = $i + 1;
                    }
                }
            }

            foreach ($product->product_category as $p_category) {
                $p_category->delete();
            }

            if(isset($request->categories)) {
                $categories = $request->categories;
                if (count($categories) > 0){
                    foreach($categories as $category) {
                        $new_category = new ProductWithCategory;
                        $new_category->category_id = $category;
                        $new_category->product_id = $product->id;
                        $new_category->save();
                    }
                }
            }

            if($request->type == 'variation') {
                $colors = array();
                $attributes = array();
                if($request->has('variation_parent')){
                    foreach($request->variation_parent as $key => $row) {
                        $new_or_old = $request->new_or_old[$key];

                        if($new_or_old == 'old') {
                            $variation_parent = $request->variation_parent[$key];
                            $stock = ProductStocks::find($variation_parent);
                            if(!is_null($stock)) {
                                if($request->is_active[$key] == 2) { // Delete variation
                                    $stock->delete();
                                }
                                else {

                                    if($request->has('colour_attribute')){
                                        //For colors attribute
                                        $color = $request->colour_attribute[$key];
                                        if(!in_array($color, $colors) && $color != '') {
                                            array_push($colors, $color);
                                        }
                                    }
                                    else {
                                        $color = '';
                                    }
                
                                    if($request->has('attribute_id')){
                                        //For variation attribute
                                        $attribute = $request->attribute_id[$key];
                                        if(!in_array($attribute, $attributes) && $attribute != '') {
                                            array_push($attributes, $attribute);
                                        }
                                        $attribute_value = $request->attribute_value[$key];
                                    }
                                    else {
                                        $attribute = '';
                                        $attribute_value = '';
                                    }
                
                                    $stock->color = $color;
                                    $stock->variant = $attribute;
                                    $stock->variant_output = $attribute_value;
                                    $stock->price = $request->variant_price[$key];
                                    $stock->qty = $request->variation_stock_qty[$key];
                                    $stock->is_active = $request->is_active[$key];
                                    
                
                                    // image save
                                    $img_v = 'variation_image'.$variation_parent;
                                    if ($request->$img_v){

                                        if (File::exists('images/product/'.$stock->image)){
                                            File::delete('images/product/'.$stock->image);
                                        }

                                        $image = $request->file($img_v);
                                        $img = time().rand().'.' . $image->getClientOriginalExtension();
                                        $location = public_path('images/product/'. $img);
                                        Image::make($image)->save($location);
                                        $stock->image = $img;
                                    }
                
                                    $stock->save();
                                }
                            }
                        }
                        else {
                            $variation_parent = $request->variation_parent[$key];
    
                            if($request->has('colour_attribute')){
                                //For colors attribute
                                $color = $request->colour_attribute[$key];
                                if(!in_array($color, $colors) && $color != '') {
                                    array_push($colors, $color);
                                }
                            }
                            else {
                                $color = '';
                            }
        
                            if($request->has('attribute_id')){
                                //For variation attribute
                                $attribute = $request->attribute_id[$key];
                                if(!in_array($attribute, $attributes) && $attribute != '') {
                                    array_push($attributes, $attribute);
                                }
                                $attribute_value = $request->attribute_value[$key];
                            }
                            else {
                                $attribute = '';
                                $attribute_value = '';
                            }
        
                            $stock = new ProductStocks;
                            $stock->product_id = $product->id;
                            $stock->color = $color;
                            $stock->variant = $attribute;
                            $stock->variant_output = $attribute_value;
                            $stock->price = $request->variant_price[$key];
                            $stock->qty = $request->variation_stock_qty[$key];
        
                            // image save
                            $img_v = 'variation_image'.$variation_parent;
                            if ($request->$img_v){
                                $image = $request->file($img_v);
                                $img = time().rand().'.' . $image->getClientOriginalExtension();
                                $location = public_path('images/product/'. $img);
                                Image::make($image)->save($location);
                                $stock->image = $img;
                            }
        
                            $stock->save();
                        }


                        
                    }
    
                    $product->colors = $colors;
                    $product->attributes = $attributes;
                    $product->save();
    
                }
            }
            else {

                if(count($product->variation_stock) > 0) {
                    foreach($product->variation_stock as $v_stock) {
                        if (File::exists('images/product/'.$v_stock->image)){
                            File::delete('images/product/'.$v_stock->image);
                        }
                        $v_stock->delete();
                    }
                }

                $stock = $product->single_stock;
                if(!is_null($stock)) {
                    $stock->price = $request->single_price;
                    $stock->qty = $request->single_qty;
                    $stock->save();
                }
                else {
                    $stock = new ProductStocks;
                    $stock->product_id = $product->id;
                    $stock->price = $request->single_price;
                    $stock->qty = $request->single_qty;
                    $stock->save();
                }
            }

            Alert::toast('Product Updated!', 'success');
            return redirect()->route('product.index');
        }
        else{
            Alert::toast('Something went wrong!', 'error');
            return redirect()->route('product.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!is_null($product)) {
            // Deleting the gallery files
            foreach ($product->product_image as $image) {
                if (File::exists('images/product/'.$image->image)){
                    File::delete('images/product/'.$image->image);
                }
                $image->delete();
            }
            // Deleting the product image
            if (File::exists('images/product/'.$product->thumbnail_image)){
                File::delete('images/product/'.$product->thumbnail_image);
            }

            // Deleting the variations 
            if(count($product->variation_stock) > 0) {
                foreach($product->variation_stock as $v_stock) {
                    if (File::exists('images/product/'.$v_stock->image)){
                        File::delete('images/product/'.$v_stock->image);
                    }
                    $v_stock->delete();
                }
            }

            $product->delete();
            Alert::toast('Product has been deleted !', 'success');
            return back();
        }
        else {
            session()->flash('error','Something went wrong !');
            return back();
        }
    }

    public function color_index() {

        if (Auth::user()->type == 1) {
            $colors = Colors::orderBy('name', 'ASC')->get();
            return view('admin.color.index', compact('colors'));
        }
        else{
            Alert::toast('Access Denied !', 'error');
            return back();
        }
    }

    public function color_store(Request $request) {
        $code = $request->code;
        $name = $request->name;

        $check_color = Colors::where('name', $name)->orWhere('code', $code)->first();
        if(!is_null($check_color)) {
            Alert::toast('This name or Color is exist!', 'error');
            return back();
        }

        $color = new Colors;
        $color->name = $name;
        $color->code = $code;
        $color->save();

        Alert::toast('New Color Added.', 'success');
        return back();
        
    }

    public function color_edit($id)
    {
        if (Auth::user()->type == 1) {
            $color = Colors::find($id);
            if (!is_null($color)) {
                return view('admin.color.edit', compact('color'));
            }
            else {
                session()->flash('error','Something went wrong !');
                return back();
            }
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function color_update(Request $request, $id) {
        $code = $request->code;
        $name = $request->name;

        $color = Colors::find($id);
        $color->name = $name;
        $color->code = $code;
        $color->save();

        Alert::toast('Color Updated.', 'success');
        return Redirect()->route('color.index');
        
    }

    public function product_stock() {
        if (Auth::user()->type == 1) {
            $stock_info = ProductStocks::all();
            return view('admin.product.product_stock', compact('stock_info'));
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }

    public function stock_qty_update(Request $request) {
        if (Auth::user()->type == 1) {
            $stock_id = $request->stock_id;
            $stock_info = ProductStocks::find($stock_id);
            if(is_null($stock_info)) {
                session()->flash('error','Product Stock Info not Found!');
                return back();
            }
            $stock_info->qty = ($request->stock_qty) + 0;
            $stock_info->save();
            return back()->with('success', 'Product Stock Quantity Updated.');
        }
        else {
            session()->flash('error','Access Denied !');
            return back();
        }
    }



}
