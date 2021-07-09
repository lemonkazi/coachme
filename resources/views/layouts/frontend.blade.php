<!doctype html>

<html lang='en'>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;700&display=swap" rel="stylesheet">   
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/front.css') }}">
        <title>@yield('title')</title>
        <!-- external JS-->
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">

        <meta name="_token" content="{{ csrf_token() }}">
        <script type="text/javascript">
          var baseUrl = '{{ $BASE_URL }}';
          

          var CURRENT_URL = '{{ $CURRENT_URL }}';


          var controller = '{{ $controller }}';
          var action = '{{ $action }}';

          var HTTP_HOST = '{{ $_SERVER['HTTP_HOST'] }}';
          var MESSAGE_CONFIRM_DELETE = '{{ __('MESSAGE_CONFIRM_DELETE') }}';
          //console.log(MESSAGE_CONFIRM_DELETE);
        </script>
    </head>
    <body>
        <!-- Header section -->
        <section class="hero-section ">
            <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                      <img class="img-fluid pc" src="{{ asset('img/logo.png') }}" alt="">
                      <img class="img-fluid sp logo-sp" src="{{ asset('img/logo_sp.png') }}" alt="">
                    </a>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                      <img src="{{ asset('img/nav-icon.png') }}" alt="">
                      <i class="bi bi-x "></i>
                    </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
                        <a class="nav-link" href="#">About us</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link <?php if ($controller == 'publiccontoller' && in_array($action, array('coach_details', 'coach_list'))) echo 'active' ?>" href="{{ url('/coach/list') }}">Coaches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($controller == 'publiccontoller' && in_array($action, array('camp_details', 'camp_list','camp_filter'))) echo 'active' ?>" href="{{ url('/camp/list') }}">Camps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($controller == 'publiccontoller' && in_array($action, array('program_details', 'program_list'))) echo 'active' ?>" href="{{ url('/program/list') }}">Programs</a>
                        </li>
                        <li>
                            @if (Route::has('logout'))
                                @auth
                                    <a href="{{ url('/logout') }}" class="btn btn-custom">Logout</a>
                                @else
                                   <a href="" class="btn btn-custom"  data-toggle="modal" data-target="#exampleModalCenter">Log in</a>
                                @endauth
                            @endif
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>
            </div>
            </div>
        </section>
        <section class="contents">
            @yield('content')
        </section>
        <!-- footer section -->

        <footer class="footer-part">
            <div class="container py-5">
                <div class="row pt-5 ">
                <div class="col-md-3 wid-40">
                    <ul>

                    <li>About</li>
                    <li>Term of use</li>
                    <li>
                        @if (Route::has('logout'))
                                @auth
                                    <a href="{{ url('/logout') }}" class="btn btn-custom">Logout</a>
                                @else
                                   <a href="" class="btn btn-custom"  data-toggle="modal" data-target="#exampleModalCenter">Sign-up as a coach</a>
                                @endauth
                            @endif
                    </li>
                    </ul>
                </div>
                <div class="offset-md-6 col-md-3 wid-60">
                    <img src="{{ asset('img/footer_logo.png') }}" alt="">
                    <span></span>
                    <div class="image-part">

                    <ul>
                        <li>
                          <a href="https://web.whatsapp.com/" target="_blank">
                            <img src="{{ asset('img/Group 86.png') }}" alt="">
                          </a>
                        <li>
                          <a href="https://www.instagram.com/" target="_blank">
                            <img src="{{ asset('img/Group 87.png') }}" alt="">
                          </a>
                        </li>
                        <li> 
                          <a href="https://twitter.com/home" target="_blank">
                            <img src="{{ asset('img/Group 88.png') }}" alt="">
                          </a>
                        </li>
                        <li>
                          <a href="https://www.facebook.com/" target="_blank">
                            <img src="{{ asset('img/Group 782.png') }}" alt="">
                          </a>
                        </li>

                    </ul>
                    </div>
                </div>
                </div>

            </div>
        </footer>
        <div id="pageloader">
            <img src="{{ asset ('img/loading.gif') }}" alt="processing..." />
        </div>

        <!-- MOdal Start-->
        <section class="modal-section">
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content registration-modal">
                <div class="modal-body p-4 p-md-5 ">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h3 class="text-center mb-2">Log in</h3>
                  <h5 class="mb-3">Welcome back to Coach me solutions!</h5>
                  <div class="alert alert-danger login" style="display:none"></div>
                  <form method="POST" action="{{ url('user/login') }}" class="login-form">
                    @csrf
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
                    <div class="form-group">
                      <label for="log-email">Email</label>
                      <input id="email" type="email" class="form-control rounded-left @error('email') is-invalid @enderror" placeholder="email" id="log-email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="log-password">Password</label>
                      <div class="icon-input mb-3">
                        <input id="password" type="password" class="form-control rounded-left @error('password') is-invalid @enderror" placeholder="Password" id="log-password" name="password" required autocomplete="password">
                        <i class="bi bi-eye-slash-fill"></i>
                        @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                      
                    <div class="form-group">
                      <button type="submit" id="userLogin" class="form-control btn btn-primary submit px-3">Login</button>
                    </div>
                  </form>
                  <h1 class="a">or</h1>
                  <h3 class="text-center mb-2 signUp">Sign up</h3>
                  <h5 class="mb-3 signUp">Sign up to join Coach me solutions!</h5>
                  <div class="alert alert-danger registration" style="display:none"></div>
                  <div class="alert alert-success registration" style="display:none"></div>
                  <form method="POST" action="{{ url('user/register') }}" class="registration-form signUp">
                    @csrf
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
                    <div class="form-group">
                      <label for="sign-email">Email</label>
                      <input type="text" class="form-control rounded-left @error('email') is-invalid @enderror" name="email" placeholder="email" id="sign-email" value="{{ old('email') }}" required autocomplete="email">
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="userSelect">Type of user</label>
                      @if (isset($authority))
                      <select class="form-control" name="authority" id="userSelect">
                        <option value="">Select</option>
                        @foreach($authority as $id => $value)
                            <option value="{{ $id }}" {{ (old('authority') ? old('authority') : $data['user']->authority ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="reg-password">Password</label>
                      <div class="icon-input mb-3">
                        <input type="password" class="form-control rounded-left @error('password') is-invalid @enderror" placeholder="at least 8 symbols" name="password" id="reg-password" required autocomplete="new-password">
                        <i class="bi bi-eye-slash-fill"></i>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="form-control btn btn-primary submit px-3" id="userRegister">Sign Up</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
        @include('layouts.elements.modal_alert')
        <!-- /modal-->
        <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/104c8dfbc6.js" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="{{ asset ('plugins/jquery/jquery.min.js') }}"></script>
        
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
        
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset ('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/moment/main.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/interaction/main.min.js"></script>
        <!-- Optional JavaScript -->

        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.btn_delete_camp').on('click', function(event){
                  event.preventDefault();

                  var tr = $(this).closest('.card');
                  var id = $(this).attr('data-id') ? $(this).attr('data-id') : '';
                  var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
                  var data_controller = 'campcontroller';

                  if (confirm('Do You want to delete?')) {

                      var data = {
                          controller: data_controller,
                          action: 'delete',
                          id: id,
                          delete: 1,
                          _token:csrfToken
                      };
                      //showAlertModal('sdasdasd');
                      //alert('camp deleted.')
                      // console.log(data);
                      //return false;
                      $.ajax({
                          type: 'POST',
                          url: baseUrl + '/ajax_delete',
                          data: data,
                          dataType: 'json',
                          success: function (response) {
                            if (response.status == 0) {
                                // Show error
                                alert(response.message)
                               // showAlertModal(response.message);
                            }else {
                                tr.remove();
                                 alert('camp deleted.')
                            }
                          },
                          complete: function () {}
                      });
                  }
                });
                $('.btn_delete_program').on('click', function(event){
                  event.preventDefault();

                  var tr = $(this).closest('.card');
                  var id = $(this).attr('data-id') ? $(this).attr('data-id') : '';
                  var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
                  var data_controller = 'programcontroller';

                  if (confirm('Do You want to delete?')) {

                      var data = {
                          controller: data_controller,
                          action: 'delete',
                          id: id,
                          delete: 1,
                          _token:csrfToken
                      };
                      //showAlertModal('sdasdasd');
                      //alert('camp deleted.')
                      // console.log(data);
                      //return false;
                      $.ajax({
                          type: 'POST',
                          url: baseUrl + '/ajax_delete',
                          data: data,
                          dataType: 'json',
                          success: function (response) {
                            if (response.status == 0) {
                                // Show error
                                alert(response.message)
                               // showAlertModal(response.message);
                            }else {
                                tr.remove();
                                 alert('Program deleted.')
                            }
                          },
                          complete: function () {}
                      });
                  }
                });
                /**
                 * Show alert using bootstrap modal
                 * @param {string} message
                 */
                function showAlertModal(message) {
                    $('#modal_alert_body').html(message);
                    $('#modal_alert').modal('show');
                }

                $('#userLogin').click(function(e){
                    e.preventDefault();
                    var loader = $('#pageloader');
                    var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
                    var data_controller = controller;
                    var data = {
                        controller: data_controller,
                        email: $('#email').val(),
                        password: $('#password').val(),
                        //_token: "{{ csrf_token() }}",
                        _token:csrfToken
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: baseUrl + '/user/login',
                        data: data,
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            loader.show();
                        },
                        success: function (result) {
                          if(result.errors)
                          {
                              $('.alert-danger.login').html('');

                              $.each(result.errors, function(key, value){
                                  $('.alert-danger.login').show();
                                  $('.alert-danger.login').append('<li>'+value+'</li>');
                              });
                          }
                          else
                          {
                            $('.alert-danger.login').hide();
                            $('#exampleModalCenter').removeClass('show');
                            if(result.success)
                            {
                               //$('#token').val(response.token);
                               window.location = result.url;  
                            }
                                

                          }
                        },
                        complete: function() {
                            loader.hide();
                        }
                    });
                });

                $('#userRegister').click(function(e){
                    e.preventDefault();
                    // $('.signUp').hide();
                    // return false;
                    var loader = $('#pageloader');
                    var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
                    var data_controller = controller;
                    var data = {
                        controller: data_controller,
                        email: $('#sign-email').val(),
                        password: $('#reg-password').val(),
                        authority: $('#userSelect').val(),
                        _token:csrfToken
                       // _token: "{{ csrf_token() }}",
                    };
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + '/user/register',
                        data: data,
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            loader.show();
                        },
                        success: function (result) {
                          if(result.errors)
                          {
                              $('.alert-danger.registration').html('');

                              $.each(result.errors, function(key, value){
                                  $('.alert-danger.registration').show();
                                  $('.alert-danger.registration').append('<li>'+value+'</li>');
                              });
                          }
                          else
                          {

                            $('.alert-danger.registration').hide();
                            //$('#exampleModalCenter').removeClass('show');
                            if(result.success)
                            {
                                $('.alert-success.registration').html('');
                                $('.alert-success.registration').show();
                                $('.alert-success.registration').append('<li>'+result.result+'</li>');
                                //window.location = result.url;  
                                $('.signUp').hide();
                                //return false;
                            }
                                

                          }
                        },
                        complete: function() {
                            loader.hide();
                        }
                    });
                });
                if (!$("#exampleModalCenter").is(':visible')) {
                    // if modal is not shown/visible then do something
                    $('.signUp').show();
                }
                $(document).on('hide.bs.modal','#exampleModalCenter', function () {
                    alert('sasa');
                    //Do stuff here
                });
                window.onclick = function(event) {
                   if (event.target.id != "exampleModalCenter") {
                      $('.signUp').show();
                   }
                }
                // $("#exampleModalCenter").on("hidden.bs.modal", function () {
                    
                // });
                $('.navbar-toggler').on('click',function (e) {
                  e.preventDefault();

                  if($('.navbar-toggler').hasClass('collapsed')){
                    $('.navbar-collapse').addClass('show');
                    $(this).attr('aria-expanded',true);
                    $('.navbar-toggler').removeClass('collapsed');
                    $('.navbar-toggler-icon img').addClass('d-none');
                    $('.navbar-toggler-icon i').show();
                    $('.hero-section').css('background-color','#8ac8dc');
                  }else{
                    $('.navbar-collapse').removeClass('show');
                    $(this).attr('aria-expanded',false);
                    $('.navbar-toggler').addClass('collapsed');
                    $('.navbar-toggler-icon img').removeClass('d-none');
                    $('.navbar-toggler-icon i').hide();
                    $('.hero-section').css('background-color','#F3F6FB');
                  }
                })
            });

            ;(function($){
                $('#coach_chosen').chosen({width: '100%'});
                $('.chosen-search input').autocomplete({
                    minLength: 3,
                    source: function( request, response ) {

                        //var items="";
                        //items+="<option value='aaaa'>aaaa</option>";
                        console.log('sss');
                        $.ajax({
                            url: baseUrl + '/filter_coach',
                            data: {param:request.term},
                            dataType: "json",
                            beforeSend: function(){ $('ul.chosen-results').empty(); $("#coach_chosen").empty(); }
                        }).done(function( data ) {
                            $('#coach_chosen').append('<option value=""></option>');
                                response( $.map( data, function( item, index ) {
                                    //console.log(item);
                                    $('#coach_chosen').append('<option data-src="'+item.avatar_image_path+'" value="' + item.id + '">' + item.name + '</option>');
                                }));


                               $("#coach_chosen").trigger("chosen:updated");
                               //$("#coach_chosen").chosen();
                        });
                    }
                });

                $(document).on("change", "#coach_chosen", function () {
                    console.log($(this).find('option').filter(':selected').attr('data-src'));

                    var newSelect = $("#coachimg").clone();
                    var src = $(this).find('option').filter(':selected').attr('data-src');
                    var selectedValue = $(this).find('option').filter(':selected').attr('value');
                    var src ="<img id='output' src='"+baseUrl+"/photo/user_photo/"+src+"' />";
                    src+="<input type='hidden' name='coaches[]' value='"+selectedValue+"'/>";
                    newSelect.find('.output').html(src);
                    //document.getElementById("output").src = src;
                    $("#coachimg-wrapper").append(newSelect);
                    $('#coach_chosen').val("");
                    $('#coach_chosen').chosen({width: '100%'});
                    $("#coach_chosen").trigger("chosen:updated");

                });
                 $(document).on("click", ".close", function () {
                    $('.signUp').show();
                });
                $(document).on("click", ".remove", function () {
                    //$('#coachimg').on('click', '.remove', function() {
                    $(this).parent().remove();
                    return false; //prevent form submission
                });

                $(document).on("click", ".add_period", function () {
                    var schedule_start_date = $('.schedule_start_date input').val();
                    var schedule_end_date = $('.schedule_end_date input').val();
                    
                    //$('#coachimg').on('click', '.remove', function() {
                    var newSelect = $("#coachimg").clone();
                    var src ="<input type='hidden' name='schedule_start_date[]' value='"+schedule_start_date+"'/>";
                    var src2 ="<input type='hidden' name='schedule_end_date[]' value='"+schedule_end_date+"'/>";
                    
                    newSelect.find('.schedule_start_date').html(src);
                    newSelect.find('.schedule_end_date').html(src2);
                    newSelect.append('<button class="remove form-control btn btn-primary submit px-3" style="margin-top: 1%;">x</button>');
                            
                    $("#coachimg-wrapper").append(newSelect);
                    return false; //prevent form submission
                });
                
            })(jQuery);
        </script>

    </body>
</html>
