
@extends('user.inc.master')
@section('title'){{optional($blog_details)->title}} @endsection
@section('description'){{optional($blog_details)->meta_description}} @endsection
@section('keywords'){{optional($blog_details)->meta_keywords}} @endsection
@section('content')

{{-- 
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Blog Details</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Blog Details</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section --> --}}

    <!-- Start blog details section -->
    <section class="blog__details--section py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12">
                    <div class="blog__details--wrapper">
                        <div class="entry__blog">
                            <div class="blog__post--header mb-30">
                                <h2 class="post__header--title mb-15">{{optional($blog_details)->title}}</h2>
                                <p class="blog__post--meta">Posted by : Anizor BD / On : {{date("M d, Y", strtotime(optional($blog_details)->created_at))}}</p>                                     
                            </div>
                            <div class="blog__thumbnail mb-30">
                                <img class="blog__thumbnail--img border-radius-10" src="{{asset('images/blog/'.optional($blog_details)->image)}}" alt="{{optional($blog_details)->title}}">
                            </div>
                            <div class="blog__details--content">
                                {!!optional($blog_details)->description!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End blog details section -->
@endsection