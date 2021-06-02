@extends('layouts.frontend')
@section('title','camp edit')
@section('content')
    <div class="camp-edit">
      <form action=""
       method="POST" enctype="multipart/form-data">
        <div class="container">
          <div class="row">
            <div class="col-md-10">
              <div class="row">
                <h2>Basic information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Name of the camp <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="location">Location</label>
                    <select name="province_id" id ="location" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option value="">1</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="level">Level</label>
                    <select name="province_id" id ="level" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option value="">1</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Dates <span class="input-required">*</span></label>
                    <div class="calender">
                      <i class="fas fa-calendar-alt"></i>
                      <input type="text" class="form-control" id="dates" name="dates" value="" required aria-describedby="emailHelp" >
                    </div>
                    
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Price <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="dates" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Schedule <span class="input-required">*</span></label>
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
                    <input type="text" class="form-control" id="dates" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">WhatsApp <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="dates" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Email <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="dates" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                  <label for="about">About camp</label>
                    <textarea class="form-control" id="about" name ="about"></textarea>
                  </div>
                  <label>Coaches</label>
                  <div class="col-md-10 coachimg">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="img-upload mb-4">
                          <input accept="image/*" name="avatar_image_path" type='file' id="imgInp" onchange="loadFile(event)"/>
                          <img id="output" src="{{ asset('img/patrick_chan.png')}}" alt="PAT">
                          <i class="bi bi-plus-lg"></i>
                        </div>
                      </div>
                      <div class="col-md-8 pt-10">
                        <input type="text" class="form-control" id="dates" name="name" value="" required aria-describedby="emailHelp" >
                        <p>Link to an existing coach account</p>
                      </div>
                    </div>

                  </div>

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
  