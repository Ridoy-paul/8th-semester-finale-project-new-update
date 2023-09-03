@extends('user.inc.master')

@section('title')
	Register
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
            <form method="POST" action="{{ route('custom.register') }}">
                @csrf
                <div class="login__section--inner">
                    <input type="hidden" name="register_type" id="register_type" value="phone">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="col">
                                <div class="account__login register">
                                    <div class="account__login--header mb-25 text-center">
                                        <h2 class="account__login--header__title h3 mb-10">Create an Account</h2>
                                        <p class="account__login--header__desc">Register here if you are a new customer</p>
                                    </div>
                                    <div class="account__login--inner">
                                        <input class="account__login--input" placeholder="Name" name="name" value="{{old('name')}}" required type="text">

                                        <input class="account__login--input mb-0" id="phone" name="phone" required value="{{old('phone')}}"  placeholder="Please Enter your phone number" minlength="11" maxlength="11" type="number">
                                        
                                        <input class="account__login--input mb-0" id="email" style="display: none;" value="{{old('email')}}"  name="email" placeholder="Email Addres" type="email">
                                        
                                        <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-end">
                                            <div class="account__login--remember position__relative">
                                                @error('phone')
                                                    <span style="color: #EE2761;">{{ $message }}</span>
                                                @enderror
                                                
                                                @error('email')
                                                    <span style="color: #EE2761;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{--
                                            <button class="account__login--forgot" id="use_email_btn" onclick="use_register_type('email')" type="button">Use Email</button>
                                            <button class="account__login--forgot" id="use_mobile_btn" onclick="use_register_type('phone')" style="display: none;" type="button">Use Mobile Number</button>
                                            --}}
                                        </div>

                                        <input class="account__login--input" placeholder="Password [Min: 8]" name="password" required type="password">
                                        <input class="account__login--input" placeholder="Confirm Password" required name="password_confirmation" type="password">

                                        <div class="account__login--remember position__relative mb-3">
                                            <input class="checkout__checkbox--input" id="check2" required type="checkbox">
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check2">
                                                I have read and agree to the terms &amp; conditions</label>
                                        </div>
                                        <button class="account__login--btn primary__btn mb-10" type="submit">Submit &amp; Register</button>
                                    </div>
                                    <p class="account__login--signup__text">Have an Account? <a type="button" href="{{ route('login') }}" class="account__login--forgot">Login now</a></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3"></div>
                        {{-- <div class="col">
                            <div class="account__login">
                                <div class="account__login--header mb-25">
                                    <h2 class="account__login--header__title h3 mb-10">Login</h2>
                                    <p class="account__login--header__desc">Login if you area a returning customer.</p>
                                </div>
                                <div class="account__login--inner">
                                    <input class="account__login--input" placeholder="Email Addres" type="text">
                                    <input class="account__login--input" placeholder="Password" type="password">
                                    <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                        <div class="account__login--remember position__relative">
                                            <input class="checkout__checkbox--input" id="check1" type="checkbox">
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check1">
                                                Remember me</label>
                                        </div>
                                        <button class="account__login--forgot" type="submit">Forgot Your Password?</button>
                                    </div>
                                    <button class="account__login--btn primary__btn" type="submit">Login</button>
                                    <div class="account__login--divide">
                                        <span class="account__login--divide__text">OR</span>
                                    </div>
                                    <div class="account__social d-flex justify-content-center mb-15">
                                        <a class="account__social--link facebook" target="_blank" href="https://www.facebook.com">Facebook</a>
                                        <a class="account__social--link google" target="_blank" href="https://www.google.com">Google</a>
                                        <a class="account__social--link twitter" target="_blank" href="https://twitter.com">Twitter</a>
                                    </div>
                                    <p class="account__login--signup__text">Don,t Have an Account? <button type="submit">Sign up now</button></p>
                                </div>
                            </div>
                        </div> --}}
                        
                    </div>
                </div>
            </form>
        </div>     
    </div>
    <!-- End login section  -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>

    @if(session('register_type'))
        $( document ).ready(function() {
            use_register_type('{{session('register_type')}}');
        });
    @endif

    function use_register_type(type) {
        
        if(type == 'email') {
            $('#use_mobile_btn').show();
            $('#use_email_btn').hide();
            $('#phone').hide();
            $('#email').show();
            $("#email").prop('required',true);
            $("#phone").prop('required',false);
            $('#register_type').val('email');
        }
        else if(type == 'phone') {
            $('#use_mobile_btn').hide();
            $('#use_email_btn').show();
            $('#phone').show();
            $('#email').hide();
            $("#email").prop('required',false);
            $("#phone").prop('required',true);
            $('#register_type').val('phone');
        }
    }
</script>


@endsection



