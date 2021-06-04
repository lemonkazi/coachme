@extends('layouts.frontend')
@section('title','Coach Details')
@section('content')
    <div class="coach-details">
        <div class="container">
          <div class="row">
            <div class="col-md-5">
              <h2>Patrick Chan <i class="fas fa-share-alt"></i></h2>
              <div class="row">
                <div class="col-md-6">
                  <label for="">Experience</label>
                  <p>Advanced level</p>
                </div>
                <div class="col-md-6">
                  <label for="">Coaching certificate</label>
                  <p>Vancouver island, Canada</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="">Speciality</label>
                  <div class="upClick">
                    <i class="bi bi-file-earmark-down-up-fill"></i> <span>Download a PDF</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="">Language spoken</label>
                  <p>Jhonny's rink</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="">Price</label>
                  <p>
                    550$
                  </p>
                </div>
                <div class="col-md-6">
                  <label for="">Rink</label>
                  <p>
                    550$
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">Location</label>
                  <p>Vancouver island, Canada</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">About me</label>
                  <p>
                    Canadian former competitive figure skater. He is a 2018 Olympic gold
                    medallist in the team event, 2014 Olympic silver medallist in the men's
                    and team events, a three-time World champion, a two-time Grand Prix 
                    Final champion.
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">Contact</label>
                  <h5><i class="bi bi-telephone-fill"></i>+1-613-555-0146</h5>
                  <h5><i class="fas fa-at"></i>patrick_chan@gmail.com</h5>
                  <h5><i class="fab fa-linkedin"></i>+1-613-345-0865</h5>
                </div>
              </div>
            </div>
            <div class="offset-md-3 col-md-4 ">
              <img src="{{ asset('img/patrick_chan.png') }}" alt="" srcset="">
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
  