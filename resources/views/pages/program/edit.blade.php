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
                    <input type="text" class="form-control" id="Price" name="dates" value="" required aria-describedby="emailHelp" >
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
            <div class="col-md-3">
              <div class="row">
                <h6>Basic information</h6>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="name">Period <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="" required aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="location">Level</label>
                    <select name="province_id" id ="location" class="form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option value="">1</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="dates">Window of registration <span class="input-required">*</span></label>
                    <div class="calender">
                      <i class="fas fa-calendar-alt"></i>
                      <input type="text" class="form-control" id="dates" name="dates" value="" required aria-describedby="emailHelp" >
                    </div>
                    
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
  