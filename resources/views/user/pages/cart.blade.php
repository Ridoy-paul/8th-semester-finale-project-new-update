
@extends('user.inc.master')

@section('title')Shopping Cart @endsection
@section('description')Shopping Cart  @endsection
@section('keywords')Shopping Cart, cart, shopping bag, awesome-cart @endsection

@section('content')
@php
$total = Cart::subtotal();
$discount = 0;
if(Session::has('coupon_discount')){
    $discount = Session::get('coupon_discount');
}

@endphp

  
    <!-- cart section start -->
    <section class="cart__section py-5">
        <div class="container-fluid">
            <div class="cart__section--inner">
                    <h2 class="cart__title mb-40">Shopping Cart</h2>
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart__table">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th width="45%" class="cart__table--header__list">Product</th>
                                            <th class="cart__table--header__list">Price</th>
                                            <th class="cart__table--header__list">Quantity</th>
                                            <th class="cart__table--header__list">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body">
                                        @if(count($carts) > 0)
                                        @foreach($carts as $cart)
                                        <?php
                                            $product_info = App\Models\Product::find(optional($cart->options)->product_id);
                                        ?>
                                        
                                        @if(!is_null($product_info))
                                        <?php
                                            $variation_info = '';

                                            if($cart->weight != 0) {
                                                $stock_info = App\Models\ProductStocks::find($cart->weight);
                                                
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

                                        
                                        ?>
                                        <tr class="cart__table--body__items mb-2">
                                            <td class="cart__table--body__list">
                                                <div class="cart__product d-flex align-items-center">
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                        <button class="cart__remove--btn" aria-label="search button" type="submit">
                                                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path></svg>
                                                        </button>
                                                    </form>
                                                    
                                                    <div class="cart__thumbnail">
                                                        <a href="{{route('single.product', [$product_info->id, Str::slug($product_info->title)])}}"><img class="border-radius-5 shadow rounded p-1" src="{{asset('images/product/' .optional($product_info)->thumbnail_image)}}" alt="cart-product"></a>
                                                    </div>
                                                    <div class="cart__content">
                                                        <h4 class="cart__content--title"><a href="{{route('single.product', [$product_info->id, Str::slug($product_info->title)])}}">{{$product_info->title}}</a></h4>
                                                        <span class="cart__content--variant">{!!$variation_info!!}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price">{!!$price_info!!}</span>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <div class="quantity__box">
                                                    <button type="button" class="quantity__value quickview__value--quantity decrease cart_page_qty_decrease"  onclick="change_cart_qty('down', '{{ $cart->rowId }}', 'cart_page')" aria-label="quantity value" value="Decrease Value">-</button>
                                                    <label>
                                                        <input type="number" class="quantity__number quickview__value--number cart_page_qty_{{ $cart->rowId }}" readonly min="1" value="{{ $cart->qty }}" data-counter="">
                                                    </label>
                                                    <button type="button" class="quantity__value quickview__value--quantity increase cart_page_qty_increase" onclick="change_cart_qty('up', '{{ $cart->rowId }}', 'cart_page')" aria-label="quantity value" value="Increase Value">+</button>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price end">৳{{number_format((optional($cart->options)->single_price * $cart->qty), 2)}}</span>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5"><div class="minicart__product--items text-center"><h3 class="py-5 px-2"><b>Cart is Empty!</b><h3></div></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table> 
                                <div class="continue__shopping d-flex justify-content-between">
                                    <a class="continue__shopping--link" href="{{route('products')}}">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart__summary border-radius-10">
                                <div class="coupon__code mb-30">
                                    <h3 class="coupon__code--title">Coupon</h3>
                                    <p class="coupon__code--desc">Enter your coupon code if you have one.</p>
                                    <div class="coupon__code--field">
                                        <form class="coupon coupon__code--field d-flex" action="{{ route('coupon.apply') }}" method="POST">
                                            @csrf
                                            <label>
                                                <input required style="width: 150px !important;" class="coupon__code--field__input border-radius-5" name="code" placeholder="Coupon code" type="text">
                                            </label>
                                            <button class="coupon__code--field__btn primary__btn" type="submit">Apply Coupon</button>
                                            
                                        </form>
                                        @if(Session::has('coupon_success'))
                                        <p class="alert alert-success">{{ Session::get('coupon_success') }} </p>
                                        @endif
                                        
                                        @if(Session::has('invalid'))
                                            <p class="alert alert-danger">{{ Session::get('invalid') }}</p>
                                        @endif
                                        @if(Session::has('coupon_discount'))
                                            <a href="{{ route('coupon.remove') }}" class="btn btn-dark btn-outline btn-rounded">Remove Coupon</a>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="cart__summary--total mb-20">
                                    <table class="cart__summary--total__table">
                                        <tbody>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">Subtotal</td>
                                                <td class="cart__summary--amount text-right">{{number_format($total, 2)}}</td>
                                            </tr>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">Discount</td>
                                                <td class="cart__summary--amount text-right">{{number_format($discount, 2)}}</td>
                                            </tr>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">Total</td>
                                                <td class="cart__summary--amount text-right">{{number_format($total - $discount, 2)}}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart__summary--footer">
                                    <ul class="d-flex justify-content-between">
                                        <li></li>
                                        <li><a class="cart__summary--footer__btn primary__btn checkout" href="{{ route('checkout') }}">PROCEED TO CHECKOUT</a></li>
                                    </ul>
                                </div>
                            </div> 
                        </div>
                    </div> 
            </div>
        </div>     
    </section>
    <!-- cart section end -->

  
@endsection