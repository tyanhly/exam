
<?php $title = "TTV - Login Form"?>
@extends('layout.main')

@section('title', $title)

@section('content')

<div class="w-container">

    <div class="w-form">
        
        @include('layout.inc.navigation')
        @include('layout.inc.message')
        <form method="post" id="wf-form-Login-Form" name="wf-form-Login-Form" data-name="Login Form"  action="{{{ route('user.postLogin') }}}">
       
        <h1>Login</h1>
        
        <label for="UserName">Username:</label>
        <input type="hidden" name="_token"
               value="{{{ Session::getToken() }}}">
        <input class="w-input" id="UserName" type="text"
               placeholder="Enter your username" name="user_name" 
               data-name="UserName" required="required"
               value="{{{ Input::old('username') }}}">
        <label for="Password">Password:</label>
        <input class="w-input" id="Password" type="password" placeholder="Enter your password" name="password" data-name="Password" required="required">
        <div class="w-row">
          <div class="w-col w-col-6"></div>
          <div class="w-col w-col-6">
            <input class="w-button" type="submit" value="Login" data-wait="Please wait...">
          </div>
        </div>
      </form>
      <div class="w-form-done">
        <p>Thank you! Your submission has been received!</p>
      </div>
      <div class="w-form-fail">
        <p>Oops! Something went wrong while submitting the form :(</p>
      </div>
 </div></div>
@stop

@section('script')
 
@stop
