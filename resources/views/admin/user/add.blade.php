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
                  <form action="{{!empty($data['user']) ? route('user.update',[$data['user']->id]): route('user.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Name <span class="input-required">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"  value="{{!empty($data['user']) ? old('name', $data['user']->name) : old('name')}}" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="family_name">Family Name</label>
                          <input type="text" class="form-control" id="family_name" name="family_name" placeholder="Family Name"  value="{{!empty($data['user']) ? old('family_name', $data['user']->family_name) : old('family_name')}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Email address <span class="input-required">*</span></label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email"  value="{{!empty($data['user']) ? old('email', $data['user']->email) : old('email')}}" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              
                              @php
                              if(!empty($data['user'])) {
                                @endphp
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"  value="{{ old('password') }}">
                                @php
                              } else {
                                @endphp
                                <label for="password">Password <span class="input-required">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"  value="{{ old('password') }}" required>
                                @php
                              } 
                              @endphp
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="about">User Type</label>
                          <select name="authority" class="form-control" style="width: 100%">
                            <option value="">Select</option>
                             @foreach($authority as $id => $value)
                                <option value="{{ $id }}" {{ (old('authority') ? old('authority') : $data['user']->authority ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="about">About</label>
                          <textarea class="form-control" id="about" name ="about" placeholder="about">{{!empty($data['user']) ? old('about', $data['user']->about) : old('about')}}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="province">Province</label>
                          <select name="province" class="form-control" style="width: 100%">
                            <option value="">Select</option>
                            <option value="1" {{!empty($data['user']) ? (old('province', $data['user']->province) == 1 ? 'selected' : '') : (old('province') == 1 ? 'selected' : '')}} > aa
                            </option>
                            <option value="2">aaa</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" class="form-control" style="width: 100%">
                              <option value="">Select</option>
                              <option value="1">aa</option>
                              <option value="2">aaa</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="speciality">speciality</label>
                          <select name="speciality_id" class="form-control" style="width: 100%">
                            <option value="">Select</option>
                            @foreach($speciality_all as $id => $value)
                                <option value="{{ $id }}" {{ (old('speciality_id') ? old('speciality_id') : $data['user']->speciality_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="experience">experience</label>
                            <select name="experience_id" class="form-control" style="width: 100%">
                              <option value="">Select</option>
                              @foreach($experience_all as $id => $value)
                                <option value="{{ $id }}" {{ (old('experience_id') ? old('experience_id') : $data['user']->experience_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                              @endforeach
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="certificate">Coaching certification</label>
                            <input type="text" class="form-control" id="certificate_name" name="certificate_name" placeholder="Coaching certification"  value="{{!empty($data['user']) ? old('certificate_name', $data['user']->certificate_name) : old('certificate_name')}}">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="language">language</label>
                          <select name="language_id" class="form-control" style="width: 100%">
                            <option value="">Select</option>
                            @foreach($language_all as $id => $value)
                              <option value="{{ $id }}" {{ (old('language_id') ? old('language_id') : $data['user']->language_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="phone">Website or associated club</label>
                            <input type="text" class="form-control" id="website" name="website" value="{{!empty($data['user']) ? old('website', $data['user']->website) : old('website')}}">
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phone_number">Phone Number <span class="input-required">*</span></label>
                          <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="phone_number" value="{{!empty($data['user']) ? old('phone_number', $data['user']->phone_number) : old('phone_number')}}" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="whatsapp">whatsapp</label>
                          <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{!empty($data['user']) ? old('whatsapp', $data['user']->whatsapp) : old('whatsapp')}}"  placeholder="whatsapp">
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
        </div>
    </div>
  </section>
  <!-- /.content -->

</div>
@endsection