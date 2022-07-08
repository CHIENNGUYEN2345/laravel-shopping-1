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
    @include('partials.content-header',['name'=>'product','key'=>'Edit'])
    <!-- /.content-header -->

    <!-- Main content -->
    <form action="{{route('product.update',['id'=>$product->id])}}" method="post" enctype="multipart/form-data">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            
              @csrf
              <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="name" value="{{$product->name}}" placeholder="Nhập tên sản phẩm">
                
              </div>

              <div class="form-group">
                <label>Giá sản phẩm</label>
                <input type="text" class="form-control" name="price" value="{{$product->price}}" placeholder="Nhập giá sản phẩm">
                
              </div>

              <div class="form-group">
                <label>Ảnh đại diện</label>
                <input type="file" class="form-control-file" name="feature_image_path" >
                <div class="col-md-4 feature_image_container">
                  <div class="row">
                    <img class="feature_image" src="{{$product->feature_image_path}}" alt="">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Ảnh chi tiết</label>
                <input type="file" multiple class="form-control-file" name="image_path[]" >
                <div class="col-md-12 container_image_detail">
                  <div class="row">
                    @foreach($product->productImages as $productImageItem)
                    <div class="col-md-3">
                      <img class="image_detail_product" src="{{$productImageItem->image_path}}" alt="">
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Chọn danh mục</label>
                <select class="form-control select2_init" name="category_id">
                  <option value="">Chọn danh mục cha</option>
                  {!!$htmlOption!!}
                </select>
              </div>

              <div class="form-group">
                <label>Nhập tag sản phẩm</label>
                <select class="form-control tags_select_choose" name="tags[]" multiple="multiple">
                  @foreach($product->tags as $tagItem)
                    <option value="{{$tagItem->id}}" selected>{{$tagItem->name}}</option>
                  @endforeach
                </select>
                <small>lưu ý: gõ xong 1 từ - dùng dấu phẩy (hoặc enter)</small>
              </div>
              
          
          </div>
          <div class="col-md-12">
            <div class="form-group">
                <label>Nhập nội dung</label>
                <textarea class="form-control tinymce_editor_init" name="contents" rows="3">
                  {{$product->name}}
                </textarea>
              </div>
          </div>
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