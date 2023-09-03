{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('user.inc.master')

@section('title')
	Login
@endsection

@section('content')
<style>
    @media only screen and (max-width: 768px) { 
        .sign_in_top{
            padding-top: 0px !important;
        }
    }
</style>

    <!-- Start login section  -->
    <div class="login__section py-5 border-top sign_in_top">
        <div class="container">
            <form method="POST" action="javascript:void(0)" id="reset_password_form">
                @csrf
                <div class="login__section--inner">
                    <input type="hidden" name="otp_code" id="otp_code">
                    <input type="hidden" name="user_id" id="user_id">
                    
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="col">
                                <div class="account__login register">
                                    <div class="account__login--header mb-25 text-center">
                                        <h2 class="account__login--header__title h3 mb-10">Password Reset</h2>
                                        <p class="account__login--header__desc"></p>
                                    </div>
                                    <div class="account__login--inner">

                                        <input class="account__login--input mb-3" id="phone" name="phone"   placeholder="Please Enter phone number" type="number">
                                        <button class="primary__btn mb-3 shop_more_btn" onclick="sendOTP()" id="send_otp_button" type="button">Send OTP</button>
                                        <span class="account__login--forgot py-1" id="send_otp_text"></span>

                                        <div class="row" id="otp_section" style="display:none;">
                                            <div class="col-md-12 col-12">
                                                <input class="account__login--input mb-3" id="user_otp" name="user_otp"  placeholder="OTP" type="number">
                                                <div class="text-right">
                                                    <a class="account__login--forgot" href="javascript:void(0)" onclick="sendOTP()" id="send_otp_text">Resend OTP</a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <button class="primary__btn mb-3 shop_more_btn" onclick="verify_otp()" id="send_otp_button" type="button">Verify OTP</button>
                                            </div>
                                        </div>
                                        <div class="row" id="password_section" style="display:none;">
                                            <div class="col-md-12">
                                                <label for="">Password (Minimum Length 8)</label>
                                                <input class="account__login--input mb-3" minlength="8" id="password" name="password" required placeholder="New Password" type="password">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="">Confirm Password (Minimum Length 8)</label>
                                                <input class="account__login--input mb-3" minlength="8" id="confirm_password" name="confirm_password" required placeholder="Confirm Password" type="password">
                                            </div>
                                            <div class="col-md-12">
                                                <button class="primary__btn mb-3 shop_more_btn" type="button" onclick="password_reset_confirm()">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3"></div>
                        
                    </div>
                </div>
            </form>
        </div>     
    </div>
    <!-- End login section  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function sendOTP() {
            let phone = $('#phone').val();
            if(phone == '') {
                error("Please Enter Your Phone number.");
                return 0;
            }

            $.ajax({
                type: 'get',
                url: '{{route('forgot.pass.send.otp')}}',
                data: {
                    'phone': phone,
                },
                beforeSend: function() {
                    $('#send_otp_text').text('Processing....');
                },
                success: function (data) {
                    if(data.status == 'yes') {
                        $('#send_otp_button').hide();
                        $('#send_otp_text').text(data.reason);
                        $('#otp_section').show();
                        $('#user_id').val(data.user_id);
                        $('#otp_code').val(data.otp);
                        success(data.reason);
                    }
                    else {
                        $('#send_otp_text').text('');
                        error(data.reason);
                    }
                }
            });

        }

        function verify_otp() {
            let otp = $('#otp_code').val();
            let user_otp = $('#user_otp').val();
            if(user_otp != '') {
                if(otp == user_otp) {
                    $('#password_section').show();
                    $('#otp_section').hide();
                    $('#send_otp_text').text('');
                    success('OTP Matched.');
                }
                else {
                    error('Invalid OTP!');
                }
            }
            else {
                error('Please enter OTP.');
            }
        }

        function password_reset_confirm() {
            if (document.getElementById("reset_password_form").checkValidity()) { 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('pass.reset.confirm')}}",
                    type: "POST",
                    data: $('#reset_password_form').serialize(),
                    success:function(response){
                        if(response.status == 'yes') {
                            success(response.reason);
                            window.location.href = '{{route('customer.account')}}';
                        }
                        else {
                            error(response.reason);
                        }
                    }
                });
            }
            else {
                error('Something is missing!');
            }
        }
    </script>


@endsection

