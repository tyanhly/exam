
<div >
<a style="display: inline-block; float:right; " href="{{URL::to('user/logout')}}">logout</a>
<span style="display: inline-block; float:right;margin-right:10px;">User {{Auth::user()->first_name}} {{Auth::user()->last_name}}</span> 
<div style="clear:both;"></div>
</div>