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
               print_r($data['rink']);
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
                  <form action="{{!empty($data['rink']) ? route('rink.update',[$data['rink']->id]): route('rink.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Name <span class="input-required">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"  value="{{!empty($data['rink']) ? old('name', $data['rink']->name) : old('name')}}" required>
                        </div>
                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="province">Province</label>
                          <select name="province_id" id ="province_id" class="form-control" style="width: 100%">
                            <option value="">Select</option>
                            @foreach($province_all as $id => $value)
                                <option value="{{ $id }}" {{ (old('province_id') ? old('province_id') : $data['rink']->province_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="city">City</label>
                          <select name="city_id" id ="city_id" class="form-control" style="width: 100%">
                            <option value="">Select</option>
                            @foreach($city_all as $id => $value)
                              <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $data['rink']->location_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="about">Address</label>
                          <textarea class="form-control" id="address" name ="address" placeholder="address">{{!empty($data['rink']) ? old('address', $data['rink']->address) : old('address')}}</textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Google Map Latitude <span class="input-required">*</span></label>
                          <input type="text" class="form-control" id="latitude" name="latitude" placeholder="latitude"  value="{{!empty($data['rink']) ? old('latitude', $data['rink']->latitude) : old('latitude')}}" required>
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Google Map Longitude <span class="input-required">*</span></label>
                          <input type="text" class="form-control" id="longitude" name="longitude" placeholder="longitude"  value="{{!empty($data['rink']) ? old('longitude', $data['rink']->longitude) : old('longitude')}}" required>
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