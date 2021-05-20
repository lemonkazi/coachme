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
        <a href="#" class="d-block">Abiduzzaman Abid</a>
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
        <!-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Products
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('/all-categories')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Products</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/create_product')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Products</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Category
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('/categories')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/add_categories')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Categories</p>
              </a>
            </li>
          </ul>
        </li> -->
        <li class="nav-item <?php if ($controller == 'coachcontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'coachcontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Coach
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'coachcontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('coaches')}}" class="nav-link <?php if ($controller == 'coachcontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Coach</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'coachcontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/coach/add')}}" class="nav-link <?php if ($controller == 'coachcontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Coach</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php if ($controller == 'rinkcontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'rinkcontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Rinks
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'rinkcontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('rinks')}}" class="nav-link <?php if ($controller == 'rinkcontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Rinks</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'rinkcontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/rink/add')}}" class="nav-link <?php if ($controller == 'rinkcontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Rink</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if ($controller == 'specialitycontroller') echo 'active menu-open' ?>"">
          <a href="#" class="nav-link <?php if ($controller == 'specialitycontroller') echo 'active' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Speciality
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php if ($controller == 'specialitycontroller' && $action == 'show') echo 'active' ?>">
              <a href="{{ url('speciality')}}" class="nav-link <?php if ($controller == 'specialitycontroller' && $action == 'show') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Speciality</p>
              </a>
            </li>
            <li class="nav-item <?php if ($controller == 'specialitycontroller' && $action == 'create') echo 'active' ?>">
              <a href="{{ url('/special/add')}}" class="nav-link <?php if ($controller == 'specialitycontroller' && $action == 'create') echo 'active' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Speciality</p>
              </a>
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
        <!-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Customer List
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Order List
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Coupons
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Warehouse
            </p>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Settings
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>