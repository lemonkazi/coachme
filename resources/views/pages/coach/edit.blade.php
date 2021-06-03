@extends('layouts.frontend')
@section('title',$data['Title'])
@section('content')
    <div class="coach-edit">
      <form action="{{!empty($data['user']) ? route('profile-update'): ''}}"
       method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
          {{session('msg')}}

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

                <div class="img-upload mb-4">
                  <input accept="image/*" name="avatar_image_path" type='file' id="imgInp" />
                  <img id="blah" src="{{$BASE_URL}}/user_photo/{{$data['user']->avatar_image_path}}" alt="PAT">

                  <i class="bi bi-plus-lg"></i>
                </div>
                <h2>Basic information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Name <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{!empty($data['user']) ? old('name', $data['user']->name) : old('name')}}" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="family">Family name</label>
                    <input type="text" class="form-control" id="family_name" name="family_name" placeholder="Family Name"  value="{{!empty($data['user']) ? old('family_name', $data['user']->family_name) : old('family_name')}}" aria-describedby="emailHelp">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="province">Province</label>
                    <select name="province_id" id ="province_id" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($province_all as $id => $value)
                          <option value="{{ $id }}" {{ (old('province_id') ? old('province_id') : $data['user']->province_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="about">About me</label>
                    <textarea class="form-control" id="about" name ="about">{{!empty($data['user']) ? old('about', $data['user']->about) : old('about')}}</textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="city">City</label>
                    <select name="city_id" id ="city_id" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      @foreach($city_all as $id => $value)
                        @if ($data['user']->city_id === $id || old('city_id') === $id)
                            <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $data['user']->city_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                        @endif
                      @endforeach
                    </select>
                    <div class="form-check">
                      @if ($data['user']->is_published === 1)
                          <input type="checkbox" name="is_published" checked="" class="form-check-input" id="is_published">
                      @else
                          <input type="checkbox" name="is_published" {{ old('is_published') ? 'checked' : '' }} class="form-check-input" id="is_published">
                      @endif
                      <label class="form-check-label" for="is_published">Publish my account</label>
                    </div>
                  </div>
                </div>
                <h2>Coach information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="speciality">Speciality</label>
                    <select class="form-control" id="speciality" name="speciality_id[]" multiple="multiple">

                      @foreach($speciality_all as $id => $value)
                        <option value="{{$id}}" @foreach($data['user']->userinfos['speciality'] as $aItemKey => $p) @if($id == $p->content_id)selected="selected"@endif @endforeach>{{$value}}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="experience">Experience</label>
                    <select class="form-control" id="experience_id" name="experience_id">
                      <option value="">Select</option>
                      @foreach($experience_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('experience_id') ? old('experience_id') : $data['user']->experience_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="certificate">Coaching certificate</label>
                    <select class="form-control" id="certificate_id" name="certificate_id">
                      <option value="">Select</option>
                      @foreach($certificate_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('experience_id') ? old('experience_id') : $data['user']->experience_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="rinks">Rinks</label>
                    <select class="form-control" id="rinks" name="rink_id[]" multiple="multiple">

                      @foreach($rink_all as $id => $value)
                        <option value="{{$id}}" @foreach($data['user']->userinfos['rinks'] as $aItemKey => $p) @if($id == $p->content_id)selected="selected"@endif @endforeach>{{$value}}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="language">Language spoken</label>
                    <select class="form-control" id="language" name="language_id[]" multiple="multiple">

                      @foreach($language_all as $id => $value)
                        <option value="{{$id}}" @foreach($data['user']->userinfos['languages'] as $aItemKey => $p) @if($id == $p->content_id)selected="selected"@endif @endforeach>{{$value}}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Price</label>
                    <select class="form-control" id="price_id" name="price_id">
                      <option value="">Select</option>
                      @foreach($price_all as $id => $value)
                        <option value="{{ $id }}" {{ (old('price_id') ? old('price_id') : $data['user']->price_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <h2>Contact</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{!empty($data['user']) ? old('phone_number', $data['user']->phone_number) : old('phone_number')}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">WhatsApp</label>
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{!empty($data['user']) ? old('whatsapp', $data['user']->whatsapp) : old('whatsapp')}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"  value="{{!empty($data['user']) ? old('email', $data['user']->email) : old('email')}}" required>
                  </div>
                </div>
                <div class="col-md-4 mb-4">
                  <a href="{{route('camp-create')}}" id="create-camp" class="form-control btn btn-primary submit px-3">Create a camp</a>
                </div>
                <div class="offset-md-4 col-md-4 mb-4">
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
  