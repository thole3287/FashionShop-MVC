@extends('admin.main')
@section('content')
<table class="table">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Link</th>
            <th>Ảnh</th>
            <th>Trạng Thái</th>
            <th>Cập nhật</th>
            <th> 
                &nbsp;
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sliders as $key => $slider )
        <tr align="center">
            <td style="vertical-align: middle;">{{ $slider->id }}</td>
            <td style="vertical-align: middle;">{{ $slider->name }}</td>
            <td style="vertical-align: middle;">{{ $slider->url }}</td>
            <td style="vertical-align: middle;">
                <a href="{{ $slider->thumb }}" target="_blank" >
                    <img src="{{ $slider->thumb }}" height="50px">
                </a>
            </td>
            <td style="vertical-align: middle;">{!! \App\Helper\Helper::active($slider->active) !!}</td>
            <td style="vertical-align: middle;">{{ $slider->updated_at }}</td>
            <td style="vertical-align: middle;">
                <a  class="btn btn-primary btn-sm" href="/admin/sliders/edit/{{$slider->id}}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Edit
                </a>
                <a class="btn btn-danger btn-sm" href="/admin/sliders/list/" onclick="removeRow({{ $slider->id }}, '/admin/sliders/destroy')">
                    <i class="fas fa-trash">
                    </i>
                    Delete
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $sliders->links() !!}
@endsection