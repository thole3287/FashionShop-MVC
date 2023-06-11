@if(Session::has('matb'))
    @if(Session::get('matb')=='0')
        <div class="alert alert-danger">{{Session::get('noidung')}}</div>
    @endif
@endif