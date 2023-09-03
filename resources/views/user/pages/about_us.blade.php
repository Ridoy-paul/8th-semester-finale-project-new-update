
@extends('user.inc.master')
@section('title')About Us @endsection
@section('description')About Us @endsection
@section('keywords')About Us @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container-fluid">
        <div class="my__account--section__inner p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="account__wrapper account__wrapper--style4 border-radius-10">
                        <div class="account__content p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="blog__thumbnail mb-30">
                                        <img class="blog__thumbnail--img border-radius-10" src="{{ asset('images/website/'.optional($info)->image) }}" alt="blog-img">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="about__content">
                                        <span class="about__content--subtitle text__secondary mb-10"> About Us</span>
                                        {!!optional($info)->about_us_text!!}
                                    </div>
                                </div>
                                <div class="col-md-12 mb-5">
                                    <div class="about__content">
                                        <span class="about__content--subtitle text__secondary mb-10"> Our Mission</span>
                                        {!!optional($info)->mission!!}
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="about__content">
                                        <span class="about__content--subtitle text__secondary mb-10"> Our Vision</span>
                                        {!!optional($info)->vission!!}
                                    </div>
                                </div>
                                @if(optional($info)->custom_block_title <> '')
                                <div class="col-md-12 mb-3">
                                    <div class="about__content">
                                        <span class="about__content--subtitle text__secondary mb-10"> {{optional($info)->custom_block_title}}</span>
                                        {!!optional($info)->custom_block_details!!}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection