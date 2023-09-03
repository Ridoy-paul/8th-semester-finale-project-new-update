
@extends('user.inc.master')
@section('title'){{optional($flash_sale_offer)->title}} @endsection
@section('description'){{optional($flash_sale_offer)->title}}  @endsection
@section('keywords'){{optional($flash_sale_offer)->title}} @endsection
@section('content')
@if(!is_null($flash_sale_offer))
@php
    $start_date_time = optional($flash_sale_offer)->start_date_time;
    $end_date_time = optional($flash_sale_offer)->end_date_time;
    $now = now();

    $running_time = strtotime($start_date_time) - strtotime($now);

    $end_time = strtotime($end_date_time) - strtotime($now);
@endphp
@if($running_time < 0 && $end_time > 0)
{{-- this is running offer in current time  --}}
<style>
    .countdown__item {
        height: 35px !important;
        width: 50px !important;
        background: none !important;
        border: 1px solid #FA911A;
        margin-right: 1rem !important;
    }

    .countdown__item::before {
        right: 0rem !important;
        top: 45% !important;
        display: none !important;
    }

    .countdown__number {
        color: #030202;
        font-size: 20px !important;
        font-weight: bold !important;
        line-height: 20px !important;
    }

    @media screen and (max-width: 700px) {
        .shop_more_btn {
            font-size: 1.7rem !important;
            line-height: 3rem !important;
            height: 3rem !important;
            padding: 0px 10px !important;
        }
    }

</style>

<section class="deals__banner--section py-4">
    <div class="container-fluid">
        <div class="deals__banner--inner banner__bg rounded" style="background: url({{asset('images/product/'.optional($flash_sale_offer)->image)}}) !important;">
            <div class="row row-cols-1 align-items-center">
                <div class="col">
                    <div class="deals__banner--content position__relative">
                        <h2 class="deals__banner--content__maintitle">{{optional($flash_sale_offer)->title}}</h2>
                        {!!optional($flash_sale_offer)->description!!}
                        <div class="">
                            <p class="mb-2 text__secondary">Ends On,</p>
                            <div class="deals__banner--countdown mb-2 ms-2 d-flex"><div class="countdown__item" id="d_item"><span class="countdown__number" id="days">00</span></div><div class="countdown__item" id="h_item"><span class="countdown__number" id="hours">00</span></div><div class="countdown__item" id="m_item"><span class="countdown__number" id="minutes">00</span></div><div class="countdown__item" id="s_item"><span class="countdown__number" id="seconds">00</span></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product__section section--padding pt-3" style="padding-bottom: 4rem !important;">
    <div class="container-fluid">
        <div class="product__section--inner">
            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                @foreach($products as $item)
                @php( $product = App\Models\Product::where('id', $item->product_id)->first(['id', 'discount_type', 'type', 'title', 'thumbnail_image']) )
                    @if(!is_null($product))
                        @include('user.partials.product')
                    @endif
                @endforeach
            </div>
            <div class="pagination__area bg__gray--color text-center mt-1">
                <nav class="pagination justify-content-center">
                    {{ $products->links('user.partials.pagination') }}
                </nav>
                <div style="margin-top: 10px !important;">
                    <span class="fw-bold">Showing {{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} Products</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    // Set the date we're counting down to
    var countDownDate = new Date("{{date('M d, Y H:i:s', strtotime($end_date_time))}}").getTime();
    
    // Update the count down every 1 second
    var x = setInterval(function() {
    
      // Get today's date and time
      var now = new Date().getTime();
        
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
        
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
      // Output the result in an element with id="demo"
      
      if(days == 0) { $('#d_item').hide(); }
      if(hours == 0) { $('#h_item').hide(); }
      document.getElementById("days").innerHTML = days + "d";
      document.getElementById("hours").innerHTML = hours + "h";
      document.getElementById("minutes").innerHTML = minutes + "m";
      document.getElementById("seconds").innerHTML = seconds + "s";
        
      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        //document.getElementById("demo").innerHTML = "EXPIRED";
      }
    }, 1000);
</script>

@elseif($running_time > 0 && $end_time > 0)
{{-- this is for comming flash sale offer  --}}
<section class="deals__banner--section py-4">
    <div class="container-fluid">
        <div class="deals__banner--inner banner__bg" style="background: url({{asset('images/product/'.optional($flash_sale_offer)->image)}}) !important;">
            <div class="row row-cols-1 align-items-center">
                <div class="col">
                    <div class="deals__banner--content position__relative">
                        <span class="deals__banner--content__subtitle text__secondary">Coming Soon.</span>
                        <h2 class="deals__banner--content__maintitle">{{optional($flash_sale_offer)->title}}</h2>
                        {!!optional($flash_sale_offer)->description!!}
                        <p class="mb-2 text__secondary">Start On,</p>
                        <h1 class="deals__banner--content__maintitle color-animation">{{date("M d, Y. H:i:s A", strtotime(optional($flash_sale_offer)->start_date_time))}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
@endif
@endsection