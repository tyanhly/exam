
<?php $title = "TTV - Login Form"?>
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
               <h1>List of product</h1>
            </div>
            <div class="w-col w-col-3">
                @include('layout.inc.auth')
            </div>
         </div>
         
         <div class="w-row">
            <div class="w-col w-col-2">
               <div><strong>No</strong></div>
            </div>
            <div class="w-col w-col-4">
               <div><strong>Product</strong></div>
            </div>
            <div class="w-col w-col-3">
               <div><strong>Price</strong></div>
            </div>
            <div class="w-col w-col-3">
               <div><strong>Quantity</strong></div>
            </div>
         </div>
         @foreach($products as $key => $value)
         <?php setlocale(LC_MONETARY, 'it_IT'); $value = (object) $value; //dd($value);?>                		
         <div class="w-row">
            <div class="w-col w-col-2">
               <div>{{ $value->code}}</div>
            </div>
            <div class="w-col w-col-4">
               <div>{{$value->name}}</div>
            </div>
            <div class="w-col w-col-3">
               <div><?php echo number_format( $value->sale_price)?>$</div>
            </div>
            <div class="w-col w-col-3">
               <div class="w-form">
                  <form id="add-cart-form" name="add-cart-form" data-name="Add Cart Form" action="{{ route(cart.add) }}">
                      <input class="w-input" id="pro1_quantityuantity" 
                            type="text" placeholder="Enter product's quantity" 
                            name="quantity" data-name="quantity" style="width: 180px;">
                            
                      <input type="hidden" value="{{ $value->id; }}" name="id">
                      <input class="w-button" type="submit" value="Add to Cart" data-wait="Please wait...">
                  </form>
                  
               </div>
            </div>
         </div>
         @endforeach
         
         <div class="w-row">
            <div class="w-col w-col-9"></div>
            <div class="w-col w-col-3">
               <div class="w-form">
                  <form id="email-form" name="email-form" data-name="Email Form" action="cartdetail.html">
                  <input class="w-button" type="submit" value="Checkout" data-wait="Please wait..." style="background-color:blue">
                  </form>
               </div>
            </div>
         </div>
          <div class="w-row">
            <div class="w-col w-col-12" >
               {{$products->links(); }}
            </div>
          </div>
      </div>

  </section>
 
@stop

@section('script')
 
@stop
