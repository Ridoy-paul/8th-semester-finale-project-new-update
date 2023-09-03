<style>
    .variant__input--fieldset input[type=radio]:checked+label {
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
    }
</style>

@php

    $stock_price = $product->single_stock;
    $sale_text = 'sale';
    $stock_qty_text = '';

    if($product->discount_type <> 'no') {
        if($product->discount_type == 'flat') {
            $sale_text = 'Discount '.optional($product)->discount_amount." TK";
        }
        else if($product->discount_type == 'percentage') {
            $sale_text = 'Discount '.optional($product)->discount_amount."%";
        }
    }
    
    if($product->type == 'single') {
        if(optional($stock_price)->qty <= 0) {
            $sale_text = 'Out of Stock';
        }
        $stock_qty_text = optional($stock_price)->qty." ".optional($product)->unit_type;
    }
    else {
        $variations = $product->variation_stock;
        $min_price = $variations->min('price');
        $max_price = $variations->max('price');
        
    }
    
@endphp
<!-- Start product details section -->

<div class="col-md-5">
<div class="product__details--media">
    <div class="product__media--preview  swiper">
        <div class="swiper-wrapper">
            <a class="product__items--link" href="#">
                <img class="product__items--img product__primary--img border-radius-10 shadow rounded" src="{{ asset('images/product/'.$product->thumbnail_image) }}" alt="{{$product->title}}">
            </a>
        </div>
    </div>
</div>
</div>   
<div class="col">
<div class="product__details--info">
    {{-- <form action="#"> --}}
        <h2 class="product__details--info__title mb-15" title="{{ $product->title }}">{{ $product->title }}</h2>
        <div class="row">
            <div class="col-md-12 col-12">
                @if(!is_null($product->category))
                <div class="product-categories">
                    Category:
                    <span class="product-category"><a href="#">{{ $product->category->title }}</a></span>
                </div>
                @endif
                <div class="product-sku mb-3">
                    CODE: <span>{{ $product->code }}</span>
                </div>
            </div>
        </div>
        
        <span style="background-color: #EE2761; border-radius: 10px; color: #ffffff; padding:0px 10px;">{{$sale_text}}</span>
            
        <div class="product__details--info__price mt-3 mb-10" id="product_price_info{{optional($product)->id}}">
            @if($product->type == 'single')
                <span class="current__price">৳{{number_format($stock_price->price, 2)}}</span>
                <span class="price__divided"></span>
                @if($product->discount_type <> 'no')
                    <?php
                        if($product->discount_type == 'flat') {
                            $old_price = $stock_price->price + optional($product)->discount_amount;
                        }
                        else if($product->discount_type == 'percentage') {
                            $discount_amount_tk = (optional($product)->discount_amount * $stock_price->price)/100;
                            $old_price =  $stock_price->price + $discount_amount_tk;
                        }
                    
                    ?>
                    <span class="old__price">৳{{number_format($old_price, 2)}}</span>
                @endif
            @else
                <span class="current__price">৳{{number_format($min_price, 2)}}</span>
                <span class="price__divided"></span>
                <span class="current__price">৳{{number_format($max_price, 2)}}</span>
            @endif
            
        </div>
        
        @if(count(optional($product)->variation_stock) > 0)
        <form action="javascript:void(0)" method="POST" id="variation_form{{optional($product)->id}}">
        <div class="product__variant">
            @if($product->type == 'variation')
            <input type="hidden" name="product_type" id="product_type" value="variation">
            @if(optional($product)->colors <> '[]')
            <input type="hidden" name="color_info" id="color_info" value="1">
            <div class="product__variant--list mb-10">
                <fieldset class="variant__input--fieldset">
                    <legend class="product__variant--title mb-8">Color :</legend>
                    @foreach(json_decode(optional($product)->colors, true) as $color)
                        <?php 
                            $color_info = color_info($color);
                        ?>
                        @if($loop->first)
                            <input id="color_{{$color}}" onchange="select_variation({{optional($product)->id}})" value="{{$color}}" checked name="color" type="radio" >
                            <label class="variant__color--value {{$color_info->name}}" style="background-color: {{$color_info->code}} !important;" for="color_{{$color}}" title="{{$color_info->name}}"></label>
                        @else
                            <input id="color_{{$color}}" onchange="select_variation({{optional($product)->id}})" value="{{$color}}" name="color" type="radio" >
                            <label class="variant__color--value {{$color_info->name}}" style="background-color: {{$color_info->code}} !important;" for="color_{{$color}}" title="{{$color_info->name}}"></label>
                        @endif
                    
                    @endforeach
                </fieldset>
            </div>
            @else
                <input type="hidden" name="color_info" id="color_info" value="0">
            @endif
            @if(optional($product)->attributes <> null)
                @foreach(json_decode(optional($product)->attributes, true) as $attribute)
                <?php 
                    $attribute_info = variation_info($attribute);
                ?>
                @if(!is_null($attribute_info))
                <?php
                    $single_variation_info = single_variation_info($attribute_info->id, optional($product)->id);
                ?>
                    @if(count($single_variation_info) > 0)
                    <div class="product__variant--list mb-15">
                        <fieldset class="variant__input--fieldset {{$attribute_info->title}}">
                            <legend class="product__variant--title mb-8">{{$attribute_info->title}} :</legend>
                            <div id="single_variation_info_div{{optional($product)->id}}">
                            @foreach($single_variation_info as $variation)
                                <input id="{{$attribute_info->title.$variation->id}}" onchange="select_variation({{optional($product)->id}})" value="{{$variation->id}}" name="attribute_variation" type="radio" >
                                <label class="variant__size--value {{$variation->variant_output}}" for="{{$attribute_info->title.$variation->id}}">{{$variation->variant_output}}</label>
                            @endforeach
                            </div>
                        </fieldset>
                    </div>
                    @endif
                @endif
                @endforeach
                @endif
            @else
                <input type="hidden" name="product_type" id="product_type" value="single">
            @endif
            <input type="hidden" name="product_id" id="product_id" value="{{optional($product)->id}}">
            </form>
            @endif

            <form action="javascript:void(0)" id="add_to_server{{optional($product)->id}}" method="post">
                <input type="hidden" name="product_id" id="product_id" value="{{optional($product)->id}}">
            <div class="product__variant--list quantity d-flex align-items-center mb-20">
                <div class="quantity__box">
                    <button type="button" class="quantity__value quickview__value--quantity decrease" onclick="quantity_change('de', {{optional($product)->id}})" aria-label="quantity value" value="Decrease Value">-</button>
                    <label>
                        <input type="number" class="quantity__number quickview__value--number quantity__number_{{optional($product)->id}}" name="cart_qty_input" id="cart_qty_input" value="1" />
                        
                    </label>
                    <button type="button" class="quantity__value quickview__value--quantity increase" onclick="quantity_change('in', {{optional($product)->id}})" aria-label="quantity value" value="Increase Value">+</button>
                </div>

                <div class="stock-qty">
                    <p class="ps-3" id="stock_qty_show{{optional($product)->id}}">{{$stock_qty_text}}</p>
                </div>
                
            </div>
            
            <div>
                <input type="hidden" name="selected_variation_id" id="selected_variation_id{{optional($product)->id}}" value="">

                @if($product->type == 'single')
                    <input type="hidden" name="product_type" id="product_type" value="single">
                    <input type="hidden" name="stock_qty" id="stock_qty_{{optional($product)->id}}" value="{{optional($stock_price)->qty}}">
                    @if(optional($stock_price)->qty > 0)
                        <button class="ms-0 quickview__cart--btn primary__btn" onclick="addToCart({{optional($product)->id}}, 'details', 'cart')" id="add_to_cart_button{{optional($product)->id}}" type="button">Add To Cart</button>  
                        <button class="quickview__cart--btn primary__btn" onclick="addToCart({{optional($product)->id}}, 'details', 'checkout')" id="buy_now_button{{optional($product)->id}}" type="button">Buy Now</button>
                    @endif  
                @else
                    <input type="hidden" name="product_type" id="product_type" value="variation">
                    <input type="hidden" name="stock_qty" id="stock_qty_{{optional($product)->id}}" value="0">
                    <button class="ms-0 quickview__cart--btn primary__btn" id="add_to_cart_button{{optional($product)->id}}" onclick="addToCart({{optional($product)->id}}, 'details', 'cart')" type="button">Add To Cart</button>  
                    <button class="quickview__cart--btn primary__btn mx-3" id="buy_now_button{{optional($product)->id}}" onclick="addToCart({{optional($product)->id}}, 'details', 'checkout')" type="button">Buy Now</button>  

                    <h3 class="m-3 text-danger fw-bold" id="notification_show{{optional($product)->id}}" style="display: none;">Please Select a Variation</h3>
                    
                @endif
                <a class="product__items--action__btn ms-0 mx-3" onclick="addToWishlist({{ $product->id }})" href="javascript:void(0)">
                    <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="25.51" height="23.443" viewBox="0 0 512 512"><path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg> 
                    <span class="visually-hidden">Wishlist</span>
                </a>
            </div>
        </form>
        </div>
    {{-- </form> --}}
</div>
<!-- End product details section -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function select_variation(product_id) {
        $('#selected_variation_id'+product_id).val('');
        $('#stock_qty_'+product_id).html(0);
        $('#stock_qty_show'+product_id).html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('single.product.variation.check')}}",
            method: 'post',
            data: $('#variation_form'+product_id).serialize(),
            beforeSend: function() {
                // $('.se-pre-con').show();
            },
            success: function(response){
                if(response.variation_status == 1) {
                    $('#product_price_info'+product_id).html(response.price_info);
                    $('#stock_qty_show'+product_id).html(response.qty+" "+response.unit_type);
                    $('#selected_variation_id'+product_id).val(response.id);
                    $('#stock_qty_'+product_id).val(response.qty);
                    if(response.qty > 0) {
                        $('#add_to_cart_button'+product_id).show();
                        $('#buy_now_button'+product_id).show();
                        $('#notification_show'+product_id).hide();
                    }
                    else {
                        $('#add_to_cart_button'+product_id).hide();
                        $('#buy_now_button'+product_id).hide();
                        $('#notification_show'+product_id).text('Out of Stock');
                        $('#notification_show'+product_id).show();
                    }
                    
                   // console.log(response);
                }
                else {
                    if(response.color_dependent_variation_status == 1) {
                        $('#single_variation_info_div'+product_id).html(response.color_dependent_variation);
                    }
                }
            }
        });
    }

</script>
