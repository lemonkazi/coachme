@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{$data['Title']}}</h1>
        </div><!-- /.col -->
        @php
          echo htmlspecialchars_decode(render2($data['breadcrumb']))
        @endphp
        
        {{session('msg')}}
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- content HEADER -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo __('LABEL_ADD_NEW')?></h3>
                </div>

                <div class="card-body">
                  <!-- form start -->
                  <form method="post" action="coach/create">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputPassword1">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                      </div>
                      <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" name="category" id="category" placeholder="Category" required>
                      </div>
                      <div class="form-group">
                        <label for="sub_category">Sub_category</label>
                        <input type="text" class="form-control" name="sub_category" id="sub_category" placeholder="Title" required>
                      </div>
                      <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="Title" required>
                      </div>
                      <div class="form-group">
                        <label for="picture">Picture</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="picture" id="picture" required>
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" id="price" placeholder="Title" required>
                      </div>
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Title" required>
                      </div>
                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                      </div>
                  </form>
                </div>  
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">
                    asdasdas
                  </h3>
                </div>
                <div class="card-body">
                  <ul>
                    <li><b>User name</b> 1 to 60 character.</li>
                    <li><b>email</b> place email here.</li>
                    <li><b>Password</b> Half-width alphanumeric characters between 8 and 20 characters.</li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->

</div>
@endsection