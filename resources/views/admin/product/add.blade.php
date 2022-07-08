@extends('layouts.admin')

@section('title')
  <title>Add product</title>
@endsection

@section('css')
  <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet" />
  <link href="{{asset('admins/product/add/add.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('partials.content-header',['name'=>'product','key'=>'Add'])
    <!-- /.content-header -->

    <!-- Main content -->
    
    <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            
              @csrf
              <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" placeholder="Nhập tên sản phẩm">
                
              </div>
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror

              <div class="form-group">
                <label>Giá sản phẩm</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}"placeholder="Nhập giá sản phẩm">
              </div>
              @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror

              <div class="form-group">
                <label>Ảnh đại diện</label>
                <input type="file" class="form-control-file" name="feature_image_path" >
                
              </div>

              <div class="form-group">
                <label>Ảnh chi tiết</label>
                <input type="file" multiple class="form-control-file" name="image_path[]" >
                
              </div>

              <div class="form-group">
                <label>Chọn danh mục</label>
                <select class="form-control select2_init @error('category_id') is-invalid @enderror" name="category_id">
                  <option value="">Chọn danh mục cha</option>
                  {!!$htmlOption!!}
                </select>
              </div>
              @error('category_id')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror

              <div class="form-group">
                <label>Nhập tag sản phẩm</label>
                <select class="form-control tags_select_choose" name="tags[]" multiple="multiple">
                  
                </select>
                <small>lưu ý: gõ xong 1 từ - dùng dấu phẩy (hoặc enter)</small>
              </div>
              
          
          </div>
          <div class="col-md-12">
            <div class="form-group">
                <label>Nhập nội dung</label>
                <textarea class="form-control tinymce_editor_init @error('contents') is-invalid @enderror" name="contents" rows="3">
                  {{old('contents')}}
                </textarea>
              </div>
          </div>
          @error('contents')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- /.content -->
    </form>
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
  <script src="{{asset('vendors/select2/select2.min.js')}}"></script>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

  <script src="{{asset('admins/product/add/add.js')}}"></script>
@endsection