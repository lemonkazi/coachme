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
              
              <a href="{{route('camp-create')}}" class="btn btn-custom mb-2 green col-md-3">Create a camp</a><br/>
              <a href="{{route('program-create')}}" class="btn btn-custom mb-4 blue col-md-3">Create a program</a>
              <div class="row">
                <div class="col-md-12">
                  <h2>Rink basic information</h2>
                  <div class="row">
                  <div class="col-sm-12">
                    <div class="card text-white card-has-bg click-col mb-4">        
                      <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-3">
                                <img src="https://via.placeholder.com/150x150" alt="">
                            </div>
                            <div class="col-md-6">
                              <h3>Your programs</h3>
                              <h6>Fall (sep-dec), Winter (jan-mar), Spring (apr-jun), Summer (jul-oct)</h6>
                              <h5><i class="fas fa-map-marker-alt"></i>+1-613-555-0146</h5>
                              <h5><i class="fas fa-clock"></i>patrick_chan@gmail.com</h5>
                              <h5><i class="fas fa-road"></i>+1-613-345-0865</h5>
                            </div> 
                            <div class="col-md-3 learn-more">
                              <a href="" class="btn btn-custom mb-2 green">Learn more</a>
                            </div>
                            
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <div class="card text-white card-has-bg click-col mb-4">        
                      <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-3">
                                <img src="https://via.placeholder.com/150x150" alt="">
                            </div>
                            <div class="col-md-6">
                              <h3>Your programs</h3>
                              <h6>Fall (sep-dec), Winter (jan-mar), Spring (apr-jun), Summer (jul-oct)</h6>
                              <h5><i class="fas fa-map-marker-alt"></i>+1-613-555-0146</h5>
                              <h5><i class="fas fa-clock"></i>patrick_chan@gmail.com</h5>
                              <h5><i class="fas fa-road"></i>+1-613-345-0865</h5>
                            </div> 
                            <div class="col-md-3 learn-more">
                              <a href="" class="btn btn-custom mb-2 green">Learn more</a>
                            </div>
                            
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <div class="card text-white card-has-bg click-col mb-4">        
                      <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-3">
                                <img src="https://via.placeholder.com/150x150" alt="">
                            </div>
                            <div class="col-md-6">
                              <h3>Your programs</h3>
                              <h6>Fall (sep-dec), Winter (jan-mar), Spring (apr-jun), Summer (jul-oct)</h6>
                              <h5><i class="fas fa-map-marker-alt"></i>+1-613-555-0146</h5>
                              <h5><i class="fas fa-clock"></i>patrick_chan@gmail.com</h5>
                              <h5><i class="fas fa-road"></i>+1-613-345-0865</h5>
                            </div> 
                            <div class="col-md-3 learn-more">
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
  