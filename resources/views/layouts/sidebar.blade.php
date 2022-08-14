<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="{{ asset ('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">COACH ME</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Ab</a>
      </div>
    </div> -->

    <!-- SidebarSearch Form -->
    

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="{{ url('/home')}}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item <?php if ($controller == 'specialitycontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'specialitycontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Discipline
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'specialitycontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('speciality')}}" class="nav-link <?php if ($controller == 'specialitycontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Discipline</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'specialitycontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/special/add')}}" class="nav-link <?php if ($controller == 'specialitycontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Discipline</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview <?php if (in_array($controller, array('coachcontroller','usercontroller'))) echo ' active menu-open' ?>">
          <a href="#" class="nav-link multi <?php if (in_array($controller, array('coachcontroller','usercontroller'))) echo ' active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="<?php if (in_array($controller, array('coachcontroller','usercontroller'))) { echo 'display: block;'; } else { echo 'display: none;'; }?>">
            <li class="nav-item">
              <br>
            </li>
            <li class="nav-item <?php if ($controller == 'coachcontroller') echo 'active menu-open' ?>">
              <a href="#" class="nav-link multi <?php if ($controller == 'coachcontroller') echo 'active' ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Coach
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="<?php if ($controller == 'coachcontroller') { echo 'display: block;'; } else { echo 'display: none;'; }?>">
                <li class="nav-item <?php if ($controller == 'coachcontroller' && $action == 'show') echo 'active' ?>">
                  <a href="{{ url('coaches')}}" class="nav-link <?php if ($controller == 'coachcontroller' && $action == 'show') echo 'active' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Coach</p>
                  </a>
                </li>
                <!-- <li class="nav-item <?php if ($controller == 'coachcontroller' && $action == 'create') echo 'active' ?>">
                  <a href="{{ url('/coach/add')}}" class="nav-link <?php if ($controller == 'coachcontroller' && $action == 'create') echo 'active' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Coach</p>
                  </a>
                </li> -->
              </ul>
            </li>
            <li class="nav-item">
              <br>
            </li>
          </ul>

        </li>
        
        <li class="nav-item <?php if ($controller == 'experiencecontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'experiencecontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Experiences
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'experiencecontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('experiences')}}" class="nav-link <?php if ($controller == 'experiencecontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Experiences</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'experiencecontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/experience/add')}}" class="nav-link <?php if ($controller == 'experiencecontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Experience</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if ($controller == 'languagecontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'languagecontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Languages
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'languagecontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('languages')}}" class="nav-link <?php if ($controller == 'languagecontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Languages</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'languagecontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/language/add')}}" class="nav-link <?php if ($controller == 'languagecontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Language</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if ($controller == 'provincecontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'provincecontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Provinces
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'provincecontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('provinces')}}" class="nav-link <?php if ($controller == 'provincecontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Provinces</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'provincecontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/province/add')}}" class="nav-link <?php if ($controller == 'provincecontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Province</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-item <?php if ($controller == 'citycontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'citycontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              City
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'citycontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('city')}}" class="nav-link <?php if ($controller == 'citycontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All City</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'citycontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/city_location/add')}}" class="nav-link <?php if ($controller == 'citycontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add City</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if ($controller == 'testimonialcontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'testimonialcontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Testimonials
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'testimonialcontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('testimonials')}}" class="nav-link <?php if ($controller == 'testimonialcontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Testimonials</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'testimonialcontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/testimonial/add')}}" class="nav-link <?php if ($controller == 'testimonialcontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Testimonial</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if ($controller == 'levelcontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'levelcontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Level of coaching
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'levelcontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('levels')}}" class="nav-link <?php if ($controller == 'levelcontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Level of coaching</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'levelcontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/levels/add')}}" class="nav-link <?php if ($controller == 'levelcontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Level of coaching</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php if ($controller == 'agecontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'agecontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Age
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'agecontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('ages')}}" class="nav-link <?php if ($controller == 'agecontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Age</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'agecontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/ages/add')}}" class="nav-link <?php if ($controller == 'agecontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Age</p>
              </a>
            </li>
          </ul>
        </li>
      
       <!--  <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Settings
            </p>
          </a>
        </li> -->
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  [class*=sidebar-dark-] 
.nav-treeview>
.nav-item>
.nav-link.multi.active{
  background-color: #007bff;
  color:white;
}
</style>