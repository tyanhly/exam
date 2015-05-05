            <div style="margin:10px 0;">
            @if (Session::has('error-message'))
            	<div class="alert alert-danger">{{ Session::get('error-message') }}</div>
            @else
                <!-- will be used to show any messages -->
                @if (Session::has('message'))
                	<div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
            @endif
            </div>
    