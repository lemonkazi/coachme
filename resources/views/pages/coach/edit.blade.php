@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="coach-edit">
      <form action="{{!empty($data['user']) ? route('profile-update'): ''}}"
       method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
          {{session('msg')}}
          @if(session()->has('error'))
              <div class="alert alert-danger invalid-feedback d-block">{{ session()->get('error') }}</div>
          @endif
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif
          @if (session('warning'))
            <div class="alert alert-warning">
              {{ session('warning') }}
            </div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <div class="row">
            <div class="col-md-10">
              <div class="row">

                <div class="img-upload mb-4">
                  <input accept="image/*" name="avatar_image_path" type='file' id="imgInp" onchange="loadFile(event)" />
                  
                  @if(isset($data['user']->avatar_image_path))
                    <img id="output" src="{{$BASE_URL}}/photo/user_photo/{{$data['user']->avatar_image_path}}" alt="PAT">
                  @else
                    <img id="output" src="{{ asset('img/avatar.png') }}" alt="">
                  @endif

                  <i class="bi bi-plus-lg"></i>
                </div>
                <h2>Basic information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Name <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{!empty($data['user']) ? old('name', $data['user']->name) : old('name')}}" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="family">Family name</label>
                    <input type="text" class="form-control" id="family_name" name="family_name" placeholder="Family Name"  value="{{!empty($data['user']) ? old('family_name', $data['user']->family_name) : old('family_name')}}" aria-describedby="emailHelp">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="province">Province</label>
                    <select name="province_id" id ="province_id" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($province_all as $id => $value)
                          <option value="{{ $id }}" {{ (old('province_id') ? old('province_id') : $data['user']->province_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="about">About me</label>
                    <textarea class="form-control" id="about" name ="about">{{!empty($data['user']) ? old('about', $data['user']->about) : old('about')}}</textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="city">City</label>
                    <select name="city_id" id ="city_id" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($city_all as $id => $value)
                            <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $data['user']->city_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                        
                      @endforeach
                    </select>
                    <div class="form-check">
                      @if ($data['user']->is_published == 1)
                          <input type="checkbox" value="1" name="is_published" checked class="form-check-input" id="is_published">
                      @else
                          <input type="checkbox" value="1" name="is_published" {{ old('is_published') ? 'checked' : '' }} class="form-check-input" id="is_published">
                      @endif
                      <label class="form-check-label" for="is_published">Publish my account</label>
                    </div>
                  </div>
                </div>
                <h2>Coach information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="speciality">Discipline</label>
                    <select class="form-control" id="speciality" name="speciality_id[]" multiple="multiple">
                      <?php 
                        if(!empty($data['speciality_id'])) {
                          ?>
                          @foreach($speciality_all as $id => $value)
                            <option value="{{$id}}" @foreach($data['speciality_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                          <?php 
                        } else {
                          ?>
                          @foreach($speciality_all as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                          @endforeach
                          <?php
                        }
                        ?>
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="experience">Experience</label>
                    <select class="form-control" id="experience_id" name="experience_id">
                      <option value="">Select</option>
                      @foreach($experience_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('experience_id') ? old('experience_id') : $data['user']->experience_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="certificate">Coaching certification</label>
                    <input type="text" class="form-control" id="certificate_name" name="certificate_name" placeholder="Coaching certification"  value="{{!empty($data['user']) ? old('certificate_name', $data['user']->certificate_name) : old('certificate_name')}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="language">Language spoken</label>
                    <select class="form-control" id="language" name="language_id[]" multiple="multiple">

                     <?php 
                        if(!empty($data['language_id'])) {
                          ?>
                          @foreach($language_all as $id => $value)
                            <option value="{{$id}}" @foreach($data['language_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                          <?php 
                        } else {
                          ?>
                          @foreach($language_all as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                          @endforeach
                          <?php
                        }
                        ?>
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <label for="experience">Student’s age</label>
                      <select class="form-control" id="age" name="age_id[]" multiple="multiple">
                        <?php 
                        if(!empty($data['age_id'])) {
                          ?>
                          @foreach($age_all as $id => $value)
                            <option value="{{$id}}" @foreach($data['age_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                          <?php 
                        } else {
                          ?>
                          @foreach($age_all as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                          @endforeach
                          <?php
                        }
                        ?>
                      </select>
                      <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <label for="level_id">Level of Coaching</label>
                      <select class="form-control" id="level" name="level_id[]" multiple="multiple">

                        <?php 
                        if(!empty($data['level_id'])) {
                          ?>
                          @foreach($level_all as $id => $value)
                            <option value="{{$id}}" @foreach($data['level_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                          <?php 
                        } else {
                          ?>
                          @foreach($level_all as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                          @endforeach
                          <?php
                        }
                        ?>
                      </select>
                      <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <h2>Contact</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Website or associated club</label>
                    <input type="text" class="form-control" id="website" name="website" value="{{!empty($data['user']) ? old('website', $data['user']->website) : old('website')}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{!empty($data['user']) ? old('phone_number', $data['user']->phone_number) : old('phone_number')}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">WhatsApp</label>
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{!empty($data['user']) ? old('whatsapp', $data['user']->whatsapp) : old('whatsapp')}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"  value="{{!empty($data['user']) ? old('email', $data['user']->email) : old('email')}}" required>
                  </div>
                </div>
                <div class="col-md-4 mb-4 wid-40">
                  <a href="{{route('camp-create')}}" id="create-camp" class="form-control btn btn-primary submit px-3">Create a camp</a>
                </div>
                <div class="offset-md-4 col-md-4 mb-4 wid-60">
                  <div class="btn-group">
                  <button type="submit" id="save" class="form-control btn btn-primary submit px-3">Save</button>
                  <button type="submit" id="cancel" class="form-control btn btn-primary submit px-3">Cancel</button>                 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>

      <div class="container camp_list">
        <div class="row">
          @if(!empty($data['camps']))
          <div class="col-md-12">
            <h2>Your Camps</h2>
            <div class="row">
              <div class="col-sm-12">
              @if(isset($data['camps']))
                @foreach ($data['camps'] as $camp)
               
                  <div class="card text-white card-has-bg click-col mb-4">        
                    <div class="card-img-overlay d-flex flex-column">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-3">
                          <?php if(isset($camp['camp_photo'][0])){ ?>
                              <img src="{{$BASE_URL}}/{{$camp['camp_photo'][0]['path']}}" alt="" class="img-responsive">
                          <?php } else{ ?>
                            <img src="{{ asset('img/default-thumbnail.jpeg') }}" alt="">
                          <?php } ?> 
                          </div>
                          
                          <?php

                          //$today = new DateTime();
                          $today      = strtotime('today');
                          $date_year = date('Y', $today);

                          $start_date      = strtotime($camp['start_date']);
                          $start_year = date('Y', $start_date);
                          if ($date_year == $start_year) {
                            $start_date = date('F d', $start_date);
                          } else {
                            $start_date = date('F d, Y', $start_date);
                          }
                          

                          $end_date      = strtotime($camp['end_date']);
                          $end_year = date('Y', $end_date);
                          if ($date_year == $end_year) {
                            $end_date = date('F d', $end_date);
                          } else {
                            $end_date = date('F d, Y', $end_date);
                          }
                          ?>
                          <div class="col-md-6">
                            <h3>{{$camp['name']}}</h3>
                            <h6>{{$start_date}}-{{$end_date}}</h6>
                            @if(isset($camp['rink']))
                                <h5><i class="fas fa-map-marker-alt"></i>
                                  
                                    {{$program['camp']['city_name']}}
                                  
                                </h5>
                            @endif
                            
                            
                            @if(isset($data['camp_type_name']) && !empty($data['camp_type_name']))
                              @foreach ($data['camp_type_name'] as $camp_type)

                                  <h5><i class="fas fa-clock"></i>{{$camp_type['name']}}</h5>

                                 
                              
                              @endforeach
                            @endif
                            <h5><i class="fas fa-road"></i>{{$camp['level_name']}}</h5>
                          </div> 
                          <div class="col-md-3 learn-more">
                            
                            <a href="{{!empty($camp['id']) ? route('camp-details', ['camp' => $camp['id']]): ''}}" class="btn btn-primary">
                              <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{!empty($camp['id']) ? route('camp-update', ['camp' => $camp['id']]): ''}}" class="btn btn-warning" title="Edit">
                              <i class="fas fa-edit"></i>
                            </a> 
                            <a href="javascript:;" data-id="{{$camp['id']}}" class="btn btn-danger btn_delete_camp" data-toggle="tooltip" title="Delete">
                              <i class="fa fa-trash" aria-hidden="true"></i>   
                            </a> 
                          </div>
                          
                        </div>
                      </div>
                      
                    </div>
                  </div>
               
                @endforeach
              @endif
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>

    <script type="text/javascript">

      $(document).ready(function () {
        $('#rinks').multiselect();
        // add logic change value of result top condition
        $('#province_id').on('change', function(){
            var name = $(this).attr('name');
            $('#city_id').html('');
            if (name == '') {
                return false;
            }

            var value = $(this).val();
            var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
          

            var data = {
                province_id: value,
                _token:csrfToken
            };


            $.ajax({
              type: 'POST',
              url: baseUrl + '/ajax_citylist',
              data: data,
              //dataType: 'json',
              success: function (response) {
                console.log(response);
                if (response) {
                    $('#city_id').html(response);
                } else {
                    $('#city_id').html('');
                }
              },
              complete: function () {}
            });
            return false;
        });


      });
    </script>
    
@endsection
  