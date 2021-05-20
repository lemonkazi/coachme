<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COACH ME</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset ('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}"> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset ('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset ('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset ('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset ('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset ('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- ========================================================= -->
    <!--Notification msj-->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
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
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" title="Logout" href="{{ url('/logout') }}">
              <i class="fas fa-sign-out-alt"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->
      <!-- LEFT SIDEBAR Start -->
      <!-- ========================================================= -->
      @include('layouts.sidebar')
      <!-- LEFT SIDEBAR End -->
      <!-- CONTENT -->
      <!-- ========================================================= -->
      <!-- Main start -->
        @yield('content')
      <!-- Main End -->
      


      <!-- footer -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2021.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 1.0
        </div>
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('layouts.elements.modal_alert')

    <!-- jQuery -->
    <script src="{{ asset ('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset ('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset ('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset ('plugins/sparklines/sparkline.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset ('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset ('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset ('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset ('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset ('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset ('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset ('dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset ('dist/js/pages/dashboard.js') }}"></script>
    <!--Notification msj-->
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript">

      $(document).ready(function () {
        $('.btn_delete').on('click', function(event){
          event.preventDefault();

          var tr = $(this).closest('tr');
          var id = $(this).attr('data-id') ? $(this).attr('data-id') : '';
          var csrfToken = $('meta[name="_token"]').attr('content') ? $('meta[name="_token"]').attr('content') : '';
          var data_controller = controller;

          if (confirm(MESSAGE_CONFIRM_DELETE)) {

              var data = {
                  controller: data_controller,
                  action: 'delete',
                  id: id,
                  delete: 1,
                  _token:csrfToken
              };
              // console.log(data);
              // return false;
              $.ajax({
                  type: 'POST',
                  url: baseUrl + '/ajax_delete',
                  data: data,
                  dataType: 'json',
                  success: function (response) {
                    if (response.status == 0) {
                        // Show error
                        showAlertModal(response.message);
                    }else {
                        tr.remove();
                    }
                  },
                  complete: function () {}
              });
          }
        });
      });

      /**
       * Show alert using bootstrap modal
       * @param {string} message
       */
      function showAlertModal(message) {
          $('#modal_alert_body').html(message);
          $('#modal_alert').modal('show');
      }
    </script>
    {!! Toastr::message() !!}
  </body>
</html>
