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

        <!--  @php
             echo "<pre>";
               print_r($data['testimonial']);
             echo "</pre>";
            @endphp -->
        
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
                    <h3 class="card-title">{{$data['Title']}}</h3>
                </div>

                <div class="card-body">
                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
                  <!-- form start -->
                  <form action="{{!empty($data['testimonial']) ? route('testimonial.update',[$data['testimonial']->id]): route('testimonial.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Name <span class="input-required">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"  value="{{!empty($data['testimonial']) ? old('name', $data['testimonial']->name) : old('name')}}" required>
                        </div>
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name ="comment" placeholder="about">{{!empty($data['testimonial']) ? old('comment', $data['testimonial']->comment) : old('comment')}}</textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            @if (!empty($data['testimonial']) && !empty($data['testimonial']->image_path))
                              <img style="max-width:80px;" src="{{$BASE_URL}}/testimonial_photo/{{$data['testimonial']->image_path}}" />
                              </br>
                            @endif
                          
                            <label for="file">Upload Avatar Image</label>
                            <input type="file" name="image_path" id="file" placeholder="no file selected">
                          </div>
                        </div>
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
                    Instraction
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