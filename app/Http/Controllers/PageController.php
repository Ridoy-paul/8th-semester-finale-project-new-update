<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Variation;
use App\Models\VariationProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Wallet;
use App\Models\WalletEntry;
use App\Models\Payment;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ProductStocks;
use App\Models\Setting;
use App\Models\District;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\AboutUs;

use Cart;
use Auth;
use Carbon\Carbon;
use PDF;
use File;
use Image;
use Alert;
use Mail;
use App\Mail\OrderMail;
use App\Mail\ContactMail;
use App\Models\Blog;
use App\Models\FlashSaleOffer;
use App\Models\FlashSaleOfferProducts;
use App\Models\ProductsReviews;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        
        //$products = Product::where('is_active', 1)->orderBy('id', 'DESC')->limit(8)->get();
        //$random_products = Product::where('is_active', 1)->inRandomOrder()->limit(8)->get();
        //$deals = Product::where('is_active', 1)->inRandomOrder()->limit(2)->get();
        //$categories = Category::where('is_active', 1)->where('is_featured', 1)->orderBy('position', 'ASC')->get();
        
        //$top_sales = Product::where('is_active', 1)->orderBy('sold_qty', 'DESC')->limit(3)->get();

        $sliders = Slider::where('is_active', 1)->orderBy('serial_number', 'ASC')->get();
        $featured_categories = Category::where('is_featured', 1)->orderBy('position', 'ASC')->limit(6)->get(['id', 'title', 'image']);
        //$todays_deals = Product::where(['is_active'=>1, 'todays_deal'=>1])->inRandomOrder()->limit(10)->get(['id', 'discount_type', 'discount_amount', 'type', 'title', 'thumbnail_image']);
        //$featured_products = Product::where(['is_active'=>1, 'is_featured'=>1])->inRandomOrder()->limit(10)->get(['id', 'discount_type', 'discount_amount', 'type', 'title', 'thumbnail_image']);
        $trending_products = Product::where(['is_active'=>1, 'is_tranding'=>1])->inRandomOrder()->limit(10)->get(['id', 'discount_type', 'discount_amount', 'type', 'title', 'thumbnail_image']);
        //$featured_brands = Brand::where(['is_featured'=>1])->orderBy('position', 'ASC')->get();
        $blogs = Blog::orderBy('id', 'DESC')->limit(4)->get(['id', 'title', 'image', 'created_at']);
        return view('user.index', compact('trending_products', 'featured_categories', 'sliders', 'blogs'));
        //return view('pages.index', compact('products', 'categories', 'featured_categories', 'deals', 'random_products', 'sliders', 'page', 'top_sales'));
        
    }

    public function products(Request $request)
    {
        $min_price = ProductStocks::min('price');
        $max_price = ProductStocks::max('price');
        $request_category = $request->category_id;
        $request_brand = $request->brand_id;
        
        $categories = Category::where('parent_id', 0)->orderBy('position', 'ASC')->get();
        $brands = Brand::orderBy('position', 'ASC')->get();
        
        return view('user.pages.shop', compact('categories', 'brands', 'request_category', 'request_brand', 'min_price', 'max_price'));
    }

    public function shop_products_data(Request $request) {
        //return "hello";

        $lastID = $request->lastID;
        $brand_array = $request->brand_array;
        $category_id = $request->category_id;
        
        $updatedlastID = 0;
        $output = '';

        if(empty($category_id) && empty($brand_array)) {// nothing is active
            $products = Product::where('is_active', 1)->where('id', '<', $lastID)->orderBy('id', 'DESC')->limit(20)->get(['id', 'discount_type', 'discount_amount', 'type', 'title', 'thumbnail_image']);
        }
        else if(!empty($category_id) && empty($brand_info)) { //only category is active.
            
            $category_info = Category::find($category_id);
            $categories_id = array($category_id);
            if(count($category_info->child) > 0) {
                foreach($category_info->child as $sub_category) {
                    if(count(optional($sub_category)->child) > 0) {
                        foreach($sub_category->child as $sub_sub_category) {
                            array_push($categories_id, optional($sub_sub_category)->id);
                        }
                    }
                    else {
                        array_push($categories_id, optional($sub_category)->id);
                    }
                }
            }

            $products = Product::join('product_with_categories', 'product_with_categories.product_id', '=', 'products.id')
                    ->where('products.is_active', 1)
                    ->whereIn('product_with_categories.category_id', $categories_id)->where('product_with_categories.id', '<', $lastID)->orderBy('product_with_categories.id', 'DESC')->limit(20)
              		->get(['products.id', 'products.discount_type', 'products.discount_amount', 'products.type', 'products.title', 'products.thumbnail_image', 'product_with_categories.category_id', 'product_with_categories.product_id']);


            //$products = Product::where('is_active', 1)->whereIn('category_id', $categories_id)->where('id', '<', $lastID)->orderBy('id', 'DESC')->limit(20)->get();
        }
        else if(!empty($category_id) && !empty($brand_info)) { // category & brand both is active.
            $category_info = Category::find($category_id);
            $categories_id = array($category_id);
            if(count($category_info->child) > 0) {
                foreach($category_info->child as $sub_category) {
                    if(count(optional($sub_category)->child) > 0) {
                        foreach($sub_category->child as $sub_sub_category) {
                            array_push($categories_id, optional($sub_sub_category)->id);
                        }
                    }
                    else {
                        array_push($categories_id, optional($sub_category)->id);
                    }
                }
            }
            $products = Product::where('is_active', 1)->whereIn('category_id', $categories_id)->whereIn('brand_id', [$brand_array])->where('id', '<', $lastID)->orderBy('id', 'DESC')->limit(20)->get();
        }
        else if(empty($category_id) && !empty($brand_array)) { //Brand is active.
            $products = Product::where('is_active', 1)->whereIn('brand_id', [$brand_array])->where('id', '<', $lastID)->orderBy('id', 'DESC')->limit(20)->get();
        }
        
        if(count($products) > 0) {
            $noMorePSts = 'no';
            
            foreach($products as $product) {
                $output .= view('user.partials.product', compact('product'));
                $updatedlastID = $product->id;
            }
        }
        else {
            $noMorePSts = 'yes';
            $output .= '<div class="col-md-12 col my-5" id="load_more" style="width: 100% !important;">
                            <div style="text-align: center;" class="text-center"><h2><b>Sorry, No Products Found</b></h2></div>
                        </div>';
        }

        $res = [
            'output' => $output,
            'upLastID' => $updatedlastID,
            'noMorePSts' => $noMorePSts,
        ];
        return response()->json($res);
    }

    public function shop_products($slug)
    {
        $products = Product::where('is_active', 1)->orderBy('id', 'DESC')->select(['id', 'discount_type', 'type', 'title', 'thumbnail_image']);
        if($slug == 'best-selling') {
            $products = $products->orderBy('sold_qty', 'DESC');
        }
        else if($slug == 'featured') {
            $products = $products->where('is_featured', 1);
        }
        else if($slug == 'traending-now') {
            $products = $products->where('is_tranding', 1);
        }

        $products = $products->paginate(15);
        return view('user.pages.group_wise_products', compact('products', 'slug'));
    }


    public function offer_products()
    {
        $products = Product::where('is_active', 1)->where('is_sale', 1)->orderBy('id', 'DESC')->get();
        $page = Page::find(7);
        return view('pages.offer-products', compact('products', 'page'));
    }

    public function single_product($id, $slug)
    {
        $product = Product::find($id);
        if (!is_null($product)) {
            $similar_products = Product::where('category_id', $product->category_id)->where('id', '<>', $product->id)->inRandomOrder()->limit(10)->get();
            // return view('pages.single-product', compact('product', 'similar_products'));
            return view('user.pages.single-product', compact('product', 'similar_products'));
        }
        else{
            session()->flash('error','Page Not Found');
            return back();
        }
    }

    public function product_quick_view(Request $request) {
        $id = $request->pruduct_id;
        $product = Product::find($id);
        $output = '';
        $output .= view('user.partials.popup_proudcts_details', compact('product'))->render();
        return Response()->json($output);
        
    }

    public function product_variation_check(Request $request) {
        //return $request;
        $color_info = $request->color_info;
        $color_id = $request->color;
        $attribute_variation = $request->attribute_variation;
        $product_id = $request->product_id;
        $color_dependent_variation = '';
        $color_dependent_variation_status = 0;
        $image = '';
        $image_status = 0;
        $variation_status = 0;
        $price_info = '';

        $info = ProductStocks::where('id', $attribute_variation)->where('product_id', $product_id);

        if($color_info == 1) {
            $info = $info->where('color', $color_id);
        }

        $info = $info->where('is_active', 1);
        $info = $info->first();

        if(is_null($info) && $color_info == 1) {
            $color_dependent_variation_status = 1;
            $color_variation_info = ProductStocks::where('color', $color_id)->where('product_id', $product_id)->where('is_active', 1)->get();
            if(count($color_variation_info) > 0) {
                foreach($color_variation_info as $variation) {
                    $color_dependent_variation .= '<input id="attribute_id_'.$variation->id.'" onchange="select_variation('.$product_id.')" value="'.$variation->id.'" name="attribute_variation" type="radio" ><label class="variant__size--value" for="attribute_id_'.$variation->id.'">'.$variation->variant_output.'</label>';
                }
            }
            else {
                $color_dependent_variation .= '';
            }
        }

        $product_info = Product::where('id', $product_id)->first(['unit_type', 'discount_type', 'discount_amount']);

        if(!is_null($info)) {
            $variation_status = 1;

            $price_info .= '<span class="current__price">৳ '.number_format($info->price, 2).'</span>';

            if($product_info->discount_type <> 'no') {
                if($product_info->discount_type == 'flat') {
                    $old_price = $info->price + optional($product_info)->discount_amount;
                }
                else if($product_info->discount_type == 'percentage') {
                    $discount_amount_tk = (optional($product_info)->discount_amount * $info->price)/100;
                    $old_price =  $info->price + $discount_amount_tk;
                }
                $price_info .= '<span class="price__divided"></span><span class="old__price">৳ '.number_format($old_price, 2).'</span>';
            }
            
            
        
        }

        
        return response()->json([
            'color_dependent_variation'=>$color_dependent_variation,
            'color_dependent_variation_status'=>$color_dependent_variation_status,
            'id'=>optional($info)->id,
            'price'=>optional($info)->price,
            'qty'=>optional($info)->qty,
            'image_status'=>$image_status,
            'image'=>$image,
            'variation_status'=>$variation_status,
            'id'=>optional($info)->id,
            'unit_type'=>optional($product_info)->unit_type,
            'price_info'=>$price_info,
        ]);

    }

    public function categories()
    {
        $categories = Category::where('is_active', 1)->where('parent_id', 0)->orderBy('position', 'ASC')->get();
        return view('pages.categories', compact('categories'));
    }

    public function category_products($id, $slug)
    {
        $category = Category::find($id);
        $products = Product::where('category_id', $id)->orWhere('sub_category_id', $id)->where('is_active', 1)->paginate(30);
        if (!is_null($category)) {
            return view('pages.category-product', compact('category', 'products'));
        }
        else{
            session()->flash('error','Page Not Found');
            return back();
        }
    }

    public function brand_products($id, $slug)
    {
        $brand = Brand::find($id);
        $products = Product::where('brand_id', $id)->where('is_active', 1)->paginate(30);
        if (!is_null($brand)) {
            return view('pages.brand-product', compact('brand', 'products'));
        }
        else{
            session()->flash('error','Page Not Found');
            return back();
        }
    }

    public function search(Request $request)
    {
          $query = $request->get('search');
          $filterResult = Product::where('title', 'LIKE', '%'. $query. '%')
          ->orWhere('description', 'LIKE', '%'. $query. '%')
          ->where('is_active', 1)
          ->pluck('title');
          // $filterResult = Product::where('title', 'LIKE', '%'. $query. '%')
          // ->orWhere('description', 'LIKE', '%'. $query. '%')
          // ->where('is_active', 1)
          // ->get();
          return $filterResult;
    } 

    public function ajax_product_search(Request $request)
    {
        $input = $request->input;
        $category_id = $request->category_id;
        $output = '';
        if($category_id == 'all') {
            $products = Product::where('title', 'LIKE', '%'. $input. '%')->orWhere('description', 'LIKE', '%'. $input. '%')->limit(10)->get(['id', 'title', 'thumbnail_image']);
        }
        else {
            $products = Product::where('category_id', $category_id)
                                ->where(function ($query) use ($input) {
                                    $query->where('title', 'LIKE', '%'. $input. '%')
                                        ->orWhere('description', 'LIKE', '%'. $input. '%');
                                })
                                ->limit(10)->get(['id', 'title', 'thumbnail_image']);
        }
        
        if($input <> '') {
            if(count($products) > 0) {
                foreach($products as $product) {
                    $output .= '<div class="col-md-12">
                                    <div class="shadow border m-2 rounded">
                                        <a class="widget__categories--sub__menu--link d-flex align-items-center" href="'.route('single.product', [$product->id, Str::slug($product->title)]).'">
                                            <img style="width: 7.8rem !important;" class="widget__categories--sub__menu--img p-1 rounded" src="'.asset('images/product/'.$product->thumbnail_image).'" alt="categories-img">
                                            <span class="widget__categories--sub__menu--text">'.$product->title.'</span>
                                        </a>
                                    </div>
                                </div>';
                }
            }
            else {
                $output .= '<div class="col-md-12">
                                <div class="m-2 rounded text-center">
                                    <h2 class="py-3 text-center">No Products Found!!!</h2>
                                    <a class="continue__shipping--btn primary__btn rounded-pill mb-3" href="'.route('products').'">View Shop</a>
                                </div>
                            </div>';
            }
        }
        else {

        }

        return Response()->json($output);
    }

    public function ajax_featured_products() {
        $output = '';
        $featured_products = Product::where(['is_active'=>1, 'is_featured'=>1])->inRandomOrder()->limit(10)->get();
        $view = view('user.partials.featured_products', compact('featured_products'))->render();
        return Response()->json($view);
    }

    public function ajax_best_selling_products() {
        $output = '';
        $best_selling_products = Product::where(['is_active'=>1])->orderBy('sold_qty', 'DESC')->limit(10)->get();
        $view = view('user.partials.ajax_best_selling_products', compact('best_selling_products'))->render();
        return Response()->json($view);
    }

    public function ajax_flash_sale_offer() {
        $flash_sale_offer = FlashSaleOffer::where(['is_active'=>1])->first();
        $view = view('user.partials.home_page_flash_sale', compact('flash_sale_offer'))->render();
        return Response()->json($view);
    }

    public function ajax_flash_sale_offer_details($id, $slug) {
        $flash_sale_offer = FlashSaleOffer::find($id);
        if(is_null($flash_sale_offer)) {
            return Redirect()->back()->with('error', 'No Offer Found!');
        }

        $products = FlashSaleOfferProducts::where('flash_sale_id', $flash_sale_offer->id)->paginate(15);
        return view('user.pages.flash_sale_offer', compact('flash_sale_offer', 'products'));

    }

    

    public function search_result(Request $request)
    {
        $query = $request->search;
        $products = Product::where('title', 'LIKE', '%'. $query. '%')->orWhere('description', 'LIKE', '%'. $query. '%')->get();
        return view('pages.search-result', compact('products'));

    }

    public function product_filter(Request $request)
    {
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        if ($category_id != 'all' && $brand_id != 'all') {
            $products = Product::where('category_id', $category_id)->where('brand_id', $brand_id)->whereBetween('price', [$min_price, $max_price])->where('is_active', 1)->get();
        }
        else if ($category_id != 'all' && $brand_id == 'all') {
            $products = Product::where('category_id', $category_id)->whereBetween('price', [$min_price, $max_price])->where('is_active', 1)->get();
        }
        else if ($category_id == 'all' && $brand_id != 'all') {
            $products = Product::where('brand_id', $brand_id)->whereBetween('price', [$min_price, $max_price])->where('is_active', 1)->get();
        }
        else{
            $products = Product::where('is_active', 1)->whereBetween('price', [$min_price, $max_price])->get();
        }

        $product_filtered = '';

        foreach ($products as $product) {
            $product_filtered .= '
                <div class="product-wrap product text-center" style="">
                    <div style="border: 1px solid blue;padding-bottom: 15px;margin: 0px 5px;">
                    <figure class="product-media">
                        <a href="'. route('single.product', [$product->id, Str::slug($product->title)]) .'">
                            <img src="'. asset('images/product/'. $product->image) .'" alt="Product"
                                width="216" height="243" />
                        </a>
                        <div class="product-action-vertical">
                            <a onclick="addToCart('. $product->id .')" class="btn-product-icon w-icon-cart peoduct_cart"
                                title="Add to cart"></a>
                            <a onclick="addToWishlist('. $product->id .')" class="btn-product-icon w-icon-heart peoduct_cart"
                                title="Add to wishlist"></a>
                            
                        </div>
                    </figure>
                    <div class="product-details">
                        <h4 class="product-name"><a href="'. route('single.product', [$product->id, Str::slug($product->title)]) .'">'. $product->title .'</a>
                        </h4>
                        <p>'. $product->weight . $product->unit.'</p>
                        <div class="product-price">';
                            if($product->type == 'single'){
                                if ($product->is_sale == 1) {
                                    $product_filtered .= '<ins class="new-price">'. env('CURRENCY') .  $product->discount_price . env('UAE_CURRENCY') .'</ins><del class="old-price">'. env('CURRENCY') . $product->price . env('UAE_CURRENCY') .'</del>';
                                }
                                else{
                                    $product_filtered .= '<ins class="new-price">'. env('CURRENCY') .  $product->price . env('UAE_CURRENCY') .'</ins>';
                                }
                            }
                            else{
                                if(count($product->variation) == 1){

                                    $product_filtered .='<ins class="new-price">'. env('CURRENCY') . $product->variation->first()->price . env('UAE_CURRENCY') .'</ins>';
                                }
                                else{
                                    $product_filtered .='<ins class="new-price">'. env('CURRENCY') . $product->variation->where('price', $product->variation->min('price'))->first()->price . env('UAE_CURRENCY') . '-' .  env('CURRENCY') . $product->variation->where('price', $product->variation->max('price'))->first()->price  .env('UAE_CURRENCY') .'</ins>';
                                }
                            }
                        $product_filtered .='</div>
                        <button onclick="addToCart('. $product->id .')" class="btn btn-primary added_to_cart_'. $product->id;
                            if ( !is_null(Cart::content()->where('id', $product->id)->first())) {
                                $product_filtered .= ' added_to_cart';
                            }
                            else{
                                $product_filtered .= ' ';
                            }

                        $product_filtered .= '" id="">';
                            if ( !is_null(Cart::content()->where('id', $product->id)->first())) {
                                $product_filtered .= 'Added To Cart';
                            }
                            else{
                                $product_filtered .= 'Add to Cart';
                            }
                    $product_filtered .= '</button></div>
                    </div>
                </div>
                        ';
        }
        return ['product_filtered' => $product_filtered];
    }

    public function generate_product_filter()
    {
        
    }

    public function about()
    {
        $info = AboutUs::first();
        return view('user.pages.about_us', compact('info'));
    }

    public function privacy_policy()
    {
        $page = Page::find(5);
        return view('pages.privacy-policy', compact('page'));
    }

    public function term_condition()
    {
        $page = Page::find(6);
        return view('pages.terms-and-conditions', compact('page'));
    }

    public function contact()
    {
        return view('user.pages.contact-us');

    }

    public function send_message(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        //Mail::send(new ContactMail($request));

        session()->flash('success', 'Thank you for contacting us, we will be in touch within 24 to 48 hours');
        return redirect()->route('contact');
    }

    public function subscribe(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = Subscriber::where('email',$request->email)->first();
        if (is_null($subscriber)) {
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->save();

            // Alert::success('Thanks, Welcome to our NEWSLETTER', '');
            return redirect()->back()->with('success', 'Thanks, Welcome to our NEWSLETTER');
        }
        else {
            // Alert::error('Thanks, You already subscribed us!', '');
            return redirect()->back()->with('success', 'Thanks, You already subscribed us!');
        } 
    }

    public function my_orders()
    {
        if (Auth::check()) {
            $orders = Order::where('customer_id', Auth::id())->get();
            return view('user.pages.customer.orders', compact('orders'));
        }
        else{
            return redirect()->route('index');
        }
    }

    public function view_order($id) {
        if (Auth::check()) {
            $order = Order::where('code', $id)->first();
            if (!is_null($order)) {
                return $this->get_order_info($order->id);
            }
            else{
                return back()->with('error','Invalid order code!');
            }
        }
        else{
            return redirect()->route('index');
        }
        
    }

    public function my_wishlist()
    {
        if(Auth::check()) {
            $wishlists = Wishlist::where('customer_id', Auth::id())->get();
            return view('user.pages.customer.wishlist', compact('wishlists'));
        }
        else {
            return redirect()->route('login')->with('error', 'You are not logged in!');
        }
        
    }

    public function my_account()
    {
        if (Auth::check()) {
            if (Auth::user()->type == 1) {
                return redirect()->route('home');
            }
            else{
                $orders = Order::where('customer_id', Auth::id())->get();
                $wishlists = Wishlist::where('customer_id', Auth::id())->get();
                return view('user.pages.customer.account', compact('orders', 'wishlists'));
                //return view('pages.customer.account', compact('orders', 'wishlists'));
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    public function customer_profile()
    {
        if (Auth::check()) {
            if (Auth::user()->type == 1) {
                return redirect()->route('home');
            }
            else{
                $user_info = Auth::user();
                $districts = District::orderBy('name', 'ASC')->get();
                return view('user.pages.customer.customer_profile', compact('user_info', 'districts'));
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    public function customer_reviews()
    {
        if (Auth::check()) {
            if (Auth::user()->type == 1) {
                return redirect()->route('home');
            }
            else{
                $user_info = Auth::user();
                $orders = Order::where('customer_id', Auth::id())->where('order_status', 'delivered')->select(['code', 'id', 'created_at'])->paginate(10);
                return view('user.pages.customer.review_index', compact('user_info', 'orders'));
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    public function write_reviews($order_product_order_id)
    {
        if (Auth::check()) {
            if (Auth::user()->type == 1) {
                return redirect()->route('home');
            }
            else{
                $user_info = Auth::user();
                $order_product_info = OrderProduct::find($order_product_order_id);
                if(is_null($order_product_info)) {
                    return redirect()->back()->with('error', 'Order Product info not found');
                }
                
                $order_info = Order::where('customer_id', Auth::id())->where('code', $order_product_info->order_code)->first();
                return view('user.pages.customer.write_review', compact('user_info', 'order_info', 'order_product_info'));
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    public function customer_reviews_submit(Request $request) {
        
        if (Auth::check()) {
            if (Auth::user()->type == 1) {
                return redirect()->route('home');
            }
            else{
                $user_info = Auth::user();
                $order_product_info = OrderProduct::find($request->order_product_info_id);
                if(is_null($order_product_info)) {
                    return redirect()->back()->with('error', 'Order Product info not found');
                }

                $check_review = ProductsReviews::where(['order_product_id'=>$order_product_info->id, 'order_code'=>$order_product_info->order_code])->first(['id']);
                if(!is_null($check_review)) {
                    return redirect()->back()->with('error', 'Review is already Exist!');
                }

                $new_review = new ProductsReviews;
                $new_review->customer_id = $user_info->id;
                $new_review->order_code = $order_product_info->order_code;
                $new_review->order_product_id = $order_product_info->id;
                $new_review->product_id = $order_product_info->product_id;
                $new_review->review_text = $request->review_text;
                $new_review->is_active = 1;
                $new_review->created_at = now();
                $status = $new_review->save();
                
                if($status) {
                    return Redirect()->route('customer.reviews')->with('success', 'Review Placed Successfully.');
                }
                else {
                    return redirect()->back()->with('error', 'Network Error! Please Try again.');
                }
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    

    

    public function customer_account_update(Request $request, $id)
    {
        $customer = User::find($id);
        if (!is_null($customer)) {
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->address = $request->address;

            // image save
            if ($request->image){
                $image = $request->file('image');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/customer/'. $img);
                Image::make($image)->save($location);
                $customer->image = $img;
            }

            // // NID save
            // if ($request->nid){
            //     $nid = $request->file('nid');
            //     $img = time() . '.' . $nid->getClientOriginalExtension();
            //     $location = public_path('images/customer/nid/'. $img);
            //     Image::make($nid)->save($location);
            //     $customer->nid = $img;
            // }

            $customer->save();
            return redirect()->back()->with('success', 'Profile Updated!');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function change_password(Request $request)
    {
        $user = Auth::user();
        $c_password = $request->c_password;
        $n_password = $request->n_password;
        $cf_password = $request->cf_password;
        //dd(Hash::make($c_password));
        if (Hash::check($request->c_password, $user->password)) {
            if ($n_password == $cf_password) {
                $user->password = Hash::make($n_password);
                $user->save();
                Alert::success('Password has been updated', '');
                return back();
            }
            else {
                Alert::error('Password do not match !', '');
                return back();
            }
        }
        else{
            Alert::error('Your current password is wrong !', '');
            return back();
        }
    }

    public function my_wallet()
    {
        if (Auth::check()) {
            if (Auth::user()->type == 1) {
                return redirect()->route('home');
            }
            else{
                $wallet = Wallet::where('customer_id', Auth::id())->first();
                return view('pages.customer.wallet', compact('wallet'));
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    public function my_wallet_point_convert(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'point' => 'required|numeric',
            ]);
            //dd($request->all());

            $wallet = Wallet::where('customer_id', Auth::id())->first();
            if (!is_null($wallet)) {
                $point = $request->point;
                $minimum_point = $request->minimum_point;
                if ($point >= $minimum_point) {
                    $entry = new WalletEntry;
                    $entry->wallet_id = $wallet->id;
                    $entry->point_out = $point;
                    $entry->cash_in = $point/$minimum_point;
                    $entry->note = 'Point Conversion';
                    $entry->save();
                    Alert::success('Point Conversion Successful!');
                    return back();
                }
                else{
                    Alert::error('Minimum Point Not Matched');
                    return back();
                }
            }
            else{
                Alert::error('Walet Not Found!');
                return back();
            }
        }
        else{
            return redirect()->route('index');
        }
    }

    // Affliate Request Submit
    public function affiliate_apply()
    {
        $customer = User::find(Auth::id());
        $customer->affiliate_applied = 1;
        $customer->save();
        Alert::success('Your application is pending for admin approval');
        return back();
    }

    public function affiliate_dashboard()
    {
        if (Auth::check()) {
            $orders = Order::where('referral_id', Auth::id())->get();
            $referrals = User::where('referral_id', Auth::id())->get();
            $payments = Payment::where('customer_id', Auth::id())->orderBy('id', 'DESC')->get();
            $coupons = Coupon::where('affiliate_id', Auth::id())->get();
            return view('pages.customer.affiliate-dashboard', compact('orders', 'referrals', 'payments', 'coupons'));
        }
        else{
            return redirect()->route('index');
        }
    }

    public function payment_request(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                    'request_amount' => 'required|numeric',
                ]);
            $payment = new Payment;
            $payment->customer_id = Auth::id();
            $payment->request_amount = $request->request_amount;
            $payment->note = 'Payment Requested';
            $payment->save();
            Alert::success('Your payment request has been submitted');
            return back();
        }
        else{
            return redirect()->route('index');
        }
    }

    public function coupone_store(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'discount' => 'required|numeric',
                'coupon_type' => 'required|string',
                'valid_to' => 'required|date',
            ]);
            $coupon = new Coupon;
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            if ($request->coupon_type == 'percent') {
                $coupon->discount = $request->discount;
            }
            if ($request->coupon_type == 'flat') {
                $coupon->amount = $request->discount;
            }
            $coupon->valid_from = date('Y-m-d');
            $coupon->valid_to = $request->valid_to;
            if ($request->has('single_use')) {
                $coupon->single_use = 1;
            }
            $coupon->affiliate_id = Auth::id();

            $coupon->save();

            Alert::success('Coupon Added Successfully');
            return back();
        }
        else{
            return redirect()->route('index');
        }
    }

    public function coupone_update(Request $request, $id)
    {
        if (Auth::user()->type == 2) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'discount' => 'required|numeric',
                'valid_to' => 'required|date',
            ]);
            $coupon = Coupon::find($id);
            if (!is_null($coupon)) {
                $coupon->name = $request->name;
                $coupon->code = $request->code;
                $coupon->discount = $request->discount;
                $coupon->valid_to = $request->valid_to;
                if ($request->coupon_type == 'percent') {
                    $coupon->discount = $request->discount;
                    $coupon->amount = NULL;
                }
                if ($request->coupon_type == 'flat') {
                    $coupon->amount = $request->discount;
                    $coupon->discount = NULL;
                }
                $coupon->save();

                Alert::success('Coupon updated Successfully');
                return back();
            }
            else {
                session()->flash('error','Something went wrong!');
                return back();
            } 
        }
    }

    public function coupone_delete($id)
    {
        if (Auth::user()->type == 2) {
            $coupon = Coupon::find($id);
            if (!is_null($coupon)) {
                $coupon->delete();
                Alert::success('Coupon has been deleted');
                return back();
            }
            else {
                Alert::error('Something went wrong!');
                return back();
            }
        }
        else {
            Alert::error('Something went wrong!');
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
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }

    public function generateUniqueCode()
    {

        $characters = '0123456789';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }
        $code = date('y').'-'.$code;

        if (Order::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;

    }


    public function order_create(Request $request)
    {
        $cart_info = Cart::content();

        if(count($cart_info) <= 0) {
            return Redirect()->route('products')->with('error', 'Your Cart is empty!');
        }

        $total_payable = $request->total;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $online_payment_mfs = $request->online_payment_mfs;
        $online_mfs_paymnet_number = $request->online_mfs_paymnet_number;
        $online_transaction_id = $request->online_transaction_id;
        
        $total = Cart::subtotal();

        $order = new Order;
        $payment_type = $request->payment_type;

        $discount = 0;
        if (Session::has('coupon_discount')) {
            $order->coupon_status = 1;
            //$order->coupon_code = 1;
            $discount = Session::get('coupon_discount');
            $order->coupon_discount_amount = $discount;
        }
        else {
            $order->coupon_status = 0;
        }

        $total_payable = ($total + $request->shipping_charge) - $discount;
        
        if($payment_type == 'online_mfs') {
            if($online_payment_mfs == '' || $online_mfs_paymnet_number == '') {
                return Redirect()->back()->with('error', 'Please setup payment number.');
            }
        }

        if($payment_type == 'wallet') {
            $user_info = Auth::user();
            if(!is_null($user_info)) {
                if($user_info->wallet_amount >= $total_payable) {

                }
                else {
                    return Redirect()->back()->with('error', 'Insufficient Wallet Amount!');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Invalid user info!');
            }
            $order->payment_method = 'wallet';
        }

        $order_count = Order::count('id');
        $count_plus = $order_count + 1;
        $order_code = date("dmy").random_int(100, 999).sprintf('%06d', $count_plus);
        $order->code = $order_code; //$this->generateUniqueCode();

        if (Auth::user()) {
            $order->customer_id = Auth::id();
        }

        $order->price = $total;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->district_id = $request->district_id;
        $order->area_id = $request->area_id;
        $order->shipping_address = $request->shipping_address;
        $order->delivery_charge = $request->shipping_charge;
        $order->order_status = 'pending';
        $order->payment_status = 'unpaid';
        $order->total_payable = $total_payable;
        $order_status = $order->save();

        if($order_status) {
            foreach (Cart::content() as $cart) {
                $order_product = new OrderProduct;
                $order_product->order_code = $order_code;
                $order_product->product_id = $cart->options->product_id;
                $order_product->variations = $cart->weight;
                $order_product->price = $cart->options->single_price;
                $order_product->qty = $cart->qty;
                $order_product->total = ($cart->options->single_price) * $cart->qty;
                $order_product->save();
            }

            if($payment_type == 'cod') {
                $order->payment_method = 'cash on delivery';
                $order->save();
            }
            else if($payment_type == 'online_mfs') {
                // return $payment_type;
                $order->payment_method = 'Manula MFS';
                $order->manual_mfs_account_name = $online_payment_mfs;
                $order->manual_mfs_payment_number = $online_mfs_paymnet_number;
                $order->manual_mfs_transaction_id = $online_transaction_id;
                $order->payment_status = 'paid';
                $order->save();
            }
            else if($payment_type == 'online') {
                $request->request->add(['tran_id' => $order_code, 'value_a'=>'order_payment']);
                $sslcommerz = new SslCommerzPaymentController;
                return $sslcommerz->index($request);
            }
            else if($payment_type == 'wallet') {
                $order->payment_method = 'wallet';
                $order->payment_status = 'paid';
                $order->save();

                $wallet_amount = $user_info->wallet_amount;
                $rest_wallet_amount = $wallet_amount - $total_payable;
                $user_info->wallet_amount = $rest_wallet_amount;
                $user_info->save();
            }

            if (!is_null($request->email)) {
                //Mail::send(new OrderMail($order));
            }
    
            return redirect()->route('order.complete', $order->code);

        }
        else {
            return Redirect()->back()->with('error', 'Network Error!');
        }

    }

    public function order_complete($code)
    {
        $order = Order::where('code', $code)->first();
        if (!is_null($order)) {

            foreach (Cart::content() as $cart) {
                $product_id = $cart->options->product_id;
                $variation = $cart->weight;
                $qty = $cart->qty;

                $product = Product::find($product_id);
                if(!is_null($product)) {
                    if($variation == 0) {
                        $stock_info = $product->single_stock;
                        $stock_info->qty -= $qty;
                        if($stock_info->qty < 0) {
                            $stock_info->qty = 0;
                        }
                        $stock_info->save();
                    }
                    else {
                        $stock_info = ProductStocks::find($variation);
                        if(!is_null($stock_info)) {
                            $stock_info->qty -= $qty;
                            if($stock_info->qty < 0) {
                                $stock_info->qty = 0;
                            }
                            $stock_info->save();
                        }
                    }
                }

                //running

                Cart::remove($cart->rowId);
            }
            Session::forget('coupon_discount');

            $phone = optional($order)->phone;
            $msg = 'Dear Sir/Madam, Your order('.$order->code.') has been Placed successfully. Thanks for shopping with us, Anizor BD.';
            //$send_sms = User::send_sms($phone, $msg);
            return $this->get_order_info($order->id);
            //return view('user.pages.order_complete', compact('order'));
            //return view('pages.order-complete', compact('order'));
            
        }
        else{
            return back()->with('error','Invalid order code!');
        }
    }

    public function get_shipping_charge(Request $request)
    {
        $district_id = $request->district_id;
        $district_info = District::find($district_id);
        $shipping_charge = 0;
        $wallet_amount = 0;
        if(!is_null($district_info)){
            $shipping_charge = $district_info->shipping_charge;
        }

        if(Auth::check()) {
            $wallet_amount = Auth::user()->wallet_amount;
        }

        return Response()->json([
            'shipping_charge' => $shipping_charge,
            'wallet_amount' => $wallet_amount,
        ]);
    }

    public function order_track()
    {
        return view('user.pages.track-order');
        //return view('pages.track-order');
        
    }

    public function order_track_result(Request $request)
    {
        $code = $request->code;
        $order = Order::where('code', $code)->first();
        if (!is_null($order)) {
            return $this->get_order_info($order->id);
            //return view('pages.track-order-result', compact('order'));
        }
        else{
            return back()->with('error','Invalid order code!');
        }
    }

    public function get_order_info($id) {
        $order = Order::find($id);
        if (!is_null($order)) {
            return view('user.pages.order_complete', compact('order'));
        }
        else{
            return back()->with('error','Invalid order code!');
        }
    }

    public function other_pages($id, $name) {
        $page_info = Page::find($id);
        if (!is_null($page_info)) {
            return view('user.pages.others_page', compact('page_info'));
        }
        else{
            return back()->with('error','Invalid page access!');
        }
    }

    public function user_blog_index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->select(['id', 'title', 'image', 'created_at'])->paginate(6);
        return view('user.pages.blog_index', compact('blogs'));        
    }

    public function user_blog_details($id, $slug) {
        $blog_details = Blog::find($id);
        if(is_null($blog_details)) {
            return Redirect()->back()->with('error', 'No News Found!');
        }

        return view('user.pages.blog_details', compact('blog_details'));
    }

    


}
