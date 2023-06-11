@extends('admin.main')
@section('content')
<table class="table">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Tên Sản Phẩm</th>
            <th>Danh Mục</th>
            <th>Giá gốc</th>
            <th>Giá khuyến mãi</th>
            <th>Active</th>
            <th>Update</th>
            <th> 
                &nbsp;
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $key => $product )
        <tr align="center">
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->menu->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->price_sale }}</td>
            <td>{!! \App\Helper\Helper::active($product->active) !!}</td>
            <td>{{ $product->updated_at }}</td>
            <td >
                <a  class="btn btn-primary btn-sm" href="/admin/products/edit/{{$product->id}}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Edit
                </a>
                <a class="btn btn-danger btn-sm" href="/admin/products/list/" onclick="removeRow({{ $product->id }}, '/admin/products/destroy')">
                    <i class="fas fa-trash">
                    </i>
                    Delete
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links()}}
@endsection