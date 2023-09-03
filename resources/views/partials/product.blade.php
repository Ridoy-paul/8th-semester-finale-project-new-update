@if(!empty($product))

    <div class="product-wrap product text-center" style="">
        <div style="border: 1px solid blue;padding-bottom: 15px;margin: 0px 5px;">
        <figure class="product-media">
            <a href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">
                <img src="{{ asset('images/product/'. $product->image) }}" alt="Product"
                    width="216" height="243" />
            </a>
            <div class="product-action-vertical">
                <a onclick="addToCart({{ $product->id }})" class="btn-product-icon w-icon-cart peoduct_cart"
                    title="Add to cart"></a>
                <a onclick="addToWishlist({{ $product->id }})" class="btn-product-icon w-icon-heart peoduct_cart"
                    title="Add to wishlist"></a>
                <!-- <a href="#" class="btn-product-icon btn-quickview w-icon-search" title="Quickview"></a> -->
                <!-- <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                    title="Add to Compare"></a> -->
            </div>
        </figure>
        <div class="product-details">
            <h4 class="product-name"><a href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">{{ $product->title }}</a>
            </h4>
            <p style="font-size: 20px;">{{ $product->weight }} {{ $product->unit }}</p>
            
            <!-- <div class="ratings-container">
                <div class="ratings-full">
                    <span class="ratings" style="width: 100%;"></span>
                    <span class="tooltiptext tooltip-top"></span>
                </div>
                <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
            </div> -->
            <div class="product-price">
            	@if($product->type == 'single')
                    @if($product->is_sale == 1)
                        <ins class="new-price">{{ env('CURRENCY') }} {{ $product->discount_price }} {{ env('UAE_CURRENCY') }}</ins><del class="old-price">{{ env('CURRENCY') }} {{ $product->price }} {{ env('UAE_CURRENCY') }}</del>
                    @else
                        <ins class="new-price">{{ env('CURRENCY') }} {{ $product->price }} {{ env('UAE_CURRENCY') }}</ins><!-- <del class="old-price">$25.68</del> -->
                    @endif
                
                @else

                	@if(count($product->variation) == 1)
                		<ins class="new-price">{{ env('CURRENCY') }} {{ $product->variation->first()->price }} {{ env('UAE_CURRENCY') }}</ins>
                	@else
                		<ins class="new-price">{{ env('CURRENCY') }} {{ $product->variation->where('price', $product->variation->min('price'))->first()->price }} {{ env('UAE_CURRENCY') }} - {{ env('CURRENCY') }} {{ $product->variation->where('price', $product->variation->max('price'))->first()->price }} {{ env('UAE_CURRENCY') }}</ins>
                	@endif

                @endif
            </div>
            <button onclick="addToCart({{ $product->id }})" class="add-to-cart-btn btn btn-primary added_to_cart_{{ $product->id }} {{ !is_null(Cart::content()->where('id', $product->id)->first()) ? 'added_to_cart' : '' }}" id="">{{ !is_null(Cart::content()->where('id', $product->id)->first()) ? 'Added To Cart' : 'Add to Cart' }}</button>
        </div>
        </div>
    </div>


@endif