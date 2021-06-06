@extends('layouts.frontend')
@section('title','Program edit')
@section('content')
    <div class="program-edit">
      <form action=""
       method="POST" enctype="multipart/form-data">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <h2>Basic information</h2>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Name of the program <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="location">Level</label>
                    
                    <select name="province_id" id ="location" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option value="">1</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="dates">Window of registration <span class="input-required">*</span></label>
                    <div class="calender">
                      <i class="fas fa-calendar-alt"></i>
                      <input type="text" class="form-control" id="dates" name="dates" value="" required aria-describedby="emailHelp" >
                    </div>
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Price">Price <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="Price" name="" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="about">About program</label>
                    <textarea class="form-control" id="about" name ="about"></textarea>                   
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 ">
              <div class="row ">
                <h6 class="mb-3">Schedule</h6>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="name">Period <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="location">Location</label><span><a href="" >+Add link to my Rink</a></span>
                    <select name="province_id" id ="location" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option value="">1</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="dates">Starting age <span class="input-required">*</span></label>
                    <select name="province_id" id ="location" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option value="">1</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mt-37">
              <div class="form-group">
                <label for="name">Schedule <span class="input-required">*</span></label>
                <textarea class="form-control" id="about" name ="about"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <h2>Contacts</h2>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Phone <span class="input-required">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">WhatsApp <span class="input-required">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Email <span class="input-required">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2>Photos</h2>
              <div class="img-upload mb-4">
                <div id="image_preview"></div>
                <div>
                  <input accept="image/*" name="avatar_image_path[]" type='file' id="imgInp" onchange="preview_image();" multiple />
                  <i class="far fa-file-image"></i>
                  <i class="bi bi-plus-circle"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="offset-md-8 col-md-4 mb-4">
              <div class="btn-group">
                <button type="submit" id="cancel" class="form-control btn btn-primary submit px-3">Cancel</button>
                <button type="submit" id="save" class="form-control btn btn-primary submit px-3">Save</button>
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
  