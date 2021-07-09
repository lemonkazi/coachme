@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="program-details camp-details">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h1> {{$data['camp']->name}}<i class="fas fa-share-alt"></i>
              </h1>
              <div class="col-md-6 sp">
                <div class="row">
                  <div class="col-md-12">
                    <div class="program-slider">
                      @if(isset($data['camp_photo']))
                        @foreach ($data['camp_photo'] as $photo)
                          
                          <div class="item">
                            <img class="pic" src="{{$BASE_URL}}/{{$photo['path']}}" alt="{{$photo['name']}}">
                          </div>
                        @endforeach
                      @endif
                      
                    </div>
                  </div>
                </div> 
              </div>
              <h4>From {{date('F', $data['start_date'])}} {{date('d', $data['start_date'])}} to {{date('F', $data['end_date'])}} {{date('d', $data['end_date'])}}</h4>
              <div class="row pc">
                <div class="col-md-6 ">
                  <label for="">Level</label>
                  <p>{{$data['camp']->level_name}}</p>
                </div>
                <div class="col-md-6 ">
                  <label for="">Location</label>
                  <p>{{$data['camp']->location_name}}</p>
                </div>
              </div>
              <div class="row pc">
                <div class="col-md-6 ">
                  <label for="">Schedule</label>


                  <div class="upClick">
                    @if(isset($data['camp_schedule']))
                      @foreach ($data['camp_schedule'] as $schedule)
                        <a href="javascript:void(0);" onclick='downloadPDF("{{$BASE_URL}}/{{$schedule['path']}}");'>
                          <i class="bi bi-file-earmark-down-up-fill"></i> <span>Download a PDF</span>
                        </a>
                        
                      @endforeach
                    @endif

                    
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="">Rink</label>
                  <p>{{$data['camp']->rink_name}}</p>
                </div>
              </div>
              <div class="row pc">
                <div class="col-md-4">
                  <label for="">Price</label>
                  <p>
                    {{$data['camp']->price}}$
                  </p>
                </div>
              </div>
              <div class="row sp d-flex">
                <div class="col-md-6 wid-50">
                  <label for="">Level</label>
                  <p>{{$data['camp']->level_name}}</p>
                </div>
                <div class="col-md-4 wid-50">
                  <label for="">Price</label>
                  <p>
                    {{$data['camp']->price}}$
                  </p>
                </div>
                
              </div>
              <div class="row sp d-flex">
                <div class="col-md-6 wid-50">
                  <label for="">Schedule</label>


                  <div class="upClick">
                    @if(isset($data['camp_schedule']))
                      @foreach ($data['camp_schedule'] as $schedule)
                        <a href="javascript:void(0);" onclick='downloadPDF("{{$BASE_URL}}/{{$schedule['path']}}");'>
                          <i class="bi bi-file-earmark-down-up-fill"></i> <span>Download a PDF</span>
                        </a>
                        
                      @endforeach
                    @endif

                    
                  </div>
                </div>
                <div class="col-md-6 wid-50">
                  <label for="">Location</label>
                  <p>{{$data['camp']->location_name}}</p>
                </div>
                
              </div>
              <div class="row sp">
                <div class="col-md-6">
                  <label for="">Rink</label>
                  <p>{{$data['camp']->rink_name}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 coach">
                  <label for="">Coach</label>
                    <div class="row">
                      @if(isset($data['coaches']))
                        @foreach ($data['coaches'] as $coach)
                        
                            <div class="col-md-3 text-center wid-30 {{!empty($coach['id']) ? $coach['id'] : ''}}">
                              @if(isset($coach['avatar_image_path']))
                                <img src="{{$BASE_URL}}/photo/user_photo/{{$coach['avatar_image_path']}}" alt="">
                              @else
                                <!-- <img src="{{ asset('img/avatar.png') }}" alt=""> -->
                                <img src="https://via.placeholder.com/150x150" alt=""> 
                              @endif
                              <p>{{!empty($coach['name']) ? $coach['name'] : ''}}</p>
                            </div>
                        
                        @endforeach
                      @endif

                      @if(isset($data['coaches_datas_new']))
                        @foreach ($data['coaches_datas_new'] as $coach)
                        
                            <div class="col-md-3 text-center wid-30 ">
                              @if(isset($coach['avatar_image_path']))
                                <img src="{{$BASE_URL}}/{{$coach['avatar_image_path']}}" alt="">
                              @else
                                <!-- <img src="{{ asset('img/avatar.png') }}" alt=""> -->
                                <img src="https://via.placeholder.com/150x150" alt=""> 
                              @endif
                              <p>{{!empty($coach['name']) ? $coach['name'] : ''}}</p>
                            </div>
                        
                        @endforeach
                      @endif
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 pc">
              <div class="row">
                <div class="col-md-12">
                  <div class="program-slider ">
                    @if(isset($data['camp_photo']))
                      @foreach ($data['camp_photo'] as $photo)
                        
                        <div class="item">
                          <img class="pic" src="{{$BASE_URL}}/{{$photo['path']}}" alt="{{$photo['name']}}">
                        </div>
                      @endforeach
                    @endif
                    
                  </div>
                  <div class="address text-center mt-5">
                    <label for="">About Camp</label>
                    <p>
                      {{$data['camp']->about}}
                    </p>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-md-6 sp">
              <div class="row">
                <div class="col-md-12">
                  <div class="address text-center mt-5">
                    <label for="">About Camp</label>
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
  