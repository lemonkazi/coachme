@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-details">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h1> {{$data['camp']->name}}<i class="fas fa-share-alt"></i>
              </h1>
              <h4>From September 15 to January 1</h4>
              <div class="row">
                <div class="col-md-6">
                  <label for="">Level</label>
                  <p>{{$data['camp']->level_name}}</p>
                </div>
                <div class="col-md-6">
                  <label for="">Location</label>
                  <p>{{$data['camp']->location_name}}</p>
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
                  <p>{{$data['camp']->rink_name}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="">Price</label>
                  <p>
                    {{$data['camp']->price}}$
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="">Coach</label>
                  @if(isset($data['coaches']))
                    @foreach ($data['coaches'] as $coach)
                      <div class="row">
                        <div class="col-md-3 text-center">
                          <img src="{{$BASE_URL}}/photo/user_photo/{{$coach['avatar_image_path']}}" alt="">
                          <p>{{!empty($coach) ? $coach['name'] : ''}}</p>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="program-slider">
                    @if(isset($data['camp_photo']))
                      @foreach ($data['camp_photo'] as $photo)
                        
                        <div class="item">
                          <img class="pic" src="{{$BASE_URL}}/{{$photo['path']}}" alt="PAT">
                        </div>
                      @endforeach
                    @endif
                    
                  </div>
                  <div class="address text-center mt-5">
                    <label for="">Contact</label>
                    <p>
                      {{$data['camp']->about}}
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
  