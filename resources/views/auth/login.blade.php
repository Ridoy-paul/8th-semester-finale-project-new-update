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
            <form method="POST" action="{{ route('custom.login') }}">
                @csrf
                <div class="login__section--inner">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="col">
                                <div class="account__login register">
                                    <div class="account__login--header mb-25 text-center">
                                        <h2 class="account__login--header__title h3 mb-10">Login Your Account</h2>
                                        <p class="account__login--header__desc"></p>
                                    </div>
                                    <div class="account__login--inner">

                                        <input class="account__login--input mb-0" id="userName" name="userName" required value="{{old('userName')}}"  placeholder="Please Enter Email or phone number" type="text">
                                        @error('userName')
                                            <span style="color: #EE2761;">{{ $message }}</span>
                                        @enderror
                                        
                                        <input class="account__login--input mt-3 mb-1" placeholder="Password" name="password" required type="password">
                                        <div class="account__login--remember__forgot mb-15  text-right">
                                            {{-- <div class="account__login--remember position__relative">
                                                <input class="checkout__checkbox--input" id="check1" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <span class="checkout__checkbox--checkmark"></span>
                                                <label class="checkout__checkbox--label login__remember--label" for="check1">
                                                    Remember me</label>
                                            </div> --}}
                                            <a href="{{ route('password.request') }}" class="account__login--forgot" type="button">Forgot Password?</a>
                                        </div>
                                        <button class="account__login--btn primary__btn mb-10" type="submit">Login</button>
                                    </div>
                                    <p class="account__login--signup__text">Don,t Have an Account? <a type="button" href="{{ route('register') }}" class="account__login--forgot">Register now</a></p>
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
@endsection

