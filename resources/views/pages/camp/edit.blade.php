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
                @if ($data['user']->authority =='COACH_USER')
                  <a href="{{ url('/coach-account') }}" class="back_btn">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                  </a>
                @else
                  <a href="{{ url('/rink/list') }}" class="back_btn">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                  </a>
                @endif
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
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $data['rink']->location_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
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
                      <label for="speciality">Discipline</label>
                      <select class="form-control" id="speciality" name="speciality_id[]" multiple="multiple">
                        <?php 
                        if(!empty($data['speciality_id'])) {
                          ?>
                          @foreach($speciality_all as $id => $value)
                            <option value="{{$id}}" @foreach($data['speciality_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                          <?php 
                        } else {
                          ?>
                          @foreach($speciality_all as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                          @endforeach
                          <?php
                        }
                        ?>
                      </select>
                      <i class="bi bi-plus-lg"></i>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="phone">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="{{!empty($data['user']) ? old('website', $data['user']->website) : old('website')}}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="level">Age</label>
                      <select class="form-control" id="age" name="age_id[]" multiple="multiple">
                        <?php 
                        if(!empty($data['age_id'])) {
                          ?>
                          @foreach($age_all as $id => $value)
                            <option value="{{$id}}" @foreach($data['age_id'] as $aItemKey => $p) @if($id == $p['id'])selected="selected"@endif @endforeach>{{$value}}</option>
                          @endforeach
                          <?php 
                        } else {
                          ?>
                          @foreach($age_all as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                          @endforeach
                          <?php
                        }
                        ?>
                      </select>
                      <i class="bi bi-plus-lg"></i>
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
                    <label for="dates">Schedule <span class="input-required">*</span></label>
                    @if(isset($data['camp_schedule']))
                      @foreach ($data['camp_schedule'] as $schedule)
                        <a href="javascript:void(0);" onclick='downloadPDF("{{$BASE_URL}}/{{$schedule['path']}}");'>
                          <i class="bi bi-file-earmark-down-up-fill"></i> <span>Download a PDF</span>
                        </a>
                        
                      @endforeach
                    @endif
                    <input accept="application/pdf,application/vnd.ms-excel" name="schedule_pdf_path[]" type='file' class="fileUp" onchange="file_name();"  />

                    <div class="upClick">
                      <i class="bi bi-file-earmark-arrow-up-fill"></i> <span>Upload a PDF</span>
                    </div>
                   
                  </div>
                </div>
                
                <h2>Photos</h2>

                <div class="col-md-12 img-upload mb-4">
                  <div id="image_preview">
                    @if(isset($data['camp_photo']))
                      @foreach ($data['camp_photo'] as $photo)
                        
                        
                          <img class="pic" src="{{$BASE_URL}}/{{$photo['path']}}" alt="{{$photo['name']}}">
                        
                      @endforeach
                    @endif
                  </div>
                  <input type="hidden" class="form-control" id="imagePath" name="image_path">
                    
                  <div id="aaa">
                    
                    <input accept="image/*" name="camp_image_path[]" type='file' id="imgInp" onchange="preview_image();" multiple />
                    <i class="far fa-file-image"></i>
                    <i class="bi bi-plus-circle"></i>
                  </div>
                </div>
                <h2>Contacts</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Phone <span class="input-required">*</span></label>
                    <input type="text" class="form-control cont" id="contacts" name="contacts" value="{{!empty($data['camp']) ? old('contacts', $data['camp']->contacts) : old('contacts')}}"  aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">WhatsApp <span class="input-required">*</span></label>
                    <input type="text" class="form-control cont" id="whatsapp" name="whatsapp" value="{{!empty($data['camp']) ? old('whatsapp', $data['camp']->whatsapp) : old('whatsapp')}}"  aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dates">Email <span class="input-required">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" value="{{!empty($data['camp']) ? old('email', $data['camp']->email) : old('email')}}"  required aria-describedby="emailHelp" >
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                  <label for="about">About camp</label>
                    <textarea class="form-control" id="about" name ="about">{{!empty($data['camp']) ? old('about', $data['camp']->about) : old('about')}}</textarea>
                  </div>
                  <label>Coaches</label>
                  <div class="col-md-10 coachimg" id="coachimg-wrapper">
                    <!-- <div class="row coach1" id ="coachimg">
                      <div class="col-md-4">
                        <div class="img-upload mb-4 output">
                          <img id="output" src="https://via.placeholder.com/150x150" alt=""> 
                         
                        </div>
                      </div>
                      <div class="col-md-7 pt-10">
                        <select data-placeholder="Choose a Coach..." id="coach_chosen" class="chosen-select" style="width:350px;" tabindex="4">
                          <option value=""></option>
                        </select>  
                        <p>Link to an existing coach account</p>
                      </div>

                      <button class="remove form-control btn btn-primary submit px-3">x</button>
                      
                    </div> -->
                    <div class="row">
                    <div class="col-md-4 mb-4 p-left-0">
                      <a href="javascript:void(0);" id="addMore" class="form-control btn btn-primary submit px-3 btn-save">
                        <i class="fas fa-plus"></i>
                      </a>
                    </div>
                  </div>
                    <div class="row coach1" id ="coachimg_input" style="display: none;">
                      <div class="col-md-8 mt-4">
                        <div class="form-group">
                          <input id="coach_select" type="text" class="form-control" >
                        </div>
                      </div>
                      <div class="col-md-4 mt-4">
                        <div class="btn-group">
                          <a id="save_coach" class="form-control btn btn-primary submit px-3 btn-save">Save</a>
                        </div>
                      </div>
                    </div>

                    <div class="row coach1" id ="coachimg2">
                      <div class="col-md-4">
                        <div class="img-upload mb-4 output">
                          
                        </div>
                      </div>
                      <div class="col-md-6 pt-10 outputName">
                        
                      </div>

                      <button class="remove form-control btn btn-primary submit px-3">x</button>
                      
                    </div>
                    @if(isset($data['coaches']))
                      @foreach ($data['coaches'] as $coach)
                          <div class="row coach1" id ="coachimg">
                            <div class="col-md-4">
                              <div class="img-upload mb-4 output">
                                <img id="output" src="{{$BASE_URL}}/photo/user_photo/{{$coach['avatar_image_path']}}" />
                                
                                
                              </div>
                            </div>
                            <div class="col-md-7 pt-10 input_area">
                              <input type="text" disabled class="form-control" id="coach" value="{{!empty($coach) ? $coach['name'] : ''}}" aria-describedby="emailHelp" >
                              <a href="{{!empty($coach['id']) ? route('coach-details', ['user' => $coach['id']]): ''}}"> <p>Link to an existing coach account</p></a>
                            </div>
                            <input type="hidden" name="coaches[]" value="{{$coach['id']}}">

                            <button class="remove form-control btn btn-primary submit px-3">x</button>
                            
                          </div>
                      @endforeach
                    @endif
                   
                    @if(isset($data['coaches_datas_new']))
                      @foreach ($data['coaches_datas_new'] as $coach)
                          <div class="row coach1" id ="coachimg">
                            <div class="col-md-4">
                              <div class="img-upload mb-4 output">
                                <img id="output" src="{{$BASE_URL}}/{{$coach['avatar_image_path']}}" />
                                
                                
                              </div>
                            </div>
                            <div class="col-md-7 pt-10 input_area">
                              <input type="text" class="form-control" disabled name="coach_name1[]" id="coach" value="{{!empty($coach) ? $coach['name'] : ''}}" aria-describedby="emailHelp" >
                              
                              <input type="hidden" class="form-control" name="coach_name[]" id="coach" value="{{!empty($coach) ? $coach['name'] : ''}}" aria-describedby="emailHelp" >
                              
                            </div>
                            
                            
                            <button class="remove form-control btn btn-primary submit px-3">x</button>
                            
                          </div>
                      @endforeach
                    @endif

                  </div>


                </div>
                <div class="offset-md-8 col-md-4 mb-4 save_area">
                  <div class="btn-group">
                    <button type="submit" id="cancel" class="form-control btn btn-primary submit px-3">Cancel</button>
                    <button type="submit" id="save" class="form-control btn btn-primary submit px-3 btn-save">Save</button>
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
        var inputs = $(".cont");
        let empty = 1;

        for(var i = 0; i < inputs.length; i++){
          
            if ($(inputs[i]).val() != '') {
              $(inputs[i]).removeAttr('required');
              empty = 0;
            }
            else{
              $(inputs[i]).attr('required', '');
              //$(this).setAttribute("required", "");         //Correct
              //return false
            }
        };
        var whatsapp = $('#whatsapp').val();

        $('#whatsapp,#contacts').keyup(function() { 
            if ($('#whatsapp').val() != '') {
              var inputs = $(".cont");
              for(var i = 0; i < inputs.length; i++){
                $(inputs[i]).removeAttr('required');
              };
            }
            if ($('#contacts').val() != '') {
              var inputs = $(".cont");
              for(var i = 0; i < inputs.length; i++){
                $(inputs[i]).removeAttr('required');
              };
            }
        });
        $(document).on("click", "#save", function () {
          var inputs = $(".cont");
          let empty = 1;
          

          for(var i = 0; i < inputs.length; i++){
              if ($(inputs[i]).val() != '') {
                $(inputs[i]).removeAttr('required');
                empty = 0;
                break;
              }
              else{
                $(inputs[i]).attr('required', '');
                //$(this).setAttribute("required", "");         //Correct
                //return false
              }
          };
          for(var i = 0; i < inputs.length; i++){
              if (empty == 0) {
                $(inputs[i]).removeAttr('required');
                
              } else {
                 $(inputs[i]).attr('required', '');
              }
          };
          //return false;
        });
        

        $("#coachimg2").hide();
        var projects =  <?php echo json_encode($coaches) ?>;
        console.log(projects);
        // var projects = [
        // {
        //   id:1,
        //   value: "jquery",
        //   label: "jQuery",
        //   desc: "the write less, do more, JavaScript library",
        //   icon: "jquery_32x32.png"
        // },
        // {
        //     id:2,
        //   value: "jquery-ui",
        //   label: "jQuery UI",
        //   desc: "the official user interface library for jQuery",
        //   icon: "jqueryui_32x32.png"
        // },
        // {
        //     id:3,
        //   value: "sizzlejs",
        //   label: "Sizzle JS",
        //   desc: "a pure-JavaScript CSS selector engine",
        //   icon: "sizzlejs_32x32.png"
        // }
        // ];
        

        $(document).on("click", "#addMore", function () {
            $("#coachimg_input").show();
        });

        $(document).on("change", "#imgInp", function () {
          //var total_file=document.getElementById("imgInp").files.length;
          // $("#image_preview1").empty();//you can remove this code if you want previous user input
          // imagesPreview(this, '#image_preview1');
          console.log('sss');
          
        });
        $(document).on("change", "#imgInpNew", function () {
          //var total_file=document.getElementById("imgInp").files.length;
          $(this).parent().siblings('#image_preview').empty();//you can remove this code if you want previous user input
          imagesPreview(this, $(this).parent().siblings('#image_preview'));
          if($(window).width()<500){
            $(this).siblings('.bi-plus-circle').css({
              top : '4px',
              left : '-11px',
            })
          }else{
            $(this).siblings('.bi-plus-circle').css({
              top : '-17px',
              left : '27px',
            })
          }


          
        });

        $(document).on("click", "#save_coach", function () {
            var value = $( "#coach_select" ).val();

            // $("#btn1").click(function() {
            //   $('<input type="file" name="pic" accept="image/*" />b<br>').insertBefore(this);
            // });
            var src ="<div id='image_preview'>";
                src+= "</div>"
                src+= "<input type='hidden' class='form-control' id='imagePath' name='image_path'>"    
                src+= "<div class='newImg'>"    
                src+="<input accept='image/*' name='coach_image[]' type='file' id='imgInpNew'/>";
                src+="<i class='far fa-file-image'></i>";
                src+="<i class='bi bi-plus-circle'></i>";
                src+="</div>";
            var val ="<input type='text' class='form-control' id='coach' name='coach_name_added[]' value='"+ value +"' aria-describedby='emailHelp' >";
            

            var newSelect='<div class="row coach1" id ="coachimg"><div class="col-md-5"><div class="img-upload mb-4 output">'+src+'</div></div><div class="col-md-6 pt-10 outputName pb-5 wid-80">'+val+'</div><button class="remove form-control btn btn-primary submit px-3">x</button></div>';

            $("#coachimg-wrapper").append(newSelect);
            $("#coach_select" ).val('');
        });
             
             
        $( "#coach_select" ).autocomplete({
          minLength: 0,
          source: projects,
          focus: function( event, ui ) {
            $( "#coach_select" ).val( ui.item.name );
            return false;
          },
          select: function( event, ui ) {
            if (ui.item) {
              $( "#coach_select" ).val( ui.item.name );
              
              //var src = "<input type='hidden' name='coaches[]' value='"+ui.item.id+"'>";
              //var newSelect = $("#coachimg");
              var newSelect = $("#coachimg2").clone();
              //newSelect.find('.output').html(src);



              var src ="<img id='output' src='"+baseUrl+"/photo/user_photo/"+ ui.item.avatar_image_path +"' />";
              src+="<input type='hidden' name='coaches[]' value='"+ui.item.id+"'>";
              newSelect.find('.output').html(src);


              var val ="<input type='text' disabled class='form-control' id='coach' value='"+ ui.item.name +"' aria-describedby='emailHelp' >";
              val+="<a href='"+baseUrl+"/coach/details/'"+ui.item.id+"'><p>Link to an existing coach account</p></a>";
              newSelect.find('.outputName').html(val);
              //document.getElementById("output").src = src;
              $("#coachimg-wrapper").append(newSelect);
              newSelect.show();
              
            }
            console.log(ui.item);
            //newSelect.show();
            // $( "#project-id" ).val( ui.item.id );
            // //$( "#project-label" ).val( ui.item.label );
            // $( "#project-description" ).val( ui.item.desc );
            // $( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
            return false;
          }
        })

        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
          return $( "<li>" )
          .append( "<a id='"+item.id+"'>" + item.name + "</a>" )
          .appendTo( ul );
        };



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
      //$("#imgInp").on('change',function(){
      $(document).on("click", ".newImg i", function (event) {

        $(this).prev('input').trigger('click');
        
      });
      $(document).on("click", ".coach_img", function () {
        
        
        //var total_file=document.getElementById("imgInp").files.length;
        //$("#image_preview").empty();//you can remove this code if you want previous user input
        //imagesPreview(this, '#image_preview');
        
      });

      

      let files = [];
        // Multiple images preview in browser
      var imagesPreview = function(input, placeToInsertImagePreview) {
          if (input.files) {
              var filesAmount = input.files.length;

              for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.onload = function(event) {
                      $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                  }

                  reader.readAsDataURL(input.files[i]);
                  files.push(input.files[i]);
                  //files = [];
              }
          }
          console.log(files);

          // files.forEach(file => {
          //    here I just put file as file[] so now in submitting it will send all 
          //   files 
          //   $('#image_preview').append('file[]', file);
          // });
          $("#imagePath").val(files);
          files = [];
      };

      function file_name(){
        $('.upClick span').html(event.target.files[0].name);
      }
      
    </script>
    <style type="text/css">
      .newImg{
        margin-top: 44px;
      }
      #coachimg_input{
        margin-bottom: 20px;
      }

    </style>
@endsection
  