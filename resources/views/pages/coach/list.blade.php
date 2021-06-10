@extends('layouts.frontend')
@section('title','Coach Details')
@section('content')
    <div class="program-list coach-list">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
                <div class=" text-white">        
                  <div class="card-body">
                    <div class="row">
                      <h1>
                        Filters                    
                      </h1>
                      <label for="">Speciality</label>
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
                      <label for="">Coaching certificate</label>
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
                        <select class="form-control" id="rinks" name="rink_id">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      <div class="form-group position-relative without-label">
                        <select class="form-control" id="rinks" name="rink_id" >
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <i class="bi bi-chevron-compact-down"></i>
                      </div>
                      
                      <label for="">Price</label>
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
                        <label for="name">Rinks <span class="input-required">*</span></label>
                        <select class="form-control" id="rinks" name="rink_id[]" multiple="multiple">
                          <option value="0">0</option>
                          <option value="1">1</option>
                        </select>
                        <i class="bi bi-plus-lg"></i>
                      </div>
                      <div class="form-group position-relative">
                        <label for="name">Language <span class="input-required">*</span></label>
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
              <div class="col-sm-4 mb-2">
                <div class="card profile">           
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <img src="https://via.placeholder.com/150x150" alt="">
                        </div>
                        <div class="col-md-12">
                          <h3>Your programs</h3>
                          <h4>Vancouver, CAD</h4>
                        </div> 
                        <div class="col-md-12 learn-more">
                          <a href="" class="btn btn-custom mb-2 green">Learn more</a>
                        </div>
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-sm-4 mb-2">
                <div class="card profile">           
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <img src="https://via.placeholder.com/150x150" alt="">
                        </div>
                        <div class="col-md-12">
                          <h3>Your programs</h3>
                          <h4>Vancouver, CAD</h4>
                        </div> 
                        <div class="col-md-12 learn-more">
                          <a href="" class="btn btn-custom mb-2 green">Learn more</a>
                        </div>
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-sm-4 mb-2">
                <div class="card profile">           
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <img src="https://via.placeholder.com/150x150" alt="">
                        </div>
                        <div class="col-md-12">
                          <h3>Your programs</h3>
                          <h4>Vancouver, CAD</h4>
                        </div> 
                        <div class="col-md-12 learn-more">
                          <a href="" class="btn btn-custom mb-2 green">Learn more</a>
                        </div>
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-sm-4 mb-2">
                <div class="card profile">           
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <img src="https://via.placeholder.com/150x150" alt="">
                        </div>
                        <div class="col-md-12">
                          <h3>Your programs</h3>
                          <h4>Vancouver, CAD</h4>
                        </div> 
                        <div class="col-md-12 learn-more">
                          <a href="" class="btn btn-custom mb-2 green">Learn more</a>
                        </div>
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-sm-4 mb-2">
                <div class="card profile">           
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <img src="https://via.placeholder.com/150x150" alt="">
                        </div>
                        <div class="col-md-12">
                          <h3>Your programs</h3>
                          <h4>Vancouver, CAD</h4>
                        </div> 
                        <div class="col-md-12 learn-more">
                          <a href="" class="btn btn-custom mb-2 green">Learn more</a>
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
  