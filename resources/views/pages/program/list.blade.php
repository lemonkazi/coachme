@extends('layouts.frontend')
@section('title','Coach Details')
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
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div>
                      <label for="">Levels</label>
                      <div class="check-section">
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Location <span class="input-required">*</span></label>
                        <select class="form-control" id="rinks" name="rink_id[]" multiple="multiple">
                            <option value="0">0</option>
                            <option value="0">1</option>
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <div class="form-group position-relative without-label">
                        <select class="form-control" id="rinks" name="rink_id[]" multiple="multiple">
                            <option value="0">0</option>
                            <option value="0">1</option>
                        </select>
                        <i class="bi bi-plus-lg"></i>
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
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <label class="box">One
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Starting age <span class="input-required">*</span></label>
                        <select class="form-control" id="rinks" name="rink_id">
                          <option value="0">0</option>
                          <option value="1">1</option>
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Rink <span class="input-required">*</span></label>
                        <select class="form-control" id="rinks" name="rink_id[]" multiple="multiple">
                          <option value="0">0</option>
                          <option value="1">1</option>
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
                              <h6>{{$program['schedule_log']}}</h6>
                              <h5><i class="fas fa-map-marker-alt"></i>+{{$program['contacts']}}</h5>
                              <h5><i class="fas fa-clock"></i>{{$program['email']}}</h5>
                              <h5><i class="fas fa-road"></i>+{{$program['whatsapp']}}</h5>
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
  