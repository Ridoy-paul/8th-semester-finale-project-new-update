
@extends('user.inc.master')
@section('title')Error 500 @endsection
@section('description')Error 500  @endsection
@section('keywords')Error 500 @endsection
@section('content')
<section class="my__account--section py-5">
    <div class="container">
        <div class="--section__inner p-3 rounded">
            <div class="row">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="error__content text-center py-5">
                            <img class="error__content--img mb-50" width="250px" src="{{asset('assets/images/error404.png')}}" alt="error-img">
                            <h2 class="error__content--title my-5">Error 500!</h2>
                            <a class="error__content--btn primary__btn" href="{{route('index')}}">Back To Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection