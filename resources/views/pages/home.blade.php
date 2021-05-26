@extends('layouts.master')
@section('title','Home')
@section('content')
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
              <div class="alert alert-danger" style="display:none"></div>
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
                  
                <div class="form-group">
                  <button type="submit" id="userLogin" class="form-control btn btn-primary submit px-3">Login</button>
                </div>
              </form>
              <h1 class="a">or</h1>
              <h3 class="text-center mb-2">Sign up</h3>
              <h5 class="mb-3">Sign up to join Coach me solutions!</h5>
              <form action="#" class="registration-form">
                <div class="form-group">
                  <label for="sign-email">Email</label>
                  <input type="text" class="form-control rounded-left" placeholder="email" id="sign-email">
                </div>
                <div class="form-group">
                  <label for="userSelect">Type of user</label>
                  <select class="form-control" id="userSelect">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="reg-password">Password</label>
                  <div class="icon-input mb-3">
                    <input type="password" class="form-control rounded-left" placeholder="at least 8 symbols" id="reg-password">
                    <i class="bi bi-eye-slash-fill"></i>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary submit px-3">Sign Up</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      </section>
      <!-- /modal-->

      <!-- /hero section start -->
    <section class="hero-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="text-content">
                        <h1>Finding <span>a coach, a program or camp</span> has never been that simple.</h1>
                        <p>Coach me solutions is the easiest, safest and most affordable way to connect with an experienced coach who can help you improve your athletic performance and reach your individual goals.</p>

                        <button type="button" class="btn hero-button">Explore  <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="col-md-5">
                <div class="hero-image">
                    <img src="{{ asset('img/Mask Group 21.png') }}" alt="">
                </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /card section -->
    <section class="card-section">
      <div class="content">

      <h1>Steps For Your Great Sports Experience</h1>
      <p>Connecting you to professionally trained coaches, is what we strive to do.</p>
      </div>

      <div class="container">
        <div class="row">
       <div class="col-sm-4"><div class="card text-white card-has-bg click-col">        
              <div class="card-img-overlay d-flex flex-column">
               <div class="card-body">
                  <h4 class="card-title mt-0 "><a herf="#">Step 1</a></h4>
                 <img class="card-img" src="{{ asset('img/purpose.png') }}" alt="">
                </div>
                <div class="card-footer">
                 <div class="media">
           <div class="media-body">
          <h6 class="my-0 d-block">Go on the coach, camp 
            or program tab and look for what you need</h6>     
        </div>
      </div>
                </div>
              </div>
            </div></div>

            <div class="col-sm-4"><div class="card text-white card-has-bg click-col">        
              <div class="card-img-overlay d-flex flex-column">
               <div class="card-body">
                  <h4 class="card-title mt-0 "><a herf="#">Step 1</a></h4>
                 <img class="card-img" src="{{ asset('img/tutorial.png') }}" alt="">
                </div>
                <div class="card-footer">
                 <div class="media">
           <div class="media-body">
          <h6 class="my-0 d-block">Go on the coach, camp 
            or program tab and look for what you need</h6>     
        </div>
      </div>
                </div>
              </div>
            </div></div>


            <div class="col-sm-4"><div class="card text-white card-has-bg click-col">        
              <div class="card-img-overlay d-flex flex-column">
               <div class="card-body">
                  <h4 class="card-title mt-0 "><a herf="#">Step 1</a></h4>
                 <img class="card-img" src="{{ asset('img/trust.png') }}" alt="">
                </div>
                <div class="card-footer">
                 <div class="media">
           <div class="media-body">
          <h6 class="my-0 d-block">Go on the coach, camp 
            or program tab and look for what you need</h6>     
        </div>
      </div>
                </div>
              </div>
            </div></div>
        
      </div>
        
      </div>
      </section>

      <!-- /carosel section -->
      <section class="carousel-section">
        <h1>Here's what famous coaches say
          about Coach Me Solution...</h1>

          <div class="wrap">  
            <div class="slider">
              
              <div class="item">
                <div class="card card_red text-center">
                  <div class="title">
                    <img class="pic" src="{{ asset('img/patrick_chan.png') }}" alt="PAT">
                    <h2>Patrick Chan</h2>
                  </div>
                  <p>"An idea that can really help parents find the right 
                    coach or program for their kids, we all know the hassle 
                    it can be to make the right decisions not knowing the skating world"</p>
                </div>
               </div>
              <div class="item">
                <div class="card card_three text-center">
                  <div class="title">
                    <img class="pic" src="{{ asset('img/patrick_chan.png') }}" alt="PAT">
                    <h2>Patrick Chan</h2>
                  </div>
                  <p>"An idea that can really help parents find the right 
                    coach or program for their kids, we all know the hassle 
                    it can be to make the right decisions not knowing the skating world"</p>
                </div>
              </div>
              <div class="item">
                <div class="card card_three text-center">
                  <div class="title">
                    <img class="pic" src="{{ asset('img/patrick_chan.png') }}" alt="PAT">
                    <h2>Patrick Chan</h2>
                  </div>
                  <p>"An idea that can really help parents find the right 
                    coach or program for their kids, we all know the hassle 
                    it can be to make the right decisions not knowing the skating world"</p>
                </div>
              </div>
              <div class="item">
                <div class="card card_three text-center">
                  <div class="title">
                    <img class="pic" src="{{ asset('img/patrick_chan.png') }}" alt="PAT">
                    <h2>Patrick Chan</h2>
                  </div>
                  <p>"An idea that can really help parents find the right 
                    coach or program for their kids, we all know the hassle 
                    it can be to make the right decisions not knowing the skating world"</p>
                </div>
              </div>
              <div class="item">
                <div class="card card_three text-center">
                  <div class="title">
                    <img class="pic" src="{{ asset('img/patrick_chan.png') }}" alt="PAT">
                    <h2>Patrick Chan</h2>
                  </div>
                  <p>"An idea that can really help parents find the right 
                    coach or program for their kids, we all know the hassle 
                    it can be to make the right decisions not knowing the skating world"</p>
                </div>
              </div>
              
              
              
            </div>
          </div>
      </section>

      <section class="map-section">
        <div class="container">
        <div class="col-6">
          <div class="card card_map text-center">
            <div class="title">
              <h2>Find Rinks A Rinks Around You</h2>
            </div>
            <p>"An idea that can really help parents find the right 
              coach or program for their kids, we all know the hassle 
              it can be to make the right decisions not knowing the skating world"</p>
              
              
              <div class="polaroid">
                <div class="container">
                  <div id="map"></div>
                </div>
              </div>
              <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAl_3j4BivMuCGpS5DS73Rkt7SNvy29eBQ&callback=initMap" async defer></script>
          </div>
        </div>
        </div>
      </section>

    
      <!-- footer section -->
@endsection
  