@extends('layouts.frontend')
@section('title','Program Details')
@section('content')
    <div class="program-details">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h1>Victoria rink CanSkate program <i class="fas fa-share-alt"></i></h1>
              <h4>From September 15 to January 1</h4>
              <div class="row">
                <div class="col-md-6">
                  <label for="">Level</label>
                  <p>Advanced level</p>
                </div>
                <div class="col-md-6">
                  <label for="">Location</label>
                  <p>Vancouver island, Canada</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="">Schedule</label>
                  <div class="upClick">
                    <i class="bi bi-file-earmark-down-up-fill"></i> <span>Download a PDF</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="">Rink</label>
                  <p>Jhonny's rink</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="">Price</label>
                  <p>
                    550$
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">Coach</label>
                  <div class="row">
                    <div class="col-md-3 text-center">
                      <img src="{{ asset('img/patrick_chan.png') }}" alt="">
                      <p>Patrick Chan</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="program-slider">
                    <div class="item">
                      <img class="pic" src="https://via.placeholder.com/500x300.png" alt="PAT">
                    </div>
                    <div class="item">
                      <img class="pic" src="https://via.placeholder.com/500x300.png" alt="PAT">
                    </div>
                    <div class="item">
                      <img class="pic" src="https://via.placeholder.com/500x300.png" alt="PAT">
                    </div>
                  </div>
                  <div class="address text-center mt-5">
                    <label for="">Contact</label>
                    <p>
                      We have collected the best international practices and the classic Canadian
                      school in order to achieve the best results for our participants and instill
                      in them an even greater love for our favorite sport. We see the success and
                      joy of our children and are proud of the work done.
                    </p>
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
  