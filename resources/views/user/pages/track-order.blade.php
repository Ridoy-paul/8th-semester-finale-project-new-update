
@extends('user.inc.master')
@section('title')Track Order @endsection
@section('description')Track Order  @endsection
@section('keywords')Track Order @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container">
        <div class="my__account--section__inner p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="account__wrapper account__wrapper--style4 border-radius-10">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">Track Your Orders</h2>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <form action="{{ route('order.track.result') }}" method="GET">
                                        @csrf
                                        <div class="row my-5 px-3" style="margin-bottom: 20px !important;">
                                            <div class="col-md-8 col-8 mb-5 text-end">
                                                <input type="text" required name="code" placeholder="Enter Order Code" class="checkout__input--field border-radius-5">
                                            </div>
                                            <div class="col-md-4 col-4 mb-10 text-start">
                                                <button class="coupon__code--field__btn primary__btn" type="submit">Track Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2"></div>
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