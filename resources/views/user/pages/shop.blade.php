
@extends('user.inc.master')
@section('title')Shop @endsection
@section('description')Shop, all-products, discount-products, offer-products, offer, new-year-offer  @endsection
@section('keywords')Shop, all-products, discount-products, offer-products, offer, new-year-offer @endsection
@section('content')

<form action="javascript:void(0)" id="filter_form">
    @csrf
    <input type="hidden" id="brand_array" name="brand_array">
    <input type="hidden" id="lastID" name="lastID" value="1200">
    <input type="hidden" id="is_discount" name="is_discount" value="0">
    <input type="hidden" id="new_arrival" name="new_arrival" value="0">
    <input type="hidden" id="category_id" name="category_id" value="{{!is_null($request_category)? $request_category : 0}}">
    <input type="hidden" id="load_more" name="" value="0">
</form>

    <div class="offcanvas__filter--sidebar widget__area">
        <button type="button" class="offcanvas__filter--close m-2" data-offcanvas="">
            <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path></svg> <span class="offcanvas__filter--close__text">Close</span>
        </button>
        <div class="offcanvas__filter--sidebar__inner" id="mobile_filter">
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3">Categories</h2>
                <ul class="widget__categories--menu">
                    @foreach($categories as $category)
                        @if(count($category->child) > 0)
                        {{-- sub category exist --}}
                            <li class="widget__categories--menu__list">
                                {{-- main category with sub category  --}}
                                <label class="widget__categories--menu__label d-flex align-items-center">
                                    <img class="widget__categories--menu__img" src="{{ asset('images/category/'.$category->image ) }}" alt="{{$category->title}}">
                                    <span class="widget__categories--menu__text">{{$category->title}}</span>
                                    <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                        <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                    </svg>
                                </label>
                                <ul class="widget__categories--sub__menu">
                                    @foreach($category->child as $p_category)
                                        @if(count($p_category->child) > 0)
                                        <li class="widget__categories--menu__list ms-2 me-1">
                                            {{-- sub category with sub sub category  --}}
                                            <label class="widget__categories--menu__label d-flex align-items-center">
                                                <img class="widget__categories--menu__img" src="{{ asset('images/category/'.$p_category->image ) }}" alt="{{$p_category->title}}">
                                                <span class="widget__categories--menu__text">{{$p_category->title}}</span>
                                                <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                                </svg>
                                            </label>
                                            <ul class="widget__categories--sub__menu">
                                                @foreach($p_category->child as $inner_sub_category)
                                                <li class="widget__categories--sub__menu--list ms-2">
                                                    <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('products', ['category_id'=>$inner_sub_category->id])}}">
                                                        <img class="widget__categories--sub__menu--img" src="{{ asset('images/category/'.$inner_sub_category->image ) }}" alt="{{$inner_sub_category->title}}">
                                                        <span class="widget__categories--sub__menu--text">{{$inner_sub_category->title}}</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                                
                                            </ul>
                                        </li>
                                        @else
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('products', ['category_id'=>$p_category->id])}}">
                                                    <img class="widget__categories--sub__menu--img rounded shadow" src="{{ asset('images/category/'.$p_category->image ) }}" alt="{{$p_category->title}}">
                                                    <span class="widget__categories--sub__menu--text">{{$p_category->title}}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('products', ['category_id'=>$category->id])}}">
                                    <img class="widget__categories--sub__menu--img rounded shadow" src="{{ asset('images/category/'.$category->image ) }}" alt="{{$category->title}}">
                                    <span class="widget__categories--sub__menu--text">{{$category->title}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3 mb-1">Brands</h2>
                <ul class="widget__form--check">
                    @foreach($brands as $brand)
                    <li class="widget__form--check__list">
                        <label class="widget__form--check__label" for="brand_{{$brand->id}}">{{$brand->title}}</label>
                        <input value="{{$brand->id}}" @if($brand->id == $request_brand) checked @endif class="widget__form--check__input cls_brand_{{$brand->id}} brands" id="brand_{{$brand->id}}" type="checkbox">
                        <span class="widget__form--checkmark"></span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Start shop section -->
    <section class="shop__section py-3">
        <div class="container-fluid">
            <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between p-2 mb-10">
                <button class="widget__filter--btn d-flex d-lg-none align-items-center" data-offcanvas="">
                    <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80"></path><circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle><circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle><circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle></svg> 
                    <span class="widget__filter--btn__text">Filter</span>
                </button>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="shop__sidebar--widget widget__area d-none d-lg-block" id="desktop_filter">
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Categories</h2>
                            <ul class="widget__categories--menu">
                                @foreach($categories as $category)
                                    @if(count($category->child) > 0)
                                    {{-- sub category exist --}}
                                        <li class="widget__categories--menu__list">
                                            {{-- main category with sub category  --}}
                                            <label class="widget__categories--menu__label d-flex align-items-center">
                                                <img class="widget__categories--menu__img" src="{{ asset('images/category/'.$category->image ) }}" alt="{{$category->title}}">
                                                <span class="widget__categories--menu__text">{{$category->title}}</span>
                                                <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                                </svg>
                                            </label>
                                            <ul class="widget__categories--sub__menu">
                                                @foreach($category->child as $p_category)
                                                    @if(count($p_category->child) > 0)
                                                    <li class="widget__categories--menu__list ms-2 me-1">
                                                        {{-- sub category with sub sub category  --}}
                                                        <label class="widget__categories--menu__label d-flex align-items-center">
                                                            <img class="widget__categories--menu__img" src="{{ asset('images/category/'.$p_category->image ) }}" alt="{{$p_category->title}}">
                                                            <span class="widget__categories--menu__text">{{$p_category->title}}</span>
                                                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                                            </svg>
                                                        </label>
                                                        <ul class="widget__categories--sub__menu">
                                                            @foreach($p_category->child as $inner_sub_category)
                                                            <li class="widget__categories--sub__menu--list ms-2">
                                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('products', ['category_id'=>$inner_sub_category->id])}}">
                                                                    <img class="widget__categories--sub__menu--img" src="{{ asset('images/category/'.$inner_sub_category->image ) }}" alt="{{$inner_sub_category->title}}">
                                                                    <span class="widget__categories--sub__menu--text">{{$inner_sub_category->title}}</span>
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                            
                                                        </ul>
                                                    </li>
                                                    @else
                                                        <li class="widget__categories--sub__menu--list">
                                                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('products', ['category_id'=>$p_category->id])}}">
                                                                <img class="widget__categories--sub__menu--img rounded shadow" src="{{ asset('images/category/'.$p_category->image ) }}" alt="{{$p_category->title}}">
                                                                <span class="widget__categories--sub__menu--text">{{$p_category->title}}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li class="widget__categories--sub__menu--list">
                                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('products', ['category_id'=>$category->id])}}">
                                                <img class="widget__categories--sub__menu--img rounded shadow" src="{{ asset('images/category/'.$category->image ) }}" alt="{{$category->title}}">
                                                <span class="widget__categories--sub__menu--text">{{$category->title}}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3 mb-1">Brands</h2>
                            <ul class="widget__form--check">
                                @foreach($brands as $brand)
                                <li class="widget__form--check__list">
                                    <label class="widget__form--check__label" for="brand_{{$brand->id}}">{{$brand->title}}</label>
                                    <input value="{{$brand->id}}" @if($brand->id == $request_brand) checked @endif class="widget__form--check__input cls_brand_{{$brand->id}} brands"  id="brand_{{$brand->id}}" type="checkbox">
                                    <span class="widget__form--checkmark"></span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        {{-- <div class="single__widget price__filter widget__bg">
                            <h2 class="widget__title h3">Filter By Price</h2>
                            <form class="price__filter--form" action="#"> 
                                <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                    <div class="price__filter--group">
                                        <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                                        <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                            <span class="price__filter--currency">$</span>
                                            <label>
                                                <input class="price__filter--input__field border-0" name="filter.v.price.gte" type="number" placeholder="0" min="0" max="250.00">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="price__divider">
                                        <span>-</span>
                                    </div>
                                    <div class="price__filter--group">
                                        <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                                        <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                            <span class="price__filter--currency">$</span>
                                            <label>
                                                <input class="price__filter--input__field border-0" name="filter.v.price.lte" type="number" min="0" placeholder="250.00" max="250.00"> 
                                            </label>
                                        </div>	
                                    </div>
                                </div>
                                <button class="price__filter--btn primary__btn" type="submit">Filter</button>
                            </form>
                        </div> --}}
                        
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="shop__product--wrapper">
                        <div class="tab_content">
                            <div id="product_grid" class="tab_pane active show">
                                <div class="product__section--inner product__grid--inner">
                                    <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30" id="product_body">
                                        
                                    </div>
                                    <div class="row mt-3" id="loading_div"></div>
                                    <div class="row mb-5 text-center mt-3" id="load_more_div" style="display: none;">
                                        <div class="cart-action mb-6 pt-3 pb-3">
                                            <a href="javascript:void(0)" type="button" onclick="load_more()" class="continue__shipping--btn primary__btn border-radius-5"><i class="w-icon-long-arrow-left"></i>Load More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        let window_width = $(document).width();
        if(window_width > 991) {
            $('#mobile_filter').html('');
        }
        else {
            $('#desktop_filter').html('');
        }
        order_ready();
    });

    $(".brands").change(function() {
        $('#load_more').val(0);
        $('#lastID').val(1200);
        order_ready();
    });

  function selected_brands() {
    var brands = new Array();
    $('.brands:checked').each(function() {
      brands.push($(this).val());
    });
    if(brands.length > 0) {
      $('#brand_array').val(brands);
    }
    else {
      $('#brand_array').val(0);
    }
  }

  function order_ready() {
    selected_brands();
    order_confirm();
  }

  function load_more() {
    $('#load_more').val(1);
    order_ready();
  }


  function order_confirm() {

    // e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('shop.products.data')}}",
            method: 'post',
            data: $('#filter_form').serialize(),
            beforeSend: function() {
                $('#loading_div').html('<div class="col-md-12" style="width: 100% !important;"><div class="text-center p-10"><h2><b>Loading....</b></h2></div></div>');
            },
            success: function(response){
                console.log(response);
                if(response.noMorePSts == 'no') {
                    $('#loading_div').html('');
                    $('#lastID').val(response.upLastID);
                    if($('#load_more').val() == 1) {
                        $('#product_body').append(response.output);
                    }
                    else {
                        $('#product_body').html(response.output);
                    }

                    $('#load_more_div').show();
                }
                else {
                    $('#product_body').append(response.output);
                    $('#load_more_div').hide();
                    $('#loading_div').html('');
                }
            }
        });
       
  }

</script>

@endsection