@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-list camp-list">
        <div class="container">
          <div class="row">
            <div class="col-md-12  d-flex justify-content-between">
              <button class="btn btn-custom text-white openTab sp"> Filter</button>
              <a href="{{ url('/camp/filter')}}" class="btn btn-custom mb-2 green sp">View calendar</a> 
            </div>
            <div class="col-md-4 filter">

                <div class=" text-white">        
                  <div class="card-body">
                    <div class="row">

                      <h1>
                        Filters  <i class="bi bi-x sp"></i>
                        <a href="{{ url('/camp/filter')}}" class="btn btn-custom mb-2 green pc">View calendar</a>                
                      </h1>
                      <label for="">Type of Camp</label>
                      <div class="check-section">
                        <?php
                        $campArray = array();
                        if (isset($_GET['camp_type_id'])) {
                          $campArray = explode(',', $_GET['camp_type_id']);
                        }
                        
                        ?>

                        @foreach($camp_type_all as $id => $value)
                          <div>
                            <label class="box">{{ $value }}
                              <input name="camp_type_id" type="checkbox" value="{{ $id }}" {{ (in_array($id, $campArray)) ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        @endforeach
                      </div>
                      <label for="">Levels</label>
                      <div class="check-section">
                        <?php
                        $levelArray = array();
                        if (isset($_GET['level_id'])) {
                          $levelArray = explode(',', $_GET['level_id']);
                        }
                        
                        ?>

                        @foreach($level_all as $id => $value)
                          <div>
                            <label class="box">{{ $value }}
                              <input name="level_id" type="checkbox" value="{{ $id }}" {{ (in_array($id, $levelArray)) ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        @endforeach
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Location <span class="input-required">*</span></label>        
                        <select name="province_id" id ="province_id" class="location form-control listdates">
                          <option value="">Select</option>
                          @foreach($province_all as $id => $value)
                              <option value="{{ $id }}" {{ (old('province_id') ? old('province_id') : $_GET['province_id'] ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group position-relative without-label">                        
                        <select name="location_id" id ="city_id" class="form-control location listdates">
                          <option value="">Select</option>
                          @foreach($city_all as $id => $value)
                            <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $_GET['location_id'] ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            
                          @endforeach
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group range">
                        <label for="">Price Range</label>
                        <?php 
                        $min = 0;
                        $max = $maxPrice;
                        if (isset($_GET['min']) && !empty($_GET['min'])) {
                          $min = $_GET['min'];
                        }
                        if (isset($_GET['max']) && !empty($_GET['max'])) {
                          $max = $_GET['max'];
                        }
                        ?>
                        <div>
                          <span class="minVal">${{$min}}</span>
                          <span class="maxVal">${{$max}}</span>
                        </div>
                          <input id="ex2" type="text" class="span2" value="" data-slider-min="0" data-slider-max="{{$maxPrice}}" data-slider-step="5" data-slider-value="[{{$min}},{{$max}}]"/>
                        <div>
                          <span>min</span>
                          <span>max</span>
                        </div>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Coach <span class="input-required">*</span></label>
                        <select class="form-control listdates location" id="coach" name="coach_id" multiple="multiple">
                          @if(isset($data['coaches']))
                            @foreach ($data['coaches'] as $id => $value)
                              <option value="{{$id}}" @foreach($filtered_coach as $aItemKey => $p) @if($id == $p)selected="selected"@endif @endforeach>{{$value}}</option>
                          
                            @endforeach
                          @endif
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <label for="">Duration</label>
                      <div class="check-section">

                        <?php
                        $duration = [
                                'day_0-3'    => '1-3 days',
                                'day_4-7'    => '4-7 days',
                                'day_8-21'      => '1-3 weeks',
                                'day_22-100'    => '4* weeks'
                            ];
                        $myArray = array();
                        if (isset($_GET['duration'])) {
                          $myArray = explode(',', $_GET['duration']);
                        }
                        
                        ?>
                        <?php foreach ($duration as $id => $value): ?>
                          <div>
                            <label class="box">{{ $value }}
                              <input name="duration" type="checkbox" value="{{ $id }}" {{ (in_array($id, $myArray)) ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        <?php endforeach ?>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Date <span class="input-required">*</span></label>
                        <select class="form-control listdates location" id="campdates" name="month" multiple="multiple">
                          
                          <?php
                          foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $new_i => $date_str) {
                              
                              $new_i = $new_i+1; 
                              ?>
                              <option value="{{$new_i}}" @foreach($filtered_month as $aItemKey => $p) @if($new_i == $p)selected="selected"@endif @endforeach>{{$date_str}}</option>
                            <?php
                          }
                          ?>
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-8">
              <div class="row">
              <div class="col-sm-12">
                <div class="card card-has-bg click-col">

                    @if(isset($data['camps']))
                      @foreach ($data['camps'] as $camp)

                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-3">
                              <?php if(isset($camp['camp_photo'][0])){ ?>
                                <img src="{{$BASE_URL}}/{{$camp['camp_photo'][0]['path']}}" alt="">
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
                                    
                                      {{$camp['rink']['city_name']}}
                                    
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
                              <a href="{{!empty($camp['id']) ? route('camp-details', ['camp' => $camp['id']]): ''}}" class="btn btn-custom mb-2 green">Learn more</a>
                            </div>
                            
                          </div>
                        </div>
                       
                      @endforeach
                    @endif 
                    
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <script type="text/javascript">

      $(document).ready(function () {
        $("#ex2").bootstrapSlider({});
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
        $('.openTab').on('click',function (e) {
          e.preventDefault();
          $('.filter').show();

        })
        $('h1 i').on('click',function(e) {
          e.preventDefault();
          $('.filter').hide();
        })
      });
    </script>
    
@endsection
  