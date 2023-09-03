
@extends('user.inc.master')
@section('title')Latest News @endsection
@section('description')Latest News @endsection
@section('keywords')Latest News @endsection
@section('content')

{{--    
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Blog Grid</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Blog Grid</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section --> --}}

    <!-- Start blog section -->
    <section class="blog__section py-5">
        <div class="container">
            <div class="section__heading text-center mb-50">
                <h2 class="section__heading--maintitle">Latest News</h2>
            </div>
            <div class="blog__section--inner">
                <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-sm-u-2 row-cols-1 mb--n10">
                    @foreach($blogs as $blog)
                    <div class="col mb-30 product_col py-3">
                        <div class="blog__items">
                            <div class="blog__thumbnail">
                                <a class="blog__thumbnail--link" href="{{ route('user.blog.details', [$blog->id, Str::slug($blog->title)]) }}"><img class="blog__thumbnail--img" src="{{asset('images/blog/'.optional($blog)->image)}}" alt="{{optional($blog)->title}}"></a>
                            </div>
                            <div class="blog__content">
                                <span class="blog__content--meta">{{date("M d, Y", strtotime(optional($blog)->created_at))}}</span>
                                <h3 class="blog__content--title"><a href="{{ route('user.blog.details', [$blog->id, Str::slug($blog->title)]) }}">{{optional($blog)->title}}</a></h3>
                                <a class="blog__content--btn primary__btn" href="{{ route('user.blog.details', [$blog->id, Str::slug($blog->title)]) }}">Read more </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pagination__area bg__gray--color text-center mt-1">
                    <nav class="pagination justify-content-center">
                        {{ $blogs->links('user.partials.pagination') }}
                    </nav>
                    <div style="margin-top: 10px !important;">
                        <span class="fw-bold">Showing {{$blogs->firstItem()}} to {{$blogs->lastItem()}} of {{$blogs->total()}} News</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- End blog section -->
@endsection