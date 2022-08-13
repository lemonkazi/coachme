@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="coach-details">
        <div class="container">
          <div class="row">
            <div class=" col-md-7 text-right sp">
              <img src="{{$BASE_URL}}/photo/user_photo/{{$data['user']->avatar_image_path}}" />
            </div>
            <div class="col-md-5">
              <h2>{{$data['user']->name}} {{$data['user']->family_name}} <i class="fas fa-share-alt"></i></h2>
              <div class="row">
                <div class="col-md-6 wid-50">
                  <label for="">Experience</label>
                  <p>{{$data['user']->experience_name}}</p>
                </div>
                <div class="col-md-6 wid-50">
                  <label for="">Coaching certificate</label>
                  <p>{{$data['user']->certificate_name}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 wid-50">
                  <label for="">Discipline</label>
                  <p>{{$data['speciality']}}</p>
                </div>
                <div class="col-md-6 wid-50">
                  <label for="">Language spoken</label>
                  <p>{{$data['language']}}</p>
                </div>
              </div>
              <div class="pc">
                <div class="row ">
                  <div class="col-md-6">
                    <label for="">Price</label>
                    <p>
                      {{$data['user']->price_name}}
                    </p>
                  </div>
                  <div class="col-md-6">
                    <label for="">Rink</label>
                    <p>
                      {{$data['rink']}}
                    </p>
                  </div>
                </div>
                <div class="row ">
                  <div class="col-md-12">
                    <label for="">Location</label>
                    <p>{{$data['user']->city_name}}</p>
                  </div>
                </div>
              </div>
              <div class="sp">
                <div class="row">
                  <div class="col-md-6 wid-50">
                    <label for="">Location</label>
                    <p>{{$data['user']->city_name}}</p>
                  </div>
                  <div class="col-md-6 wid-50">
                    <label for="">Price</label>
                    <p>
                      {{$data['user']->price_name}}$
                    </p>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Rink</label>
                    <p>
                      {{$data['rink']}}
                    </p>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                  <label for="">About me</label>
                  <p>
                    {{$data['user']->about}}
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">Contact</label>
                  <h5>{{$data['user']->website}}</h5>
                  <h5><i class="bi bi-telephone-fill"></i>+{{$data['user']->phone_number}}</h5>
                  <h5><i class="fas fa-at"></i>{{$data['user']->email}}</h5>
                  <h5><i class="fab fa-linkedin"></i>+{{$data['user']->whatsapp}}</h5>
                </div>
              </div>
            </div>
            <div class=" col-md-7 text-right pc">
              <img src="{{$BASE_URL}}/photo/user_photo/{{$data['user']->avatar_image_path}}" />
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
  