
@extends('user.inc.master')
@section('title'){{$page_info->name}} @endsection
@section('description'){{$page_info->name}}  @endsection
@section('keywords'){{$page_info->name}} @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container-fluid">
        <div class="my__account--section__inner p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="account__wrapper account__wrapper--style4 border-radius-10">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">{{$page_info->name}}</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    {!!$page_info->description!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection