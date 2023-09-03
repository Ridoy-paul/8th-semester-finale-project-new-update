<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\District;
use Illuminate\Support\Str;
use Cart;
use Auth;
use Alert;
use Carbon\Carbon;
use Session;
use App\Models\ProductStocks;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index()
    {
    	$carts = Cart::content();
        return view('user.pages.cart', compact('carts'));
        //return view('pages.cart', compact('carts'));
    }

    public function add_cart(Request $request)
    {
    	$product_id = $request->product_id;
        $type = $request->product_type;
        $qty = $request->cart_qty_input;
        $variation_id = 0;
        $stock_qty = 0;
        $add_stock_status = 0;
        $price = 0;
        $old_price = 0;

        $product = Product::find($product_id);

        $carts = Cart::content();

        if(!is_null($product)) {
            if($type == 'variation') {
                if(!empty($request->selected_variation_id)) {
                    $variation_id = $request->selected_variation_id;
                    $stock_info = ProductStocks::find($variation_id);
                    if(!is_null($stock_info)) {
                        $stock_qty = $stock_info->qty;
                    }
                    else {
                        $output = [
                            'status' => 'no',
                            'reason' => 'No Variation Found!',
                        ];
                        return Response($output);
                    }
                }
                else {
                    $output = [
                        'status' => 'no',
                        'reason' => 'Please select variation!',
                    ];
                    return Response($output);
                }
            }
            else {
                $stock_info = $product->single_stock;
                if(!is_null($stock_info)) {
                    $stock_qty = $stock_info->qty;
                }
                else {
                    $output = [
                        'status' => 'no',
                        'reason' => 'No Stock Found!',
                    ];
                    return Response($output);
                }
            }

            $carts = Cart::content();

            //return $carts;

            if($qty == '') { $qty = 1; }

            $product_unique_id = $product_id."_".$variation_id;

            if(count($carts) > 0) {
                foreach ($carts as $cart) {
                    if($cart->id == $product_unique_id && $cart->weight == $variation_id) {

                        $add_stock_status = 0;

                        $current_cart_stock = $cart->qty;
                        $update_cart_stock = $current_cart_stock + $qty;
                        if($stock_qty >= $update_cart_stock) {
                            Cart::update($cart->rowId, $update_cart_stock);
                            Session::forget('coupon_discount');
                            $output = [
                                'status' => 'yes',
                                'reason' => 'Cart Updated.',
                            ];
                            return Response($output);
                        }
                        else {
                            $output = [
                                'status' => 'no',
                                'reason' => 'Stock quantity is over!',
                            ];
                            return Response($output);
                        }
                        
                    }
                    else {
                        $add_stock_status = 1;
                    }
                }
            }
            else {
                $add_stock_status = 1;
            }
           
            if($add_stock_status == 1) {
                if($stock_qty >= $qty) {
                    $price = $stock_info->price;
                    $subtotal_price = $price * $qty;
                    if($product->discount_type <> 'no') {
                        if($product->discount_type == 'flat') {
                            $old_price = $stock_info->price + optional($product)->discount_amount;
                        }
                        else if($product->discount_type == 'percentage') {
                            $discount_amount_tk = (optional($product)->discount_amount * $stock_info->price)/100;
                            $old_price =  $stock_info->price + $discount_amount_tk;
                        }
                    }

                    Cart::add([
                        'id' => $product_unique_id,
                        'qty' => $qty,
                        'price' => $subtotal_price,
                        'name' => $product->title,
                        'weight' => $variation_id,
                        'options' => [
                            'product_id' => $product_id,
                            'single_price' => $price,
                            'old_price' => $old_price,
                        ],
                    ]);
                    Session::forget('coupon_discount');
                    $output = [ 'status' => 'yes', 'reason' => 'Added to cart.'];
                    return Response($output);
                }
                else {
                    $output = [ 'status' => 'no', 'reason' => 'Stock quantity is over!'];
                    return Response($output);
                }
            }

        }

    	// if (!is_null($product)) {
            
		// 	Cart::add([
	    //         'id' => $product->id,
	    //         'qty' => 1,
	    //         'price' => ($product->is_sale == 1 ? ($product->discount_price != NULL ? $product->discount_price : $product->price) : $product->price),
	    //         'name' => $product->title,
	    //         'weight' => 500,
	    //         'options' => [
	    //             'image' => $product->image
	    //         ],
	    //     ]);
    	// }

        //$cart_sidebar = $this->generate_cart();
        
        //return ['total_count' => Cart::count(), 'total_amount' => env('CURRENCY').Cart::subtotal(), 'cart_sidebar' => $cart_sidebar];
    }

    public function ajax_load_cart_data() {
        $carts = Cart::content();
        $total = 0;
        $cart_sidebar = '';
        $cart_count = 0;

        $cart_sidebar .= '<div class="minicart__product">';

                        if(count($carts) > 0) {
                            foreach($carts as $cart) {
                                $product_info = Product::find($cart->options->product_id);
                                if(!is_null($product_info)) {
                                    $cart_count++;
                                    $variation_info = '';
                                    if($cart->weight != 0) {
                                        $stock_info = ProductStocks::find($cart->weight);
                                        
                                        if($stock_info->color <> null){
                                            $color_attribute_info = color_info($stock_info->color);
                                            $color_info = '<b>Color: </b>'.optional($color_attribute_info)->name.', ';
                                        }
                                        else {
                                            $color_info = '';
                                        }

                                        if($stock_info->variant <> null){
                                            $variant_attribute_info = variation_info($stock_info->variant);
                                            $attribute_info = '<b>'.optional($variant_attribute_info)->title.': </b>'.optional($stock_info)->variant_output.'';
                                        }
                                        else {
                                            $attribute_info = '';
                                        }
                                        $variation_info = $color_info.$attribute_info;
                                    }
                                    else {
                                        $stock_info = $product_info->single_stock;
                                    }

                                    $price_info = '<span class="current__price">৳'.number_format(optional($cart->options)->single_price, 2).'</span>';

                                    if(optional($cart->options)->old_price > 0) {
                                        $price_info .= ' <span class="old__price">৳'.number_format(optional($cart->options)->old_price, 2).'</span>';
                                    }
                                    
                                    $cart_sidebar .= '<div class="minicart__product--items d-flex">
                                            <div class="minicart__thumb">
                                                <a href="'.route('single.product', [$product_info->id, Str::slug($product_info->title)]).'"><img style="height: 135px !important;" class="shadow rounded p-1" src="'.asset('images/product/' .optional($product_info)->thumbnail_image).'" alt="prduct-img"></a>
                                            </div>
                                            <div class="minicart__text">
                                                <h3 class="minicart__subtitle h4"><a href="'.route('single.product', [$product_info->id, Str::slug($product_info->title)]).'">'.$product_info->title.'</a></h3>
                                                <small class="color__variant">'.$variation_info.'</small>
                                                
                                                <div class="minicart__price">
                                                    '.$price_info.'
                                                </div>
                                                
                                                <div class="minicart__text--footer d-flex align-items-center">
                                                    <div class="quantity__box minicart__quantity">
                                                        <div class="quantity__box minicart__quantity">
                                                            <button type="button" class="quantity__value decrease side_cart_qty_decrease" onclick="change_cart_qty(\'down\', \''.$cart->rowId.'\', \'side_cart\')" aria-label="quantity value" value="Decrease Value">-</button>
                                                            <label>
                                                                <input type="number" readonly class="quantity__number side_cart_qty_'.$cart->rowId.'" min="1" value="'.$cart->qty.'" data-counter="">
                                                            </label>
                                                            <button type="button" onclick="change_cart_qty(\'up\', \''.$cart->rowId.'\', \'side_cart\')" class="quantity__value increase side_cart_qty_increase" value="Increase Value">+</button>
                                                        </div>
                                                    </div>
                                                    <form action="'.route('cart.remove').'" method="POST">
                                                    '.csrf_field().'
                                                        <input type="hidden" name="rowId" value="' .$cart->rowId. '">
                                                        <button type="submit" class="minicart__product--remove">Remove</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>';
                                }
                                else {
                                    Cart::remove($cart->rowId);
                                    
                                }
                                
                            }

                        }
                        else {
                            $cart_sidebar .= '<div class="minicart__product--items text-center">
                                <span class="--toolbar__icon mt-4"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" viewBox="0 0 18.51 15.443">
                                    <path  d="M79.963,138.379l-13.358,0-.56-1.927a.871.871,0,0,0-.6-.592l-1.961-.529a.91.91,0,0,0-.226-.03.864.864,0,0,0-.226,1.7l1.491.4,3.026,10.919a1.277,1.277,0,1,0,1.844,1.144.358.358,0,0,0,0-.049h6.163c0,.017,0,.034,0,.049a1.277,1.277,0,1,0,1.434-1.267c-1.531-.247-7.783-.55-7.783-.55l-.205-.8h7.8a.9.9,0,0,0,.863-.651l1.688-5.943h.62a.936.936,0,1,0,0-1.872Zm-9.934,6.474H68.568c-.04,0-.1.008-.125-.085-.034-.118-.082-.283-.082-.283l-1.146-4.037a.061.061,0,0,1,.011-.057.064.064,0,0,1,.053-.025h1.777a.064.064,0,0,1,.063.051l.969,4.34,0,.013a.058.058,0,0,1,0,.019A.063.063,0,0,1,70.03,144.853Zm3.731-4.41-.789,4.359a.066.066,0,0,1-.063.051h-1.1a.064.064,0,0,1-.063-.051l-.789-4.357a.064.064,0,0,1,.013-.055.07.07,0,0,1,.051-.025H73.7a.06.06,0,0,1,.051.025A.064.064,0,0,1,73.76,140.443Zm3.737,0L76.26,144.8a.068.068,0,0,1-.063.049H74.684a.063.063,0,0,1-.051-.025.064.064,0,0,1-.013-.055l.973-4.357a.066.066,0,0,1,.063-.051h1.777a.071.071,0,0,1,.053.025A.076.076,0,0,1,77.5,140.448Z" transform="translate(-62.393 -135.3)" fill="currentColor"/>
                                    </svg> 
                                </span> 
                                <h3 class="py-1 px-2 mb-3"><b>Your cart is empty.</b><h3>
                                <a class="primary__btn minicart__button--link rounded-pill" href="'.route('products').'">Start Shopping</a>
                            </div>';
                        }
                            
                            $cart_sidebar .= '</div>
                                                <div class="minicart__amount">
                                                    <div class="minicart__amount_list d-flex justify-content-between">
                                                        <span>Sub Total:</span>
                                                        <span><b id="side_cart_subtotal">৳ '.number_format(Cart::subtotal(), 2).'</b></span>
                                                    </div>
                                                </div>';

                            
                        

        //return $cart_sidebar;

        return Response()->json([
            'cart_sidebar'=>$cart_sidebar,
            'cart_count' => $cart_count,
        ]);


    }

    
    public function generate_cart()
    {
        $carts = Cart::content();
        $total = 0;
        $cart_sidebar = '';
        foreach ($carts as $cart){
            
            $total += $cart->price * $cart->qty;

            $cart_sidebar .= '<div class="product product-cart">
                                <div class="product-detail">
                                    <a href="' .route('single.product', [$cart->id, Str::slug($cart->name)]) .'" class="product-name">'. $cart->name .'</a>
                                    <div class="price-box">
                                        <span class="product-quantity">' .$cart->qty. '</span>
                                        <span class="product-price">' .env('CURRENCY').$cart->price. env('UAE_CURRENCY') . '</span>
                                    </div>
                                </div>
                                <figure class="product-media">
                                    <a href="' .route('single.product', [$cart->id, Str::slug($cart->name)]). '">
                                        <img src="' .asset('images/product/' . $cart->options->image). '" alt="product" height="84"
                                            width="94" />
                                    </a>
                                </figure>
                                <form action="' .route('cart.remove'). '" method="POST">
                                    ' .csrf_field(). '
                                    <input type="hidden" name="rowId" value="' .$cart->rowId. '">
                                    <button type="submit" class="btn btn-link btn-close"><i
                                        class="fas fa-times"></i></button>
                                </form>
                            </div>';
            
        }
        return $cart_sidebar;
    }

    public function show_cart()
    {
        $carts = Cart::content();
        return view('shopping-cart', compact('carts'));
        //dd($carts);
    }

    public function update_cart(Request $request)
    {
        $carts = Cart::content();
        $output = '';
        $row_id = $request->row_id;
        $qty_up_or_down = $request->up_or_down;
        $status = '';
        $reason = '';
        $current_qty = 0;

        if(count($carts) > 0) {
            foreach ($carts as $cart) {
                if($cart->rowId == $row_id) {
                    $current_cart_stock = $cart->qty;
                    $product_info = Product::where('id', optional($cart->options)->product_id)->first();
                    if($cart->weight != 0) {
                        $stock_info = ProductStocks::find($cart->weight);
                    }
                    else {
                        $stock_info = $product_info->single_stock;
                    }

                    if($qty_up_or_down == 'up') {
                        if(optional($stock_info)->qty > $current_cart_stock) {
                            $current_cart_stock++;
                            Cart::update($cart->rowId, $current_cart_stock);
                            Session::forget('coupon_discount');
                            $status = 'yes';
                            $reason = 'Stock quantity Updated.';
                        }
                        else {
                            $status = 'no';
                            $reason = 'Stock quantity is over!';
                        }
                    }
                    else {
                        if($current_cart_stock > 1) {
                            $current_cart_stock--;
                            Cart::update($cart->rowId, $current_cart_stock);
                            
                            $status = 'yes';
                            $reason = 'Stock quantity Updated.';
                        }
                        else {
                            $status = 'no';
                            $reason = 'Minimum quantity is 1.';
                        }
                    }

                    $current_qty = $current_cart_stock;
                    break;
                }
            }
        }
        else {
            $status = 'no';
            $reason = 'Cart is Empty, Please Reload Page!';
        }

        $output = [
            'status' => $status,
            'reason' => $reason,
            'cart_qty'=>$current_qty,
            'cart_subtotal'=>number_format(Cart::subtotal(), 2),
        ];
        return Response($output);
    }

    public function remove_cart(Request $request)
    {
        Cart::remove($request->rowId);
        \Artisan::call('view:clear');
        Session::forget('coupon_discount');
        return back();
    }

    public function check_discount()
    {
        $discount = Discount::where('is_active', 1)->first();
        $sale = false;
        if (!is_null($discount)) {
            $discount_from = Carbon::createFromFormat('Y-m-d H:i:s', $discount->from.' 00:00:00');
            $discount_to = Carbon::createFromFormat('Y-m-d H:i:s', $discount->to.' 23:59:59');
            if (($discount_from->isPast()) && !($discount_to->isPast())) {
                $sale = true;
            }
            else {
                $sale = false;
            }
        }
        else {
            $sale = false;
        }
        return $sale;
    }


    public function apply_coupon(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $code = $request->code;

        $coupon = Coupon::where('code', $code)->orderBy('id', 'DESC')->first();
        if (!is_null($coupon)) {
            $valid_to = Carbon::createFromFormat('Y-m-d H:i:s', $coupon->valid_to.' 23:59:59');
            if ($valid_to->isPast()) {
                session()->flash('invalid','Invalid Coupon');
                return back();
            }
            else {
                $discount = 0;
                if ($coupon->discount == NULL) {
                    $discount = $coupon->amount;
                }
                if ($coupon->amount == NULL) {
                    $discount = ($coupon->discount/100) * Cart::subtotal();
                }
                Session::forget('coupon_discount');
                if ($discount > Cart::subtotal()) {
                    session(['coupon_discount' => Cart::subtotal()]);
                }
                else {
                    session(['coupon_discount' => $discount]);
                }
                if ($coupon->single_use == 1) {
                    session(['coupon_single_use' => $coupon->single_use]);
                }
                session()->flash('coupon_success','Coupon Applied');
                return back();
            }
            
        }
        else {
            Session::forget('coupon_discount');
            session()->flash('invalid','Invalid Coupon');
            return back();
        }
    }

    public function remove_coupon()
    {
        Session::forget('coupon_discount');
        return back();
    }

    public function checkout()
    {
        $carts = Cart::content();
        if(count($carts) > 0) {
            $districts = District::orderBy('name', 'ASC')->get();
            return view('user.pages.checkout', compact('carts', 'districts'));
        }
        else {
            return Redirect()->back()->with('error', 'Your Cart is Empty!');
        }
    }
}
