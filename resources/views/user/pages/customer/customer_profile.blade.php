
@extends('user.inc.master')
@section('title')My Profile @endsection
@section('description')My Profile  @endsection
@section('keywords')My Profile @endsection
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
                        <form class="form account-details-form" action="{{ route('customer.account.update', Auth::id()) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h3 class="font-weight-bold mb-3 text-danger">Account Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                            class="checkout__input--field border-radius-5 mb-3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" readonly id="phone" name="phone" value="{{ Auth::user()->phone }}"
                                            class="checkout__input--field border-radius-5 mb-3">
                                    </div>
                                </div>
                            </div>
                        
    
                            <div class="form-group mb-6">
                                <label for="email_1">Email address</label>
                                <input type="email" id="email_1" value="{{ Auth::user()->email }}" name="email" class="checkout__input--field border-radius-5 mb-3" readonly>
                            </div>
    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" id="image" name="image" class="checkout__input--field border-radius-5 mb-3">
                                        @if(Auth::user()->image != NULL)
                                        <img class="shadow rounded p-2" src="{{ asset('images/customer/'.Auth::user()->image) }}">
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nid">NID (Scan copy of your NID)</label>
                                        <input type="file" id="nid" name="nid" class="checkout__input--field border-radius-5 mb-3">
                                        @if(Auth::user()->nid != NULL)
                                        <img src="{{ asset('images/customer/nid/'.Auth::user()->nid) }}">
                                        @endif
                                    </div>
                                </div> --}}
                            </div>
    
                            <div class="form-group mb-3">
                                <label for="display-name">Address *</label>
                                <input type="text" id="display-name" name="address" value="{{ Auth::user()->address }}" class="checkout__input--field border-radius-5 mb-3 mb-0">
                            </div>
                            <button type="submit" class="continue__shipping--btn primary__btn border-radius-5">Save Changes</button>
                        </form>
                    </div>

                        <div class="shadow mt-5 p-4 rounded">
                            <form class="form account-details-form" action="{{ route('customer.password.change') }}" method="post">
                                @csrf
                                <h3 class="font-weight-bold mb-3 text-danger">Password change</h3>
                                <div class="form-group">
                                    <label class="text-dark" for="cur-password"><span class="text-danger">*</span>Current Password</label>
                                    <input type="password" required class="checkout__input--field border-radius-5 mb-3"
                                        id="cur-password" name="c_password">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark" for="new-password"><span class="text-danger">*</span>New Password</label>
                                    <input type="password" required class="checkout__input--field border-radius-5 mb-3"
                                        id="new-password" name="n_password">
                                </div>
                                <div class="form-group mb-10">
                                    <label class="text-dark" for="conf-password"><span class="text-danger">*</span>Confirm Password</label>
                                    <input type="password" required class="checkout__input--field border-radius-5 mb-3"
                                        id="conf-password" name="cf_password">
                                </div>
                                <button type="submit" class="continue__shipping--btn primary__btn border-radius-5">Save Changes</button>
                            </form>
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