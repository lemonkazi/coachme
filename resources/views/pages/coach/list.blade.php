@extends('layouts.frontend')
@section('title',$data['Title'])
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
                        @foreach($speciality_all as $id => $value)
                          <div>
                            <label class="box">{{ $value }}
                              <input name="speciality_id" type="checkbox" value="{{ $id }}" {{ (old('speciality_id') ? old('speciality_id') : $_GET['speciality_id'] ?? '') == $id ? 'checked="checked"' : '' }} >
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        @endforeach
                        
                      </div>
                      <label for="">Coaching certificate</label>
                      <div class="check-section">
                        @foreach($certificate_all as $id => $value)
                          <div>
                            <label class="box">{{ $value }}
                              <input name="certificate_id" type="checkbox" value="{{ $id }}" {{ (old('certificate_id') ? old('certificate_id') : $_GET['certificate_id'] ?? '') == $id ? 'checked="checked"' : '' }} >
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

                  @if(isset($data['coaches']))
                    @foreach ($data['coaches'] as $coach)

                      <div class="col-sm-4 mb-2">
                        <div class="card profile">           
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12">
                                  @if(!empty($coach['avatar_image_path']))         
                                    <img src="{{$BASE_URL}}/photo/user_photo/{{$coach['avatar_image_path']}}" />      
                                  @else
                                    <img src="https://via.placeholder.com/150x150" alt="">        
                                  @endif
                                  
                                </div>
                                <div class="col-md-12">
                                  <h3>{{$coach['name']}} {{$coach['family_name']}}</h3>
                                  <h4>{{$coach['city_name']}}, {{$coach['province_name']}}</h4>
                                </div> 
                                <div class="col-md-12 learn-more">
                                  <a href="{{!empty($coach['id']) ? route('coach-details', ['user' => $coach['id']]): ''}}" class="btn btn-custom mb-2 green">Learn more</a>
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
  