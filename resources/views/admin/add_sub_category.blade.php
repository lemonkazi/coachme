@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Categories</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Sub-Categories</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-12">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Sub_Category Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="subCategory_submit">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Parent-Category</label>
                    <select class="form-control" id="cat_ID" name="cat_ID">
                    <option value="">Select</option>
                    @foreach($categories as $row)
                    <option value="{{ $row->id}}">{{ ucwords($row->category_name)}}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="card-body">
                  <div class="form-group">
                    <label for="sub_category_name">Sub-Category</label>
                    <input type="text" class="form-control" name="sub_category_name" id="sub_category_name" placeholder="Name" required>
                  </div>
                  
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Add New Sub Category</button>
                </div>
              </form>
            </div>
              
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @endsection