@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-list">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
                <div class=" text-white">        
                  <div class="card-body">
                    <div class="row">
                      <h1>
                        Filters                    
                      </h1>
                      <label for="">Type of program <i class="fas fa-info-circle"></i></label>
                      <div class="check-section">

                        @foreach($program_type_all as $id => $value)
                          <div>
                            <label class="box">{{ $value }}
                              <input name="program_type_id" type="checkbox" value="{{ $id }}" {{ (old('program_type_id') ? old('program_type_id') : $_GET['program_type_id'] ?? '') == $id ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        @endforeach
                        
                      </div>
                      <label for="">Levels</label>
                      <div class="check-section">

                        @foreach($level_all as $id => $value)
                          <div>
                            <label class="box">{{ $value }}
                              <input name="level_id" type="checkbox" value="{{ $id }}" {{ (old('level_id') ? old('level_id') : $_GET['level_id'] ?? '') == $id ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        @endforeach

                        
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Location <span class="input-required">*</span></label>
                        
                        <select name="province_id" id ="province_id" class="location form-control">
                          <option value="">Select</option>
                          @foreach($province_all as $id => $value)
                              <option value="{{ $id }}" {{ (old('province_id') ? old('province_id') : $_GET['province_id'] ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group position-relative without-label">
                        
                        <select name="location_id" id ="city_id" class="form-control location">
                          <option value="">Select</option>
                          @foreach($city_all as $id => $value)
                                <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $_GET['location_id'] ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            
                          @endforeach
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group range">
                        <label for="">Price Range</label>
                        <div>
                          <span>$0</span>
                          <span>$1000+</span>
                        </div>
                          <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[0,1000]"/>
                        <div>
                          <span>min</span>
                          <span>max</span>
                        </div>
                      </div>
                      
                      <label for="">Period</label>
                      <div class="check-section">

                        <?php
                        $period = [
                                'spring'    => 'Spring',
                                'summer'    => 'Summer',
                                'fall'      => 'Fall',
                                'winter'    => 'Winter'
                            ];
                        $myArray = array();
                        if (isset($_GET['period'])) {
                          $myArray = explode(',', $_GET['period']);
                        }
                        
                        ?>
                        <?php foreach ($period as $id => $value): ?>
                          <div>
                            <label class="box">{{ $value }}
                              <input name="period" type="checkbox" value="{{ $id }}" {{ (in_array($id, $myArray)) ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        <?php endforeach ?>
                        
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Starting age <span class="input-required">*</span></label>
                        <select class="form-control location" id="starting_age" name="starting_age">
                          <option value="">Select</option>
                          <?php 
                          for($value = 1; $value <= 20; $value++){ 
                            ?>
                              <option value="{{$value}}" {{ (old('starting_age') ? old('starting_age') : $_GET['starting_age'] ?? '') == $value ? 'selected' : ''}}>{{$value}}</option>
                            <?php
                          }
                          ?>
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Rink <span class="input-required">*</span></label>
                        <select class="form-control location" id="rinks" name="rink_id" multiple="multiple">
                          @foreach($rink_all as $id => $value)
                            <option value="{{$id}}" @foreach($filtered_rink as $aItemKey => $p) @if($id == $p)selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
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

                    @if(isset($data['programs']))
                      @foreach ($data['programs'] as $program)

                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-3">
                              @if(isset($program['program_photo'][0]))
                                <img src="{{$BASE_URL}}/{{$program['program_photo'][0]['path']}}" alt="">
                              @endif
                            </div>

                            
                            <div class="col-md-6">
                              <h3>{{$program['name']}}</h3>
                              <?php 
                              if(isset($program['program_period'])) {
                                
                                if(count($program['program_period']) >1) {
                                  $i=0;
                                  ?>
                                  <h6>
                                    @foreach ($program['program_period'] as $key => $period)

                                      @php
                                        $period['start_date'] = date('F', strtotime($period['start_date']));
                                        $period['end_date'] = date('F', strtotime($period['end_date']));
                                      @endphp
                                      {{ucwords(strtolower($period['type']))}} ({{$period['start_date']}} - {{$period['end_date']}})

                                    @endforeach
                                  </h6> 
                                  <?php
                                }
                                else {

                                  //$today = new DateTime();
                                  $today      = strtotime('today');
                                  $date_year = date('Y', $today);

                                  $start_date      = strtotime($program['program_period'][0]['start_date']);
                                  $start_year = date('Y', $start_date);
                                  if ($date_year == $start_year) {
                                    $start_date = date('F d', $start_date);
                                  } else {
                                    $start_date = date('F d, Y', $start_date);
                                  }
                                  

                                  $end_date      = strtotime($program['program_period'][0]['end_date']);
                                  $end_year = date('Y', $end_date);
                                  if ($date_year == $end_year) {
                                    $end_date = date('F d', $end_date);
                                  } else {
                                    $end_date = date('F d, Y', $end_date);
                                  }
                                  ?>
                                  <h6>{{$start_date}}-{{$end_date}}</h6>
                                  <?php
                                }
                              }
                              ?>
                              <h5><i class="fas fa-map-marker-alt"></i>{{$program['rink']['address']}}</h5>
                              <h5><i class="fas fa-clock"></i>Starting at {{$program['starting_age']}}</h5>
                              <h5><i class="fas fa-road"></i>{{$program['level_name']}}</h5>
                            </div> 
                            <div class="col-md-3 learn-more">
                              <a href="{{!empty($program['id']) ? route('program-details', ['program' => $program['id']]): ''}}" class="btn btn-custom mb-2 green">Learn more</a>
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
      });
    </script>
    
@endsection
  