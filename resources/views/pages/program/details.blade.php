@extends('layouts.frontend')
@section('title','Program Details')
@section('content')
    <div class="program-details">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h1>Victoria rink CanSkate program <i class="fas fa-share-alt"></i></h1>
              <h4>From September 15 to January 1</h4>
              <p class="gray">Window of registration: June to august</p>
              <a href="#" class="btn btn-custom">Register here</a>
              <div class="row">
                <div class="col-md-4">
                  <label for="">Level</label>
                  <p>Advanced level</p>
                </div>
                <div class="col-md-4">
                  <label for="">Price</label>
                  <p>1,500$</p>
                </div>
                <div class="col-md-4">
                  <label for="">Starting age</label>
                  <p>12+</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="">Schedule</label>
                  <p>10am. - 5pm.<br/>3h on ice & 2h off ice</p>
                </div>
                <div class="col-md-8">
                  <label for="">Location</label>
                  <p>Vancouver island, Canada.<a href="">Victoria rink</a></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">About canskate</label>
                  <p>
                    CanSkate is Skate Canada's flagship learn-to-skate program, designed for
                    beginners of all ages. When you sign up for CanSkate you will be in a program
                    that focuses on fun, participation and basic skill development. You will earn
                    badges and other incentives as you learn fundamental skating skills. Lessons
                    are given in a group format and led by our NCCP certified professional 
                    coaches. Professional coaches are assisted by trained Program Assistants.
                    Skaters progress at their own rate and coaches make sessions active using
                    teaching aids, music and a wide variety of activities that create a fun
                    environment and promote learning.
                  </p>
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
                  <div class="address text-center">
                    <label for="">Contact</label>
                    <h5><i class="bi bi-telephone-fill"></i>+1-613-555-0146</h5>
                    <h5><i class="fas fa-at"></i>patrick_chan@gmail.com</h5>
                    <h5><i class="bi bi-telephone-fill"></i>+1-613-345-0865</h5>
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
  