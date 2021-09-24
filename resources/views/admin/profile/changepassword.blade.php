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
               print_r($data['user']);
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
                  <form action="{{route('admin.profile.changepassword')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="name">Current Password <span class="input-required">*</span></label>
                          <input type="password" class="form-control" id="current_password" name="current_password"  value="{{ old('current_password') }}" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="name">New Password <span class="input-required">*</span></label>
                          <input type="password" class="form-control" id="new_password" name="new_password"  value="{{ old('new_password') }}" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="name">Confirm New Password <span class="input-required">*</span></label>
                          <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" value="{{ old('confirm_new_password') }}" required>
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
                    <li><b>name</b> 1 to 60 character.</li>
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