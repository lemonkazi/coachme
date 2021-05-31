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
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/front.css') }}">
        <title>@yield('title')</title>
        <!-- external JS-->
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <meta name="_token" content="{{ csrf_token() }}">
        <script type="text/javascript">
          var baseUrl = '{{ $BASE_URL }}';
          

          var CURRENT_URL = '{{ $CURRENT_URL }}';


          var controller = '{{ $controller }}';
          var action = '{{ $action }}';

          var HTTP_HOST = '{{ $_SERVER['HTTP_HOST'] }}';
          var MESSAGE_CONFIRM_DELETE = '{{ __('MESSAGE_CONFIRM_DELETE') }}';
          console.log(MESSAGE_CONFIRM_DELETE);
        </script>
    </head>
    <body>
        <!-- Header section -->
        <section class="hero-section ">
            <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><img class="img-fluid" src="{{ asset('img/logo.png') }}" alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link" href="#">About us</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="#">Coaches</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Camps</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Programs</a>
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
        <section>
            @yield('content')
        </section>
        <!-- footer section -->

        <footer class="footer-part">
            <div class="container py-5">
                <div class="row pt-5 mt-5">
                <div class="col-md-3">
                    <ul>

                    <li>About</li>
                    <li>Term of use</li>
                    <li>Sign-up as a coach</li>
                    <li>Sign-as a rink</li>
                    </ul>
                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-3">
                    <img src="{{ asset('img/logo.png') }}" alt="">
                    <span></span>
                    <div class="image-part">

                    <ul>


                        <li><img src="{{ asset('img/Group 86.png') }}" alt=""></li>
                        <li><img src="{{ asset('img/Group 87.png') }}" alt=""></li>
                        <li><img src="{{ asset('img/Group 88.png') }}" alt=""></li>
                        <li><img src="{{ asset('img/Group 782.png') }}" alt=""></li>

                    </ul>
                    </div>
                </div>
                </div>

            </div>
        </footer>
        <div id="pageloader">
            <img src="{{ asset ('img/loading.gif') }}" alt="processing..." />
        </div>

        <!-- Optional JavaScript -->
        <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/104c8dfbc6.js" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="{{ asset ('plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset ('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js"></script>
        <script>
          $.widget.bridge('uibutton', $.ui.button)
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                
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
                            }
                                

                          }
                        },
                        complete: function() {
                            loader.hide();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
