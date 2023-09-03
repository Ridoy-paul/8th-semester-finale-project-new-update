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
            <form method="POST" action="{{ route('verify.phone') }}">
                @csrf
                <div class="login__section--inner">
                    <input type="hidden" name="custom_token" id="custom_token" value="{{$user_id}}">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="col">
                                <div class="account__login register">
                                    <div class="account__login--header mb-25 text-center">
                                        <h2 class="account__login--header__title h3 mb-10">Verify Your Account</h2>
                                        <p class="account__login--header__desc"></p>
                                    </div>
                                    <div class="account__login--inner">

                                        <input class="account__login--input mb-1" id="code" name="code" required value="{{old('code')}}"  placeholder="Please Enter Verification Code" type="number">
                                        <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                            <div class="account__login--remember position__relative">
                                                <a href="javascript:void(0)" onclick="resend_code()" class="account__login--forgot" type="button">Resend Code</a>
                                            </div>
                                            <a href="javascript:void(0)" id="processing_btn" style="display: none;" class="account__login--forgot" type="button">Processing...</a>
                                        </div>
                                        
                                        <button class="account__login--btn primary__btn mb-10" type="submit">Verify</button>
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

    <script src="{{asset('js/jquery.min.js')}}" integrity="" crossorigin="anonymous"></script>
    <script>
        function resend_code(){
            let custom_token = $('#custom_token').val();
            $.ajax({
                type: 'get',
                url: '{{route('resend.verification.code')}}',
                data: {
                    'custom_token': custom_token,
                },
                beforeSend: function() {
                    $('#processing_btn').show();
                },
                success: function (data) {
                    $('#processing_btn').hide();
                    success('New verification code sent.');
                }
            });
        }
    </script>




@endsection


@section('scripts')

@endsection

