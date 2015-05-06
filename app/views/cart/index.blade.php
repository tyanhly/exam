
<?php $title = "TTV - Cart"?>
@extends('layout.main')

@section('title', $title)

@section('content')
<section class="container">
      <div class="w-container">
        
         <div class="w-row">
            <div class="w-col w-col-12">
                @include('layout.inc.navigation')
            </div>
        </div>
        
         <div class="w-row">
            <div class="w-col w-col-12">
                @include('layout.inc.message')
            </div>
        </div>
        
         <div class="w-row">
            <div class="w-col w-col-9">
               <h1>Checkout</h1>
            </div>
            <div class="w-col w-col-3">
                @include('layout.inc.auth')
            </div>
         </div>
         
         
         <div class="w-row table-header">
            <div class="w-col w-col-1">
               <div><strong>#</strong></div>
            </div>
            <div class="w-col w-col-1">
               <div><strong>No</strong></div>
            </div>
            <div class="w-col w-col-4">
               <div><strong>Product</strong></div>
            </div>
            <div class="w-col w-col-2">
               <div><strong>Price</strong></div>
            </div>
            <div class="w-col w-col-2">
               <div><strong>Quantity<br></strong></div>
            </div>
            <div class="w-col w-col-2">
               <div><strong>Total Price</strong></div>
            </div>
         </div>
         
         <?php $total = 0;//dd($cart->getItems());?>
         @foreach($cart->getItems() as $item)
         <div class="w-row">
            <div class="w-col w-col-1">
               <form action="{{ route('cart.delete') }}" method="post" id="add-cart-form" name="add-cart-form" data-name="Delete">
                  <input type="hidden" value="{{ $item->getProduct()->id;}}" name="id">
                  <input class="w-button" type="submit" value="[X]" data-wait="Please wait...">
              </form>
            </div>
            <div class="w-col w-col-1">
               <div>{{ $item->getProduct()->code;}}</div>
            </div>
            <div class="w-col w-col-4">
               <div>{{$item->getProduct()->name}}</div>
            </div>
            <div class="w-col w-col-2">
               <div>{{ number_format( $item->getProduct()->sale_price)}}$</div>
            </div>
            <div class="w-col w-col-2">
               <div>{{$item->getQuantity()}}</div>
            </div>
            <div class="w-col w-col-2">
               <?php 
                $subTotal = $item->getQuantity() * $item->getProduct()->sale_price; 
                $total += $subTotal;?>
               <div> {{ number_format($subTotal) }}</div>
            </div>
         </div>
         
         @endforeach
         
         
         
         <div class="w-row">
            <div class="w-col w-col-1"></div>
            <div class="w-col w-col-5"></div>
            <div class="w-col w-col-2"></div>
            <div class="w-col w-col-2">
               <div><strong>Total Price:</strong></div>
            </div>
            <div class="w-col w-col-2">
               <div><strong>{{ number_format($total) }}</strong></div>
            </div>
         </div>
         
         <div class="w-row">
            <div class="w-col w-col-9">
               <div class="w-form">
                  <form action="{{route('cart.checkCoupon');}}" method="post" id="checkCoupon">
                     <div>Please enter coupon if needed</div>
                     <input class="w-input" id="couponCode" 
                        type="text" placeholder="Coupon code" 
                        name="couponCode" data-name="Coupon 2" value="{{Session::has('couponCode')?Session::get('couponCode'):''}}">
					 <input class="w-button" type="submit" value="Check Coupon" data-wait="Please wait...">
                  </form>
               </div>
            </div>
            <div class="w-col w-col-3" vertical-align="true">
			   
			</div>
         </div>
         <div class="w-row">
            <div class="w-col w-col-9">
               
            </div>
            <div class="w-col w-col-3" vertical-align="true">
			   
			</div>
         </div>		 
         <div class="w-row">
            <div class="w-col w-col-9">
               <div class="w-form">
                     <div>Enter address information&nbsp;(*)</div>
                     <textarea class="w-input" placeholder="Enter your address" id="address"></textarea>
               </div>
            </div>
            <div class="w-col w-col-3">
               
            </div>
         </div>
		 
         <div class="w-row">
            <div class="w-col w-col-9">
               
            </div>
            <div class="w-col w-col-3">
                <div class="w-form">
                    <form  action="{{route('cart.order');}}" method="post" id="checkout">
                     <div class="w-row">
                        <div class="w-col w-col-8">
                            <input class="w-button" type="submit" onclick="window.location.href='{{route("product.index")}}';return false;" value="Continue Shopping" data-wait="Please wait..."></div>
                        <div class="w-col w-col-4">
                        <input type="hidden"  name="address" id="checkoutAddress" />
                        <input type="hidden"  name="couponCode" id="checkoutCouponCode" />
                        <input class="w-button" type="submit" value="Register Order" data-wait="Please wait..." style="background-color:blue"></div>
                        
                     </div>
                    </form>
               </div>
			</div>
         </div>	
         
      </div>

  </section>
 
@stop

@section('script')
 <script type="text/javascript">    
function submitCheckCoupon(){
	$("#checkCoupon").submit();
}
    $(function(){
        $("form#checkout").submit(function(){
            $("#checkoutAddress").val($("#address").val());
            $("#checkoutCouponCode").val($("#couponCode").val());
            $(this).submit();
        });
    });
</script>
 @stop
