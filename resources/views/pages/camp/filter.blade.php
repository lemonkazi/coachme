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
                        <a href="" class="btn btn-custom mb-2 green">View calendar</a>                
                      </h1>
                      <label for="">Type of program</label>
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
                        <select class="form-control campdates" id="location" name="location[]" multiple="multiple">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <div class="form-group position-relative without-label">
                        <select class="form-control campdates" id="location1" name="location1[]" multiple="multiple">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <div class="form-group range">
                        <label for="">Price Range</label>
                        <div>
                          <span class="minVal">$0</span>
                          <span class="maxVal">$1000</span>
                        </div>
                          <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[0,1000]"/>
                        <div>
                          <span>min</span>
                          <span>max</span>
                        </div>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Coach <span class="input-required">*</span></label>
                        <select class="form-control listdates" id="coach" name="coach[]" multiple="multiple">
                          <option value="0">0</option>
                          <option value="1">1</option>
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <label for="">Duration</label>
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
                        <label for="name">Date <span class="input-required">*</span></label>
                        <select class="form-control listdates" id="dates" name="dates[]" multiple="multiple">
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
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div id='calendar'></div>
                        </div>
                      </div>
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
      });

     

    </script>
    
@endsection
  