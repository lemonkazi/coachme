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
                       
                    </ul>
                    </div>
                </div>
                </nav>
            </div>
            </div>
        </section>
        <section class="contents error_page">
            <h1>Sorry, Page Not Found</h1>
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
        

    </body>
</html>
