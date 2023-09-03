
@extends('user.inc.master')
@section('title')Wishlist @endsection
@section('description')Wishlist  @endsection
@section('keywords')Wishlist @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container-fluid">

        <div class="my__account--section__inner border-radius-10 d-flex p-5">
            @include('user.pages.customer.account_sidebar')
            
            <div class="account__wrapper">
                <div class="account__content">
                    <h2 class="account__content--title h3 mb-20">My Wishlist</h2>
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 10%">S.N</th>
                                <th style="width: 30%">Product</th>
                                <th style="width: 20%">Image</th>
                                <th style="width: 40%; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wishlists as $wishlist)
                            @if(!is_null($wishlist->product))
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $wishlist->product->title }}</td>
                                <td><img class="shadow rounded p-1" src="{{ asset('images/product/'.$wishlist->product->thumbnail_image) }}" width="80px"></td>
                                <td style="text-align: center;">
                                <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST">
                                    @csrf
                                    <a @if($wishlist->product->type == 'single') onclick="addToCart({{ $wishlist->product->id }})" @else {{--onclick="quick_view({{ $wishlist->product->id }})"--}} href="{{ route('single.product', [$wishlist->product->id, Str::slug($wishlist->product->title)]) }}" @endif class="continue__shipping--btn primary__btn border-radius-5 rounded-pill" style="color: #fff;">Add To Cart</a>
                                    <button class="cart__remove--btn">
                                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path></svg>
                                    </button>
                                </form>
                                </td>
                            </tr>
                            @else

                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    
</script>
@endsection