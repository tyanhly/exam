
<?php $title = "TTV - 500"?>
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
               <h1>Error 503</h1>
            </div>
         </div>
         
         <div class="w-row">
            <div class="w-col w-col-12">
                @include('layout.inc.message')
            </div>
        </div>
    </div>
</section>