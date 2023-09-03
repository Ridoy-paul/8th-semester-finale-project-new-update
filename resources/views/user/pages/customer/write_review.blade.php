
@extends('user.inc.master')
@section('title')Write Review @endsection
@section('description')Write Review  @endsection
@section('keywords')Write Review @endsection
@section('content')

<section class="my__account--section py-5">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/starrr.css')}}">

    <div class="container-fluid">

        <div class="my__account--section__inner border-radius-10 d-flex p-5">
            @include('user.pages.customer.account_sidebar')
            
            <div class="account__wrapper">
                <div class="account__content">
                    {{-- <h2 class="account__content--title h3 mb-20">Account Details</h2> --}}
                    <div class="account__table--area">
                        <div class="shadow mt-3 p-4 mb-3 rounded">
                            <form action="{{route('customer.reviews.submit')}}" method="POST" >
                              @csrf
                                <h3 class="reviews__comment--reply__title mb-15">Add a review </h3>
                                <div class="reviews__ratting d-flex align-items-center mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <div class='starrr' id='star1'></div>&nbsp;<span class='choice'></span> --}}
                                            <select required style="height: 40px; font-size: 16px;" class="form-select form-control checkout__input--list checkout__input--select select" aria-label="" id="star_input" name="star_input">
                                              <option value="">Select Star Input</option>
                                              <option value="5">Best (5 Star)</option>
                                              <option value="4">Better (4 Star)</option>
                                              <option value="3">Good (3 Star)</option>
                                              <option value="2">Bad (2 Star)</option>
                                              <option value="1">Worst (1 Star)</option>
                                          </select>
                                        </div>
                                        {{-- <input type="hidden" name="star_input" id="star_input"> --}}
                                        <input type="hidden" name="order_product_info_id" value="{{optional($order_product_info)->id}}" id="order_product_info_id">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-10">
                                        <textarea  required class="reviews__comment--reply__textarea" name="review_text" placeholder="Your Comments...." ></textarea>
                                    </div> 
                                </div>
                                <button class="reviews__comment--btn text-white primary__btn" onclick="submit_form()" type="button">SUBMIT</button>
                                <button class="reviews__comment--btn text-white primary__btn d-none" id="submit_button" type="submit">SUBMIT</button>
                                
                            </form>
                            
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('js/starrr.js')}}"></script>
<script>
    $('#star1').starrr({
      change: function(e, value){
        if (value) {
          $('.your-choice-was').show();
          $('#star_input').val(value);
          $('.choice').text(value);
        } else {
          $('.your-choice-was').hide();
        }
      }
    });

    var $s2input = $('#star2_input');
    $('#star2').starrr({
      max: 10,
      rating: $s2input.val(),
      change: function(e, value){
        $s2input.val(value).trigger('input');
      }
    });

    function submit_form() {
      let star_input = $('#star_input').val();
      if(star_input != '') {
        $('#submit_button').click();
      }
      else {
        error("Please Select Rating.");
      }
      //alert(star_input);
    }


  </script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-39205841-5', 'dobtco.github.io');
    ga('send', 'pageview');
  </script>

@endsection