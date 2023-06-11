@extends('admin.main')
@section('content')
<table class="table">
    <thead>
        <tr align="center">
            <th style="width: 1%">ID</th>
            <th style="width: 20%">Name</th>
            <th >Active</th>
            <th>Update</th>
            <th> 
                &nbsp;
            </th>
        </tr>
    </thead>
    <tbody>
        {!! \App\Helper\Helper::menu($menus) !!}
    </tbody>
</table>
@endsection