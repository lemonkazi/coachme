@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-list camp-list">
        <div class="container">
          <div class="row">
            <div class="col-md-12  d-flex justify-content-between">
              <button class="btn btn-custom text-white openTab sp"> Filter</button>
              <a href="{{ url('/camp/list')}}" class="btn btn-custom mb-2 green sp">View List</a>  
            </div>
            <div class="col-md-4 filter">
                <div class=" text-white">        
                  <div class="card-body">
                    <div class="row">
                      <h1>
                        Filters  <i class="bi bi-x sp"></i>
                        <a href="{{ url('/camp/list')}}" class="btn btn-custom mb-2 green pc">View List</a>                
                      </h1>
                      <div class="form-group position-relative">
                        <label for="name">Discipline</label>
                        <?php
                        $specialityArray = array();
                        if (isset($_GET['speciality_id'])) {
                          $specialityArray = explode(',', $_GET['speciality_id']);
                        }
                        ?>
                        <select class="form-control listdates location" id="speciality_id" name="speciality_id" multiple="multiple">
                          @foreach($speciality_all as $id => $value)
                            <option value="{{$id}}" @foreach($specialityArray as $aItemKey => $p) @if($id == $p)selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Age</label>
                        <?php
                        $ageArray = array();
                        if (isset($_GET['age_id'])) {
                          $ageArray = explode(',', $_GET['age_id']);
                        }
                        ?>
                        <select class="form-control listdates location" id="age_id" name="age_id" multiple="multiple">
                          @foreach($age_all as $id => $value)
                            <option value="{{$id}}" @foreach($ageArray as $aItemKey => $p) @if($id == $p)selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Levels</label>
                        <?php
                        $levelArray = array();
                        if (isset($_GET['level_id'])) {
                          $levelArray = explode(',', $_GET['level_id']);
                        }
                        ?>
                        <select class="form-control listdates location" id="level_id" name="level_id" multiple="multiple">
                          @foreach($level_all as $id => $value)
                            <option value="{{$id}}" @foreach($levelArray as $aItemKey => $p) @if($id == $p)selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                        </select>
                        <i class="bi bi-plus-lg"></i>
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
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div id='calendar'></div>
                        </div>
                        <div class="events sp">
                          <?php
                          $backgroundColor = array(
                            0=>'#A7DAE9',
                            1=>'#D0E6A5',
                            2=>'#D1B3DD'
                          );
                          $response = '';
                          foreach ($current_camps as $key => $value) {

                          
                            // It returns array of random keys
                            //$key = array_rand( $backgroundColor);
                            $value['start_date'] = strtotime($value['start_date']);
                            $value['start_date'] = date( 'M d', $value['start_date']);

                            $value['end_date'] = strtotime($value['end_date']);
                            $value['end_date'] = date( 'M d', $value['end_date']);

                            if (isset($backgroundColor[$key])) {
                              $backgroundColor[$key] = $backgroundColor[$key];
                            } else {
                              $backgroundColor[$key] = '#A7DAE9';
                            }

                            $response .= '<div class="event" style="background-color:'.$backgroundColor[$key].'">';
                            $response .= '<h4>'.$value['name'].'</h4>';
                            $response .= '<p>'.$value['start_date'].' - '.$value['end_date'].'</p>';
                            $response .= '</div>';
                          }
                          echo $response;
                          ?>
                          <!-- <div class="event">
                            <h4>Annecy club summer camp</h4>
                            <p>May 1 - May 15</p>
                          </div> -->
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-md-12 sp">
                  
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        console.log('<?php echo json_encode($camps) ?>');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid','moment','interaction' ],
          header: { center: 'prev,title,next,agendaWeek', left: '',right:'' },
          //link https://fullcalendar.io/docs/v4/dateClick
          dateClick: function(info) {          
            console.log(info.date.toISOString());
            console.log(info.dateStr);
            console.log(info.allDay);
            console.log(info.dayEl);
            console.log(info.jsEvent);

            var date = info.dateStr;
            $('.events').html('');
            if (date == '') {
                return false;
            }

            //var value = $(this).val();
            var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
          

            var data = {
                date: date,
                _token:csrfToken,
                params:<?php echo json_encode($params) ?>
            };


            $.ajax({
              type: 'POST',
              url: baseUrl + '/ajax_get_camp',
              data: data,
              //dataType: 'json',
              success: function (response) {
                console.log(response);
                if (response) {
                    $('.events').html(response);
                } else {
                    $('.events').html('');
                }
              },
              complete: function () {}
            });
            //return false;
            //$('.event').show();
          },
          events : <?php echo json_encode($camps) ?>
          
        });

        calendar.render();
      });
    </script>
    <script type="text/javascript">

      $(document).ready(function () {
        
        console.log($('.min-slider-handle').attr('aria-valuenow'));
        $('.min-slider-handle').on('change',function(){
          console.log($(this).attr('aria-valuenow'))
        })
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
  