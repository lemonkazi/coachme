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
                    
                  <div class="form-group">
                    <button type="submit" id="userLogin" class="form-control btn btn-primary submit px-3">Login</button>
                  </div>
                </form>
                <h1 class="a">or</h1>
                <h3 class="text-center mb-2">Sign up</h3>
                <h5 class="mb-3">Sign up to join Coach me solutions!</h5>
                <div class="alert alert-danger registration" style="display:none"></div>
                <div class="alert alert-success registration" style="display:none"></div>
                <form method="POST" action="{{ url('user/register') }}" class="registration-form">
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
                    <select class="form-control" name="authority" id="userSelect">
                      <option value="">Select</option>
                      @foreach($authority as $id => $value)
                          <option value="{{ $id }}" {{ (old('authority') ? old('authority') : $data['user']->authority ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
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
      <!-- /modal-->
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
                    <img src="{{ asset('img/top-img.png') }}" alt="">
                </div>
                </div>
            </div>
        </div>
    </section>
    <section class="drop-arrow">
      <i class="fas fa-angle-down"></i>
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
                  <h4 class="card-title mt-0 "><a herf="#">Step 2</a></h4>
                 <img class="card-img" src="{{ asset('img/tutorial.png') }}" alt="">
                </div>
                <div class="card-footer">
                 <div class="media">
           <div class="media-body">
          <h6 class="my-0 d-block">
            Click on the coach, the program or the camp to know more
          </h6>     
        </div>
      </div>
                </div>
              </div>
            </div></div>


            <div class="col-sm-4"><div class="card text-white card-has-bg click-col">        
              <div class="card-img-overlay d-flex flex-column">
               <div class="card-body">
                  <h4 class="card-title mt-0 "><a herf="#">Step 3</a></h4>
                 <img class="card-img" src="{{ asset('img/trust.png') }}" alt="">
                </div>
                <div class="card-footer">
                 <div class="media">
           <div class="media-body">
          <h6 class="my-0 d-block">
            Choose the best way for you to contact them
          </h6>     
        </div>
      </div>
                </div>
              </div>
            </div></div>
        
      </div>
        
      </div>
      </section>
      <section class="drop-arrow">
        <i class="fas fa-angle-down"></i>
      </section>
      <!-- /carosel section -->
      <section class="carousel-section">
        <h1>Here's what famous coaches say
          about Coach Me Solution...</h1>

          <div class="wrap">  
            <div class="slider">
              

              @foreach($testimonials as $testimonial)
                

                <div class="item">
                  <div class="card card_red text-center">
                    <div class="title">

                      <img class="pic" src="{{$BASE_URL}}/testimonial_photo/{{$testimonial->image_path}}" alt="PAT">
                      <h2>{{ $testimonial->name }}</h2>
                    </div>
                    <p>"{!! nl2br(e($testimonial->comment)) !!}"</p>
                  </div>
                </div>
              @endforeach
              
              
              
              
            </div>
          </div>
      </section>
      <section class="drop-arrow">
        <i class="fas fa-angle-down"></i>
      </section>
      <section class="map-section">
        <div class="container">
          <div class="col-md-12 ">
            <div class="card p-3">
              <div class="row">
              <div class="col-md-8">
                <div class="title">
                  <h2>Find Rinks A Rinks Around You</h2>
                  
                  <div class="search-div mb-2">
                    <button type="button" class="btn green-btn">Use my location</button>
                    <input type="text" placeholder="Search" class="search-btn"><i class="bi bi-search"></i>
                  </div>
                </div>
                <div class="polaroid">                 
                    <div id="map"></div>                 
                </div>
              </div>
              <div class="col-md-4">
                <div class="address-group">
                  <div class="address">
                    <div class="number">
                      <img src="{{ asset('img/Ellipse 17.png') }}" alt="" srcset="">
                      <span>1</span>
                    </div>
                    <div class="description">
                      <h5>Kitsilano FSC</h5>
                      <a href="">info@kitsfsc.ca</a>
                      <p>
                        2690 Larch Street Vancouver, BC V6K4K9 604-737-6000
                      </p>
                      <a href="">www.kitsfsc.ca</a>
                      <h6>3,79 kilometers</h6>
                      <p class="gray">Directions</p>
                    </div>
                  </div>
                  <div class="address">
                    <div class="number">
                      <img src="{{ asset('img/Ellipse 17.png') }}" alt="" srcset="">
                      <span>2</span>
                    </div>
                    <div class="description">
                      <h5>Kitsilano FSC</h5>
                      <a href="">info@kitsfsc.ca</a>
                      <p>
                        2690 Larch Street Vancouver, BC V6K4K9 604-737-6000
                      </p>
                      <a href="">www.kitsfsc.ca</a>
                      <h6>3,79 kilometers</h6>
                      <p class="gray">Directions</p>
                    </div>
                  </div>
                  <div class="address">
                    <div class="number">
                      <img src="{{ asset('img/Ellipse 17.png') }}" alt="" srcset="">
                      <span>3</span>
                    </div>
                    <div class="description">
                      <h5>Kitsilano FSC</h5>
                      <a href="">info@kitsfsc.ca</a>
                      <p>
                        2690 Larch Street Vancouver, BC V6K4K9 604-737-6000
                      </p>
                      <a href="">www.kitsfsc.ca</a>
                      <h6>3,79 kilometers</h6>
                      <p class="gray">Directions</p>
                    </div>
                  </div>
                  
                </div>
              </div>
              </div>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAl_3j4BivMuCGpS5DS73Rkt7SNvy29eBQ&callback=initMap" async defer></script>
            </div>
          </div>
        </div>
      </section>

    
      <!-- footer section -->
@endsection
  