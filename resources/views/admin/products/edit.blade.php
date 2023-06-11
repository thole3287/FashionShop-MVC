@extends('admin.main')
@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
<form action="{{route('edit_product', $product->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="Nhập tên danh mục">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Danh Mục</label>
                    <select class="form-control" name="menu_id">
                        <option value="" disabled selected hidden>↓ Nhập tên danh mục</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ $product->menu_id == $menu->id ? 'selected' :''}}> {{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Giá gốc</label>
                    <input type="number" class="form-control" name="price" value="{{ $product->price }}"  placeholder="Nhập giá gốc">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Giá giảm</label>
                    <input type="number" class="form-control" name="price_sale" value="{{ $product->price_sale }}" placeholder="Nhập giá giảm">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" cols="30" rows="3">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Mô tả chi tiết</label>
            <textarea name="content" id="content" class="form-control" cols="30" rows="3">{{ $product->content }}</textarea>
        </div>


        <div class="form-group">

            <label for="menu">Ảnh Sản Phẩm</label>
            <input type="file"  class="form-control" id="upload">
            <div id="image_show" >
                <a href="" target="_blank">
                    <img src="{{$product->thumb}}" width="100px" alt="Chỉnh sửa ảnh sản phẩm">
                </a>
            </div>
            <input type="hidden" name="thumb" value="{{$product->thumb}}" id="thumb">
            
        </div>
        <div class="form-group">
            <label>Kích hoạt</label>
            <!-- radio -->
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                    {{ $product->active == 1 ? 'checked= ""' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" 
                    {{ $product->active == 0 ? 'checked= ""' : '' }}>
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
    </div>
</form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection