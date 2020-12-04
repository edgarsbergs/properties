@if(Session::has('message'))
    <div class="alert alert-success">
        {{Session::get('message')}}
    </div>
@endif

@if(Session::has('errors'))
    <div class="alert alert-danger">
        {{Session::get('errors')}}
    </div>
@endif
