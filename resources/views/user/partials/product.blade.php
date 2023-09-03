@if(!empty($product))
@php
    //$stock_price = $product->single_stock;
    $stock_price = DB::table('product_stocks')->where('product_id', $product->id)->where('variant', '=', null)->where('color', '=', null)->first(['price', 'qty']);
    $sale_text = 'sale';

    if($product->discount_type <> 'no') {
        if($product->discount_type == 'flat') {
            $sale_text = 'Discount '.optional($product)->discount_amount." TK";
        }
        else if($product->discount_type == 'percentage') {
            $sale_text = 'Discount '.optional($product)->discount_amount."%";
        }
    }
    
    if($product->type == 'single' && optional($stock_price)->qty <= 0) {
        $sale_text = 'Out of Stock';
    }
    else {
        $stock_price = DB::table('product_stocks')->where('product_id', $product->id)->first(['price', 'qty']);
    
        //$variations = $product->variation_stock;
        //$min_price = $variations->min('price');
        //$max_price = $variations->max('price');
    }
    
@endphp

<div class="col mb-30 py-3 rounded product_col">
    <div class="product__items">
        <div class="product__items--thumbnail">
            <a class="product__items--link" href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">
                <img class="product__items--img product__primary--img product_img border-radius-10" src="{{ asset('images/product/'.$product->thumbnail_image) }}" alt="{{$product->title}}">
            </a>
            <div class="product__badge">
                <span class="product__badge--items sale">{{$sale_text}}</span>
            </div>
        </div>
        
        <div class="product__items--content text-center">
            {{-- <span class="product__items--content__subtitle">{{optional($product->brand)->title}}</span> --}}
            <h4 class="product__items--content__title"><a href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">{{$product->title}}</a></h4>
            <div class="product__items--price">
                <span class="current__price">৳{{number_format(optional($stock_price)->price, 2)}}</span>
                    @if($product->discount_type <> 'no')
                    <?php
                        if($product->discount_type == 'flat') {
                            $old_price = optional($stock_price)->price + optional($product)->discount_amount;
                        }
                        else if($product->discount_type == 'percentage') {
                            $discount_amount_tk = (optional($product)->discount_amount * optional($stock_price)->price)/100;
                            $old_price =  optional($stock_price)->price + $discount_amount_tk;
                        }
                    
                    ?>
                    <span class="price__divided"></span>
                    <span class="old__price">৳{{number_format($old_price, 2)}}</span>
                @endif
                {{--
                @if($product->type == 'single')
                    <span class="current__price">৳{{number_format(optional($stock_price)->price, 2)}}</span>
                    @if($product->discount_type <> 'no')
                        <?php
                            if($product->discount_type == 'flat') {
                                $old_price = optional($stock_price)->price + optional($product)->discount_amount;
                            }
                            else if($product->discount_type == 'percentage') {
                                $discount_amount_tk = (optional($product)->discount_amount * optional($stock_price)->price)/100;
                                $old_price =  optional($stock_price)->price + $discount_amount_tk;
                            }
                        
                        ?>
                        <span class="price__divided"></span>
                        <span class="old__price">৳{{number_format($old_price, 2)}}</span>
                    @endif
                @else
                    <span class="current__price">৳{{number_format($min_price, 2)}}</span>
                    <span class="price__divided"></span>
                    <span class="current__price">৳{{number_format($max_price, 2)}}</span>
                @endif
                --}}
            </div>
            
            {{--
            <ul class="rating product__rating d-flex">
                <li class="rating__list">
                    <span class="rating__list--icon">
                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                        </svg>
                    </span>
                </li>
                <li class="rating__list">
                    <span class="rating__list--icon">
                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                        </svg>
                    </span>
                </li>
                <li class="rating__list">
                    <span class="rating__list--icon">
                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                        </svg>
                    </span>
                </li>
                <li class="rating__list">
                    <span class="rating__list--icon">
                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                        </svg>
                    </span>
                </li>
                <li class="rating__list">
                    <span class="rating__list--icon">
                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                        </svg>
                    </span>
                </li>

            </ul>
            --}}
            <ul class="product__items--action d-flex">
                <li class="product__items--action__list">
                    @if($product->type == 'single')
                        @if(optional($stock_price)->qty > 0)
                        <button class="product__items--action__btn add__to--cart" onclick="addToCart({{ $product->id }}, 'only', 'cart')" type="button" >
                            <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 14.706 13.534">
                                <g transform="translate(0 0)">
                                    <g>
                                    <path data-name="Path 16787" d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z" transform="translate(0 -463.248)" fill="currentColor"></path>
                                    <path data-name="Path 16788" d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z" transform="translate(-1.191 -466.622)" fill="currentColor"></path>
                                    <path data-name="Path 16789" d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z" transform="translate(-2.875 -466.622)" fill="currentColor"></path>
                                    </g>
                                </g>
                            </svg>
                            <span class="add__to--cart__text"> + Add to cart</span>
                        </button>
                        @else
                        <a class="product__items--action__btn add__to--cart"  href="javascript:void(0)">
                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path></svg>
                            <span class="add__to--cart__text">Out of Stock</span>
                        </a>
                        @endif
                    @else
                        <a class="product__items--action__btn add__to--cart"   {{--onclick="quick_view({{ $product->id }})"--}} href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">
                            <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 14.706 13.534">
                                <g transform="translate(0 0)">
                                    <g>
                                    <path data-name="Path 16787" d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z" transform="translate(0 -463.248)" fill="currentColor"></path>
                                    <path data-name="Path 16788" d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z" transform="translate(-1.191 -466.622)" fill="currentColor"></path>
                                    <path data-name="Path 16789" d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z" transform="translate(-2.875 -466.622)" fill="currentColor"></path>
                                    </g>
                                </g>
                            </svg>
                            <span class="add__to--cart__text"> + Add to cart</span>
                        </a>
                    @endif
                </li>
                <li class="product__items--action__list">
                    <a class="product__items--action__btn" onclick="addToWishlist({{ $product->id }})" href="javascript:void(0)">
                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="25.51" height="23.443" viewBox="0 0 512 512"><path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg> 
                        <span class="visually-hidden">Wishlist</span>
                    </a>
                </li>
                <li class="product__items--action__list">
                    <a class="product__items--action__btn" {{--onclick="quick_view({{ $product->id }})"--}}  href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">
                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg"  width="25.51" height="23.443" viewBox="0 0 512 512"><path d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="256" cy="256" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg>
                        <span class="visually-hidden">Quick View</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
@endif