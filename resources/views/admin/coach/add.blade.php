@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Coach Detail;</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Products</li>
          </ol>
        </div><!-- /.col -->
        {{session('msg')}}
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- content HEADER -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo __('LABEL_ADD_NEW')?></h3>
                    </div>
                    <?php
                    //echo $this->SimpleForm->render($updateForm);
                    ?>               
                    
                </div>
            </div>
            <div class="col-md-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">
                asdasdas
              </h3>
            </div>
            <div class="card-body">
              <ul>
                <li><b>User name</b> 1 to 60 character.</li>
                <li><b>email</b> place email here.</li>
                <li><b>Password</b> Half-width alphanumeric characters between 8 and 20 characters.</li>
              </ul>
            </div>
          </div>
        </div>
        </div>
    </div>
  </section>
  <!-- /.content -->

</div>
@endsection