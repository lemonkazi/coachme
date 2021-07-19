@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-edit">
      <form action="{{!empty($data['program']) ? route('program-update', ['program' => $data['program']->id]): route('program-create')}}"
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
            <div class="col-md-6">
              <div class="row">
                @if ($data['user']->authority =='COACH_USER')
                  <a href="{{ url('/coach-account') }}" class="back_btn">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                  </a>
                @else
                  <a href="{{ url('/rink/list') }}" class="back_btn">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                  </a>
                @endif
                <h2>Basic information</h2>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Name of the program <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{!empty($data['program']) ? old('name', $data['program']->name) : old('name')}}" required aria-describedby="nameHelp" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="location">Level</label>
                    <select name="level_id" id ="level_id" class="form-control" style="width: 100%">

                      <option value="">Select</option>
                      @foreach($level_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('level_id') ? old('level_id') : $data['program']->level_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="reg_dates">Window of registration <span class="input-required">*</span></label>
                    <div class="calender">
                      <i class="fas fa-calendar-alt"></i>
                      <input type="text" class="form-control" id="reg_dates" name="reg_dates" value="" required aria-describedby="emailHelp" >
                    </div>
                    <input type="hidden" name="reg_start_date" value="{{!empty($data['program']) ? old('reg_start_date', $data['program']->reg_start_date) : $formatedDate}}">
                    <input type="hidden" name="reg_end_date" value="{{!empty($data['program']) ? old('reg_end_date', $data['program']->reg_end_date) : $formatedDate}}">
                    
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Price">Price <span class="input-required">*</span></label>
                    
                    @if(!empty($data['program']) && empty($data['program']->price) && !empty($data['program']->price_text))
                      <input type="text" class="form-control" id="price" name="price" value="{{!empty($data['program']) ? old('price', $data['program']->price_text) : old('price')}}"  required aria-describedby="emailHelp" >
                    @else
                      <input type="text" class="form-control" id="Price" name="price" value="{{!empty($data['program']) ? old('price', $data['program']->price) : old('price')}}" required aria-describedby="emailHelp" >
                    @endif
                    
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="about">About program</label>
                    <textarea class="form-control" id="about" name ="about">{{!empty($data['program']) ? old('about', $data['program']->about) : old('about')}}</textarea>                   
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 ">
              <div class="row ">
                <h6 class="mb-3">Schedule</h6>
                <div class="col-md-12" id="coachimg-wrapper">
                  <button class="add_period form-control btn btn-primary px-3" style="width: 10px;float:right;margin-top: 11%;"><i class="fas fa-plus" aria-hidden="true"></i></button>
                       
                  
                    <?php 
                    if(isset($data['program_periods'])) {
                      $i=0;
                      ?>
                      @foreach ($data['program_periods'] as $key => $period)

                        <?php

                        $period['start_date'] = date('Y-m-d', strtotime($period['start_date']));
                        $period['end_date'] = date('Y-m-d', strtotime($period['end_date']));
                        ?>
                        <div class="form-group period_area" id="coachimg" style="float: left;">
                          <label for="name">Period <span class="input-required">*</span></label>

                          
                         
                          <input type="text" class="form-control" id="schedule_period" value="{{$period['start_date']}} - {{$period['end_date']}}" name="schedule_period" value="" aria-describedby="emailHelp" >
                           
                          <div class="schedule_start_date">
                            <input type="hidden" name="schedule_start_date[]" id="schedule_start_date" value="{{!empty($period['start_date']) ?  $period['start_date'] : $formatedDate}}">
                          </div>
                          <div class="schedule_end_date">
                          <input type="hidden" name="schedule_end_date[]" id="schedule_end_date" value="{{!empty($period['end_date']) ? $period['end_date'] : $formatedDate}}">
                          </div>
                        </div>
                        
                        <?php 
                        if ($i!=0) {
                          ?>
                          <!-- <button class="remove form-control btn btn-primary submit px-3" style="margin-top: 1%;">x</button> -->
                          <?php
                        }
                        $i++; ?>
                      @endforeach
                      <?php
                    }
                    else {
                      ?>
                    <div class="form-group" id="coachimg" style="float: left;">
                      <label for="name">Period <span class="input-required">*</span></label>

                        <input type="text" class="form-control" id="schedule_period" name="schedule_period" value="" required aria-describedby="emailHelp" >
                        <div class="schedule_start_date">
                          <input type="hidden" name="schedule_start_date[]" value="{{!empty($data['program']) ? old('schedule_start_date', $data['program']->schedule_start_date) : $formatedDate}}">
                        </div>
                        <div class="schedule_end_date">
                        <input type="hidden" name="schedule_end_date[]" value="{{!empty($data['program']) ? old('schedule_end_date', $data['program']->schedule_end_date) : $formatedDate}}">
                        </div>
                      </div>
                      <?php
                    }
                    ?>

                    
                  

                </div>
                <div class="col-md-12">
                  <div class="form-group">

                    <label for="location">Location</label>
                    
                    <select name="location_id" id ="location_id" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($city_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $data['rink']->location_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="dates">Starting age <span class="input-required">*</span></label>
                    <select name="starting_age" id ="starting_age" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <?php 
                      for($value = 1; $value <= 20; $value++){ 
                        ?>
                          <option value="{{$value}}" {{ (old('starting_age') ? old('starting_age') : $data['program']->starting_age ?? '') == $value ? 'selected' : ''}}>{{$value}}</option>
                        <?php
                      }
                      ?>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mt-37">
              <div class="form-group">
                <label for="name">Schedule <span class="input-required">*</span></label>
                <textarea class="form-control" id="schedule_log" name ="schedule_log">{{!empty($data['program']) ? old('schedule_log', $data['program']->schedule_log) : old('schedule_log')}}</textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="program-type">Program Type</label>
                <select class="form-control" id="program_type_id" name="program_type_id[]" multiple="multiple">
                  <?php 
                  if(!empty($data['program_type_id'])) {
                    ?>
                    @foreach($program_type_all as $id => $value)
                      <option value="{{$id}}" @foreach($data['program_type_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                    @endforeach
                    <?php 
                  } else {
                    ?>
                    @foreach($program_type_all as $id => $value)
                      <option value="{{$id}}">{{$value}}</option>
                    @endforeach
                    <?php
                  }
                  ?>
                </select>
                <i class="bi bi-plus-lg"></i>
              </div>
            </div>
          </div>
          <div class="row">
            <h2>Contacts</h2>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Phone <span class="input-required">*</span></label>
                <input type="text" class="form-control" id="contacts" name="contacts" value="{{!empty($data['program']) ? old('contacts', $data['program']->contacts) : old('contacts')}}" required aria-describedby="emailHelp" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">WhatsApp <span class="input-required">*</span></label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{!empty($data['program']) ? old('whatsapp', $data['program']->whatsapp) : old('whatsapp')}}" required aria-describedby="emailHelp" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Email <span class="input-required">*</span></label>
                <input type="text" class="form-control" id="email" name="email" value="{{!empty($data['program']) ? old('email', $data['program']->email) : old('email')}}" required aria-describedby="emailHelp" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2>Photos</h2>
              <div class="img-upload mb-4">
                <div id="image_preview">
                  @if(isset($data['program_photo']))
                    @foreach ($data['program_photo'] as $photo)
                      
                      
                        <img class="pic" src="{{$BASE_URL}}/{{$photo['path']}}" alt="{{$photo['name']}}">
                      
                    @endforeach
                  @endif
                </div>
                <input type="hidden" class="form-control" id="imagePath" name="image_path">
                <div id="aaa">    
                  <input accept="image/*" name="program_image_path[]" type='file' id="imgInp"  onchange="preview_image();" multiple/>

                  <i class="far fa-file-image"></i>
                  <i class="bi bi-plus-circle"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="offset-md-8 col-md-4 mb-4">
              <div class="btn-group">
                <button type="submit" id="cancel" class="form-control btn btn-primary submit px-3">Cancel</button>
                <button type="submit" id="save" class="form-control btn btn-primary submit px-3">Save</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>

    <script type="text/javascript">

      $(document).ready(function () {

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
  