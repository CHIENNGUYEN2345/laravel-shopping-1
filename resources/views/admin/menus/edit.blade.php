@extends('layouts.admin')

@section('title')
  <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('partials.content-header',['name'=>'menu','key'=>'Edit'])
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <form action="{{route('menus.update',['id'=>$menuFollowIdEdit->id])}}" method="post">
              @csrf
              <div class="form-group">
                <label>Ten danh muc</label>
                <input type="text" class="form-control" name="name" value="{{$menuFollowIdEdit->name}}" placeholder="Nhap ten danh muc">
                
              </div>
              <label>Chon danh muc cha</label>
                <select class="form-control" name="parent_id">
                  <option value="0">Chọn menu cha</option>
                  {!! $optionSelect !!}
                </select>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

