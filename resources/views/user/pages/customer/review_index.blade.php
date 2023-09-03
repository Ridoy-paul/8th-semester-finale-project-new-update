
@extends('user.inc.master')
@section('title')My Reviews @endsection
@section('description')My Reviews  @endsection
@section('keywords')My Reviews @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container-fluid">

        <div class="my__account--section__inner border-radius-10 d-flex p-5">
            @include('user.pages.customer.account_sidebar')
            
            <div class="account__wrapper">
                <div class="account__content">
                    {{-- <h2 class="account__content--title h3 mb-20">Account Details</h2> --}}
                    <div class="account__table--area">
                        <div class="shadow mt-3 p-4 mb-3 rounded">
                            <h3 class="font-weight-bold mb-3 text-danger">Reviews</h3>
                            <div class="cart__table py-2">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th class="cart__table--header__list">Product</th>
                                            <th class="cart__table--header__list text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body">
                                    @foreach($orders as $order)
                                        @if(count($order->order_product) > 0)
                                        @foreach($order->order_product as $product)
                                        @php
                                            $check_review = DB::table('products_reviews')->where(['customer_id'=>$user_info->id, 'order_code'=>$order->code, 'product_id'=>optional($product->product)->id, 'order_product_id'=>$product->id])->first();
                                            $variation_info = '';
                                            if($product->variations <> 0) {
                                                $stock_info = variation_stock_info($product->variations);
                                                if(!is_null($stock_info)) {
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
                                            }
                                        @endphp
                                        
                                        <tr class="cart__table--body__items mb-2">
                                            <td class="cart__table--body__list">
                                                <div class="cart__product d-flex align-items-center">
                                                    <div class="cart__thumbnail">
                                                        <a href="#"><img class="border-radius-5 shadow rounded p-1" src="{{ asset('images/product/'.optional($product->product)->thumbnail_image) }}" alt="cart-product"></a>
                                                    </div>
                                                    <div class="cart__content">
                                                        <h4 class="cart__content--title"><a href="#">{{optional($product->product)->title}}</a></h4>
                                                        <span class="cart__content--variant">{!!$variation_info!!}</span>
                                                        <span class="cart__content--variant"><b>Code: </b>{{$order->code}}</span>
                                                        <span class="cart__content--variant"><b>Date: </b>{{date("d M Y.", strtotime($order->created_at))}}</span>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list text-center">
                                                @if(is_null($check_review))
                                                    <a class="wishlist__cart--btn primary__btn" href="{{route('write.review', ['order_product_order_id'=>$product->id])}}">Write Review</a>
                                                @else
                                                    @if(optional($check_review)->is_active == 0)
                                                        <span class="text-light rounded-pill bg-warning px-3">Pending</span>
                                                    @elseif(optional($check_review)->is_active == 1)
                                                        <span class="text-light rounded-pill bg-success px-3">Active</span>
                                                    @elseif(optional($check_review)->is_active == 2)
                                                        <span class="text-light rounded-pill bg-danger px-3">Canceled</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        @endif
                                    @endforeach                                                                                                            
                                    </tbody>
                                </table>
                                
                                <div class="continue__shopping">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                            
                    </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    
</script>
@endsection