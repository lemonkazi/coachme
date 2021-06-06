@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-details">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h1>{{$data['program']->name}}<i class="fas fa-share-alt"></i></h1>
              <h4>From {{date('F', $data['schedule_start_date'])}} {{date('d', $data['schedule_start_date'])}} to {{date('F', $data['schedule_end_date'])}} {{date('d', $data['schedule_end_date'])}}</h4>
              <p class="gray">Window of registration: {{date('F', $data['reg_start_date'])}} to {{date('F', $data['reg_end_date'])}}</p>
              <a href="#" class="btn btn-custom mb-3">Register here</a>
              <div class="row">
                <div class="col-md-4">
                  <label for="">Level</label>
                  <p>{{$data['program']->level_name}}</p>
                </div>
                <div class="col-md-4">
                  <label for="">Price</label>
                  <p>{{$data['program']->price}}$</p>
                </div>
                <div class="col-md-4">
                  <label for="">Starting age</label>
                  <p>{{$data['program']->starting_age}}+</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="">Schedule</label>
                  <p>{{$data['program']->schedule_log}}</p>
                </div>
                <div class="col-md-8">
                  <label for="">Location</label>
                  <p>{{$data['program']->location_name}}<a href="">{{$data['program']->rink_name}}</a></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">About canskate</label>
                  <p>
                    {{$data['program']->about}}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="program-slider">
                    @if(isset($data['program_photo']))
                      @foreach ($data['program_photo'] as $photo)
                        
                        <div class="item">
                          <img class="pic" src="{{$BASE_URL}}/{{$photo['path']}}" alt="{{$photo['name']}}">
                        </div>
                      @endforeach
                    @endif
                    
                  </div>
                  <div class="address text-center mt-5">
                    <label for="">Contact</label>
                    <h5><i class="bi bi-telephone-fill"></i>+{{$data['program']->contacts}}</h5>
                    <h5><i class="fas fa-at"></i>{{$data['program']->email}}</h5>
                    <h5><i class="bi bi-telephone-fill"></i>+{{$data['program']->whatsapp}}</h5>
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
  