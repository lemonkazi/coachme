@extends('layouts.frontend')
@section('title','Coach Details')
@section('content')
    <div class="program-list">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
                <div class="card text-white card-has-bg click-col">        
                  <div class="card-img-overlay d-flex flex-column">
                    <div class="card-body">
                      <div class="row">
                        
                        
                      </div>
                    </div>
                    
                  </div>
                </div>
            </div>
            <div class="col-md-8">
              <h2>Rink basic information</h2>
              <div class="row">
              <div class="col-sm-12">
                <div class="card text-white card-has-bg click-col">        
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
  