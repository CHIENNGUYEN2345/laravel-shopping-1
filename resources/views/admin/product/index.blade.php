@extends('layouts.admin')

@section('title')
  <title>Thêm thông tin sản phẩm</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{asset('admins/product/index/list.css')}}">
@endsection

@section('js')
  <script src="{{asset('vendors/sweetAlert2/sweetalert2%4011.js')}}"></script>
  <script src="{{asset('admins/product/index/list.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('partials.content-header',['name'=>'product','key'=>'List'])
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <a href="{{route('product.create')}}" class="btn btn-success float-right m-2">ADD</a>
          </div>
          <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Tên sản phẩm</th>
                  <th scope="col">Giá</th>
                  <th scope="col">Hình ảnh</th>
                  <th scope="col">Danh mục</th>
                  <th scope="col">Action</th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach($products as $productItem)
                <tr>
                  <th scope="row">{{$productItem->id}}</th>
                  <td>{{$productItem->name}}</td>
                  <td>{{number_format($productItem->price)}}</td>
                  <td>
                    <img src="{{$productItem->feature_image_path}}" class="product_image_150_130" alt="">
                  </td>
                  <td>{{optional($productItem->category)->name}}</td>
                  <td>
                    <a href="{{route('product.edit',['id'=>$productItem->id])}}" class="btn btn-default">Edit</a>
                    <a href="" 
                    data-url="{{route('product.delete',['id'=>$productItem->id])}}"
                    class="btn btn-danger action_delete">Delete</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
              {{ $products->links() }}
          </div>
          
        </div>
        
      </div>
    </div>
    
  </div>
  
@endsection

