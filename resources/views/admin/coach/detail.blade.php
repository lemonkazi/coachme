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
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Information</h3>
            </div>
            <div class="card-body">

              <?php
              $result = array(
                  'id' => array(
                      'label' => __('ID'),
                      'text' => '',
                  ),
                  'email' => array(
                      'label' => __('LABEL_EMAIL_JP'),
                      'text' => '',
                  ),
                  'authority' => array(
                      'label' => __('LABEL_AUTHORITY'),
                      'text' => '',
                  ),
                  'created_at' => array(
                      'label' => __('LABEL_CREATED'),
                      'text' => '',
                  ),
                  'updated_at' => array(
                      'label' => __('LABEL_UPDATED'),
                      'text' => '',
                      //'is_date_format' => 1
                  )
              );
              //print_r($user);
              foreach ($result as $key => $value) {
                if (!isset($user->$key)) {
                    continue;
                }
                if (!empty($user->$key)) {
                    if (!empty($result[$key]['is_date_format'])) {
                        $result[$key]['text'] = date('Y年m月d日', $user->$key);
                    } elseif (!empty($result[$key]['is_array'])) {
                        $result[$key]['text'] = implode (", ", $user->$key);
                    } else {
                        $result[$key]['text'] = $user->$key;
                    }
                } else {
                    $result[$key]['text'] = '-';
                }
              }
              ?> 
              <dl class="row">
                  <?php foreach ($result as $key => $value) : ?> 
                          <dt class="col-sm-3 mx-20"><?php echo $value['label']; ?></dt>
                          <dd class="col-sm-8"><?php echo $value['text']; ?></dd>
                      <?php endforeach; ?> 
              </dl>
            </div>
            <div class="card-footer text-center">
                
                <a class="col-sm-2 btn bg-gradient-primary btn-sm text-center" href="<?php echo $BASE_URL . '/users/update/' . $user->id ?>"><?php echo __('LABEL_UPDATE') ?></a>
            
            </div>
          </div>
        </div>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

</div>
@endsection
