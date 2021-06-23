@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="rink-list">
        <div class="container">
          <div class="row">
            <div class="col-md-10">
              <h2>Rink basic information</h2>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="location">Select your rink</label>
                    <select name="cookieRink" id="set_rink_id" class="set_cookie form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($rink_all as $id => $value)
                          <option value="{{ $id }}" {{ (old('rink_id') ? old('rink_id') : '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="location">Website link</label>
                    <input type="text" class="form-control set_cookie" id="set_web_site_url" name="cookieWebURL" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
              </div>
              
              <a href="{{route('camp-create')}}" class="btn btn-custom mb-2 green col-md-3 w-60">Create a camp</a><br/>
              <a href="{{route('program-create')}}" class="btn btn-custom mb-4 blue col-md-3 w-60">Create a program</a>
              <div class="row">
                <div class="col-md-12">
                  <h2>Your Programs</h2>
                  <div class="row">
                  <div class="col-sm-12">
                    @if(isset($data['programs']))
                      @foreach ($data['programs'] as $program)

                        <div class="card text-white card-has-bg click-col mb-4">        
                          <div class="card-img-overlay d-flex flex-column">
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
    </div>

    <script type="text/javascript">

      $(document).ready(function () {

        // add logic change value of result top condition
        $('.set_cookie').on('change', function(){
            var name = $(this).attr('name');
            if (name == '') {
                return false;
            }

            var value = $(this).val();
            var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';

            var data = {
                value: value,
                cookieName: name,
                _token:csrfToken
            };
            $.ajax({
              type: 'POST',
              url: baseUrl + '/ajax_set_cookie',
              data: data,
              //dataType: 'json',
              success: function (response) {
                console.log(response);
                // if (response) {
                //     $('#city_id').html(response);
                // } else {
                //     $('#city_id').html('');
                // }
              },
              complete: function () {}
            });
            return false;
        });



       
      });
    </script>
    
@endsection
  