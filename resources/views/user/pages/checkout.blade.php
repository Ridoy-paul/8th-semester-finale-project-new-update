
@extends('user.inc.master')

@section('title')Checkout @endsection
@section('description')Checkout  @endsection
@section('keywords')Checkout @endsection

@section('content')
@php
    $total = Cart::subtotal();
    $discount = 0;
    if(Session::has('coupon_discount')){
        $discount = Session::get('coupon_discount');
    }

    $total_with_discount = $total - $discount;
@endphp

<style>
    /* HIDE RADIO */
    .hiddenradio [type=radio] { 
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* IMAGE STYLES */
    .hiddenradio [type=radio] + img {
        cursor: pointer;
    }

    /* CHECKED STYLES */
    .hiddenradio [type=radio]:checked + img {
        outline: 4px solid #0ABB75;
    }

</style>

<!-- Start of PageContent -->
<div class="page-content py-5">
    <div class="container-fluid">
            <div class="row mb-9">
                <div class="col-lg-5 mb-4 sticky-sidebar-wrapper p-3">
                    <div class="order-summary-wrapper sticky-sidebar shadow rounded p-3">
                        <div class="order-summary">
                            <div class="cart__table checkout__product--table">
                                <table class="cart__table--inner">
                                    <tbody class="cart__table--body">
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
                                        ?>
                                        <tr class="cart__table--body__items">
                                            <td class="cart__table--body__list">
                                                <div class="product__image two d-flex align-items-left">
                                                    <div class="product__thumbnail border-radius-5">
                                                        <a href="{{route('single.product', [$product_info->id, Str::slug($product_info->title)])}}"><img class="border-radius-5 shadow rounded p-1" src="{{asset('images/product/' .optional($product_info)->thumbnail_image)}}" alt="cart-product"></a>
                                                        <span class="product__thumbnail--quantity">{{$cart->qty}}</span>
                                                    </div>
                                                    <div class="product__description">
                                                        <h3 style="line-height: 24px !important;" class="product__description--name h4"><a href="{{route('single.product', [$product_info->id, Str::slug($product_info->title)])}}">{{$product_info->title}}</a></h3>
                                                        <p style="line-height: 1px !important;">{!!$variation_info!!}</p>
                                                        <span class="cart__price">৳{{number_format((optional($cart->options)->single_price * $cart->qty), 2)}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table> 
                            </div>
                            <div class="coupon__code mb-30">
                                <h3 class="coupon__code--title">Coupon</h3>
                                <p class="coupon__code--desc">Enter your coupon code if you have one.</p>
                                <div class="coupon__code--field">
                                    <form class="coupon coupon__code--field d-flex" action="{{ route('coupon.apply') }}" method="POST">
                                        @csrf
                                        <label>
                                            <input required style="width: 200px !important;" class="coupon__code--field__input border-radius-5" name="code" placeholder="Coupon code" type="text">
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
                            
                            {{-- <table class="order-table">
                                
                                <tbody>
                                    
                                    <tr class="cart-subtotal bb-no">
                                        <td>
                                            <b>Subtotal</b>
                                        </td>
                                        <td>
                                            <b>{{ env('CURRENCY') }}{{ Cart::subtotal() - $discount }} {{ env('UAE_CURRENCY') }}</b>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table> 

                            <div class="payment-methods" id="payment_method">
                                <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                
                                <div class="form-group">
                                    <select name="payment_method" id="payment_option" class="form-control">
                                        <option value="Cash on Delivery">Cash on Delivery</option>
                                        <option value="Bkash">Bkash</option>
                                        <option value="Rocket">Rocket</option>
                                    </select>
                                </div>
                                
                                <div  class="hidden" id="cod">
                                    
                                </div>
                                
                            </div>

                            <div class="form-group place-order pt-6">
                                <button type="submit" class="btn btn-dark btn-block btn-rounded">Place Order</button>
                            </div>
                            --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 pr-lg-4 mb-4 p-3">
                    <form class="form checkout-form shadow rounded p-3" action="{{ route('order.create') }}" method="post">
                        @csrf
                        @if(!Auth::check())
                        <div class="">
                            <input type="hidden" name="auth_status" id="auth_status" value="0">
                            Returning customer? <a href="{{ route('login') }}" style="color: #EE2761; !impotant;" class="show-login font-weight-bold text-uppercase">Login</a>
                        </div>
                        @else
                            <input type="hidden" name="auth_status" id="auth_status" value="1">
                        @endif
                    <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                        Shipping Details
                    </h3>
                    <div class="row gutter-sm">
                        <div class="col-xs-6 mb-3">
                            <div class="form-group">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" class="checkout__input--field border-radius-5" required name="name" value="{{ optional(Auth::user())->name . ' ' . optional(Auth::user())->last_name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Phone<span class="text-danger">*</span></label>
                                <input type="text" class="checkout__input--field border-radius-5" name="phone" value="{{ optional(Auth::user())->phone }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="checkout__input--field border-radius-5" name="email" value="{{ optional(Auth::user())->email }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row gutter-sm">
                        <div class="col-md-6 mb-3">
                            <div class="checkout__input--list checkout__input--select select">
                                <label class="checkout__select--label">District<span class="text-danger">*</span></label>
                                <select name="district_id" id="district_id" class="checkout__input--select__field border-radius-5 @error('district_id') is-invalid @enderror" required>
                                <option value="">Please Chose a District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                              </select>
                              @error('district_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="checkout__input--list checkout__input--select select">
                                <label class="checkout__select--label">Area<span class="text-danger">*</span></label>
                                <select name="area_id" id="areas" class="checkout__input--select__field border-radius-5 @error('area_id') is-invalid @enderror" required>
                                <option value="">Please Chose an Area</option>
                                
                              </select>
                              @error('area_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Address<span class="text-danger">*</span></label>
                        <input type="text" placeholder="House number and street name" class="checkout__input--field border-radius-5 mb-2" name="shipping_address" value="{{ optional(Auth::user())->address }}" required>
                    </div>
                    
                    <div class="form-group mt-3  mb-3">
                        <label for="order-notes">Order notes (optional)</label>
                        <textarea class="form-control mb-0" id="order-notes" name="order-notes" cols="30" rows="2" placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                    </div>

                    <div class="cart__summary--total mb-10">
                        <table class="cart__summary--total__table">
                            <tbody>
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left fw-bold">Subtotal</td>
                                    <input type="hidden" name="subtotal" id="subtotal" value="{{$total}}" />
                                    <td class="cart__summary--amount text-right">{{number_format($total, 2)}}</td>
                                </tr>
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left fw-bold">Discount</td>
                                    <input type="hidden" name="discount" id="discount" value="{{$discount}}" />
                                    <td class="cart__summary--amount text-right">{{number_format($discount, 2)}}</td>
                                </tr>
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left fw-bold">Shipping Charge</td>
                                    <input type="hidden" name="shipping_charge" id="shipping_charge" value="0" />
                                    <td class="cart__summary--amount text-right"><span id="shipping_charge_label">0.00</span></td>
                                </tr>
                                
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left fw-bold">Total</td>
                                    <input type="hidden" name="total" id="total" value="{{($total_with_discount)}}" />
                                    <td class="cart__summary--amount text-right" id="total_show">{{number_format($total_with_discount, 2)}}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group shadow rounded p-3 mb-3">
                        <label class="">
                            <input type="radio" name="payment_type" onchange="payment_setup('cod')" value="cod" required> <span>Cash On Delivery</span>
                        </label>
                        <label class="">
                            <input type="radio" name="payment_type" onchange="payment_setup('online_mfs')" value="online_mfs" required> <span>Online Payment</span>
                        </label>
                        <div class="my-2 row" id="online_mfs_main_div" style="display:none;">
                            <div class="col-md-6 col-12">
                                <div class="checkout__input--list checkout__input--select select">
                                    <label class="checkout__select--label">Online Payment Type<span class="text-danger">*</span></label>
                                    <select name="online_payment_mfs" id="online_payment_mfs" class="checkout__input--select__field border-radius-5" >
                                        <option value="">-- Select Type --</option>
                                        <option value="Bkash(01992212580)">Bkash [ personal - 01992212580 ]</option>
                                        <option value="Nagad(01970002150)">Nagad [ Personal - 01970002150 ]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <input type="number" class="checkout__input--field border-radius-5" placeholder="Payment Number" id="online_mfs_paymnet_number" name="online_mfs_paymnet_number" value="">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group mb-3">
                                    <input type="text" class="checkout__input--field border-radius-5" placeholder="Transaction ID" id="online_transaction_id" name="online_transaction_id" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="form-group mb-3">
                        
                        <h4><b>Select a payment option</b> </h4>
                        <div class="hiddenradio d-flex">
                            <label class="text-center shadow rounded p-3 mx-3">
                              <input type="radio" name="payment_type" checked value="cod" required> 
                              <img width="100" class="rounded-pill" src="{{asset('assets/images/cod.png')}}">
                              <br><span>Cash On Delivery</span>
                            </label>
                            
                            <label class="text-center shadow rounded p-3 mx-3">
                                <input type="radio" name="payment_type" value="online">
                                <img width="100" class="rounded-pill" src="{{asset('assets/images/online-payment.jpg')}}">
                                <br><span>Online Payment</span>
                              </label>

                              @if(Auth::check() && (optional(Auth::user())->wallet_amount >= $total_with_discount))
                                <label class="text-center shadow rounded p-3 mx-3" style="display: none;" id="wallet_select_body">
                                    <input type="radio" name="payment_type" value="wallet">
                                    <img width="100" class="rounded-pill" src="{{asset('assets/images/online-payment.jpg')}}">
                                    <br><span>Use Wallet ({{optional(Auth::user())->wallet_amount}})</span>
                                </label>
                              @endif
                                
                        </div>
                    </div>
                    --}}

                    <div class="form-group mt-5  mb-3">
                        <div class="checkout__checkbox">
                            <input class="checkout__checkbox--input" id="check2" required type="checkbox">
                            <span class="checkout__checkbox--checkmark"></span>
                            <label class="checkout__checkbox--label" for="check2">I agree to the terms and conditions, return policy & privacy policy</label>
                        </div>
                    </div>
                    <div class="checkout__content--step__footer d-flex align-items-center">
                        <button class="continue__shipping--btn primary__btn border-radius-5" type="submit">Complete Order</button>
                        <a class="previous__link--content" href="{{route('products')}}">Return to shop</a>
                    </div>
                </form>
                </div>
                
            </div>
    </div>
</div>
<!-- End of PageContent -->
  

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('#district_id').change(function(){
        var district_id = $(this).val();
        if (district_id == ''){
            district_id = -1;
        }
        var option = "<option value=''>Please Chose an Area</option>";
        var url = "{{ url('/') }}";

        $.get( url + "/get-area/"+district_id, function( data ) {
            data = JSON.parse(data);
            data.forEach(function (element) {
                option += "<option value='"+ element.id +"'>"+ element.name + "</option>";
            });
            //console.log(option);
            $('#areas').html(option);
        });

        var subtotal = $('#subtotal').val();
        let discount = $('#discount').val();
        let total = 0;
        let wallet_amount = 0;
        let auth_status = $('#auth_status').val();

        $.ajax({
            url: url+"/get-shipping-charge",
            type: "get",
            data:{
                district_id:district_id,
            },
            success:function(response){
            total = (parseInt(subtotal) - parseInt(discount)) + parseInt(response.shipping_charge);
            wallet_amount = response.wallet_amount;

            if(auth_status == 1 && parseFloat(wallet_amount) >= parseFloat(total)) {
                $('#wallet_select_body').show();
            }

            $('#shipping_charge_label').html(response.shipping_charge);
            
            $('#total_show').html(parseInt(total));
            $('#total').val(parseInt(total));
            $('#shipping_charge').val(response.shipping_charge);
            }
        });

    });

    function calculate_total() {

    }

    function payment_setup(type) {
        if(type == 'cod') {
            $('#online_mfs_main_div').hide();
            $('#online_payment_mfs').prop('required', false);
            $('#online_mfs_paymnet_number').prop('required', false);
        }
        else if (type == 'online_mfs') {
            $('#online_mfs_main_div').show();
            $('#online_payment_mfs').prop('required', true);
            $('#online_mfs_paymnet_number').prop('required', true);
        }
    }
</script>
  
@endsection