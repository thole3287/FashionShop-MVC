@extends('admin.main')
@section('content')
<form action="{{route('add_slider')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nhập tiêu đề">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Đường dẫn</label>
                    <input type="text" class="form-control" name="url" value="{{ old('url') }}" placeholder="Nhập đường dẫn url">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Ảnh Sản Phẩm</label>
                    <input type="file"  class="form-control" id="upload">
                    <div id="image_show">

                    </div>
                    <input type="hidden" name="thumb" id="thumb">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sắp xếp</label>
                    <input type="number" class="form-control" name="sort_by" value="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kích hoạt</label>
                    <!-- radio -->
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active" checked="">
                            <label for="active" class="custom-control-label">Có</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                            <label for="no_active" class="custom-control-label">Không</label>
                        </div>
                </div>
            </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm Slider Mới</button>
    </div>
</form>
@endsection

