@include('sweetalert::alert')
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
    function addToCart(product_id) {
      //alert(product_id);
      url = "{{ route('cart.add') }}";
      var product_id = product_id;
      $.ajax({
          url: url,
          type: "POST",
          data:{
              product_id:product_id,_token: '{{csrf_token()}}',
          },
          success:function(response){
            $('#total_count').html(response.total_count);
            $('#mobile_total_count').html(response.total_count);
            $('#cart_sidebar_total').html(response.total_amount);
            $('#cart_sidebar').html(response.cart_sidebar);
            $('.added_to_cart_' + product_id).addClass('added_to_cart');
            $('.added_to_cart_' + product_id).text('Added To Cart');
            
            toastr.options = {
              "positionClass": "toast-top-right"
            }
              toastr.success('Product Added into Cart');
          }
      });
    }

    function addToWishlist(product_id) {
      //alert(product_id);
      url = "{{ route('wishlist.add') }}";
      var product_id = product_id;
      $.ajax({
          url: url,
          type: "POST",
          data:{
              product_id:product_id,_token: '{{csrf_token()}}',
          },
          success:function(response){
            
            
            toastr.options = {
              "positionClass": "toast-top-right"
            }
            if (response.auth == 1) {
              if(response.status == 0){
                toastr.error('Something went wrong!');
              }
              if (response.status == 1) {
                toastr.success('Product Added into Wishlist!');
              }
              if(response.status == 2){
                toastr.warning('Product already in  your wishlist!');
              }
            }
            else{
              toastr.warning('You are not logged in!');
              
            }
          }
      });
    }
</script>
<script>
        $('#payment_option').change(function () {
            $payment_option = $('#payment_option').val();
            if($payment_option == 'Cash on Delivery' ) {
                $('#cod').removeClass('hidden');
                $('#bkash').addClass('hidden');
                $('#rocket').addClass('hidden');
            }
            if($payment_option == 'Bkash' ) {
                $('#cod').addClass('hidden');
                $('#bkash').removeClass('hidden');
                $('#transaction_id').removeClass('hidden');
                $('#rocket').addClass('hidden');
            }
            if($payment_option == 'Rocket' ) {
                $('#cod').addClass('hidden');
                $('#bkash').addClass('hidden');
                $('#rocket').removeClass('hidden');
                $('#transaction_id').removeClass('hidden');
            }

        })
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <!-- <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script> -->
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var route = "{{ route('search') }}";

        
        $('#search').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script>
      $(document).ready(function(){
        $(".fancybox").fancybox({
              openEffect: "none",
              closeEffect: "none"
          });
          
          $(".zoom").hover(function(){
          
          $(this).addClass('transition');
        }, function(){
              
          $(this).removeClass('transition');
        });
      });
    </script>

    @yield('scripts')