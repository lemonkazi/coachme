@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')

    <div class="camp-edit">
       <form action="{{!empty($data['camp']) ? route('camp-update', ['camp' => $data['camp']->id]): route('camp-create')}}"
       method="POST" enctype="multipart/form-data">
       @csrf
        <div class="container">
          {{session('msg')}}
          @if(session()->has('error'))
              <div class="alert alert-danger invalid-feedback d-block">{{ session()->get('error') }}</div>
          @endif
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif
          @if (session('warning'))
            <div class="alert alert-warning">
              {{ session('warning') }}
            </div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <div class="row">
            <div class="col-md-10">
              <div class="row">
                <h2>Basic information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Name of the camp <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{!empty($data['camp']) ? old('name', $data['camp']->name) : old('name')}}" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="location">Location</label>
                    <select name="location_id" id ="location" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($city_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $data['camp']->location_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="level">Level</label>
                    <select name="level_id" id ="level" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($level_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('level_id') ? old('level_id') : $data['camp']->level_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="camp-type">Camp Type</label>
                      <select name="camp_type_id" id ="camp_type_id" class="form-control" style="width: 100%">
                        <option value="">Select</option>
                        @foreach($camp_type_all as $id => $value)
                          <option value="{{ $id }}" {{ (old('camp_type_id') ? old('camp_type_id') : $data['camp']->camp_type_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                      <i class="bi bi-chevron-compact-down"></i>
                    </div>
                  </div>
                </div> 
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Dates <span class="input-required">*</span></label>
                    <div class="calender">
                      <i class="fas fa-calendar-alt"></i>
                      <input type="text" class="form-control" id="dates" name="dates" value="" required aria-describedby="emailHelp" >
                    </div>

                    <input type="hidden" name="start_date" value="{{!empty($data['camp']) ? old('start_date', $data['camp']->start_date) : $formatedDate}}">
                    <input type="hidden" name="end_date" value="{{!empty($data['camp']) ? old('end_date', $data['camp']->end_date) : $formatedDate}}">
                    
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Price <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="price" name="price" value="{{!empty($data['camp']) ? old('price', $data['camp']->price) : old('price')}}"  required aria-describedby="emailHelp" >
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Schedule</label>
                    <input accept="application/pdf,application/vnd.ms-excel" name="avatar_image_path" type='file' class="fileUp" />
                    <div class="upClick">
                      <i class="bi bi-file-earmark-arrow-up-fill"></i> <span>Upload a PDF</span>
                    </div>
                   
                  </div>
                </div>
                
                <h2>Photos</h2>
                <div class="img-upload mb-4">
                  <input accept="image/*" name="avatar_image_path" type='file' id="imgInp" />
                  <i class="far fa-file-image"></i>
                  <i class="bi bi-plus-circle"></i>
                </div>
                <h2>Contacts</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Phone <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="contacts" name="contacts" value="{{!empty($data['camp']) ? old('contacts', $data['camp']->contacts) : old('contacts')}}" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">WhatsApp <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{!empty($data['camp']) ? old('whatsapp', $data['camp']->whatsapp) : old('whatsapp')}}" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Email <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" value="{{!empty($data['camp']) ? old('email', $data['camp']->email) : old('email')}}" required aria-describedby="emailHelp" >
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                  <label for="about">About camp</label>
                    <textarea class="form-control" id="about" name ="about">{{!empty($data['camp']) ? old('about', $data['camp']->about) : old('about')}}</textarea>
                  </div>
                  <label>Coaches</label>
                  <div class="col-md-10 coachimg" id="coachimg-wrapper">
                    <div class="row coach1" id ="coachimg">
                      <div class="col-md-4">
                        <div class="img-upload mb-4 output">
                          
                          <img id="output" src="{{ asset('img/patrick_chan.png')}}" alt="PAT">
                          
                        </div>
                      </div>
                      <div class="col-md-7 pt-10">
                        <select data-placeholder="Choose a Coach..." id="coach_chosen" class="chosen-select" style="width:350px;" tabindex="4">
                          <option value=""></option>
                        </select>  
                        <p>Link to an existing coach account</p>
                      </div>

                      <button class="remove form-control btn btn-primary submit px-3">x</button>
                      
                    </div>
                    @foreach ($data['coaches'] as $coach)
                        <div class="row coach1" id ="coachimg">
                          <div class="col-md-4">
                            <div class="img-upload mb-4 output">
                              <img id="output" src="{{$BASE_URL}}/user_photo/{{$coach['avatar_image_path']}}" />
                              
                              
                            </div>
                          </div>
                          <div class="col-md-7 pt-10">
                            <input type="text" disabled class="form-control" id="coach" value="{{!empty($coach) ? $coach['name'] : ''}}" aria-describedby="emailHelp" >
                            <p>Link to an existing coach account</p>
                          </div>

                          <button class="remove form-control btn btn-primary submit px-3">x</button>
                          
                        </div>
                    @endforeach

                  </div>
                 <!--  <div class="row">
                    <div class="col-md-4 mb-4">
                      <button id="addMore" class="form-control btn btn-primary submit px-3">Add More</button>
                    </div>
                  </div> -->

                </div>
                <div class="offset-md-8 col-md-4 mb-4">
                  <div class="btn-group">
                    <button type="submit" id="cancel" class="form-control btn btn-primary submit px-3">Cancel</button>
                    <button type="submit" id="save" class="form-control btn btn-primary submit px-3">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
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
  