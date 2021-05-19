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
                    <h3 class="card-title">ADD NEW</h3>
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
                  <form action="{{ route('coach.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="family_name">Family Name</label>
                          <input type="text" class="form-control" id="family_name" name="family_name" placeholder="Family Name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Email address</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="email">About</label>
                          <textarea class="form-control" id="about" placeholder="about"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="province">Province</label>
                          <select name="province" class="form-control" style="width: 100%">
                            <option value="none" selected="" disabled="">Select</option>
                            <option value="0">aa</option>
                            <option value="1">aaa</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" class="form-control" style="width: 100%">
                              <option value="none" selected="" disabled="">Select</option>
                              <option value="0">aa</option>
                              <option value="1">aaa</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="speciality">speciality</label>
                          <select name="speciality" class="form-control" style="width: 100%">
                            <option value="none" selected="" disabled="">Select</option>
                            <option value="0">aa</option>
                            <option value="1">aaa</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="experience">experience</label>
                            <select name="experience" class="form-control" style="width: 100%">
                              <option value="none" selected="" disabled="">Select</option>
                              <option value="0">aa</option>
                              <option value="1">aaa</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="rink">rink</label>
                          <select name="rink" class="form-control" style="width: 100%">
                            <option value="none" selected="" disabled="">Select</option>
                            <option value="0">aa</option>
                            <option value="1">aaa</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="certificate">certificate</label>
                            <select name="certificate" class="form-control" style="width: 100%">
                              <option value="none" selected="" disabled="">Select</option>
                              <option value="0">aa</option>
                              <option value="1">aaa</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="language">language</label>
                          <select name="lang" class="form-control" style="width: 100%">
                            <option value="none" selected="" disabled="">Select</option>
                            <option value="0">aa</option>
                            <option value="1">aaa</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="price">price</label>
                            <select name="price" class="form-control" style="width: 100%">
                              <option value="none" selected="" disabled="">Select</option>
                              <option value="0">aa</option>
                              <option value="1">aaa</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phone_number">Phone Number</label>
                          <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="phone_number" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="whatsapp">whatsapp</label>
                          <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="whatsapp">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="file">Upload Image</label>
                            <input type="file" name="avatar_image_path" id="file" placeholder="no file selected">
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