@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{$data['Title']}}</h1>
        </div><!-- /.col -->
        @php
          echo htmlspecialchars_decode(render2($data['breadcrumb']))
        @endphp
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
                  'name' => array(
                      'label' => __('Name'),
                      'text' => '',
                  ),
                  'created_at' => array(
                      'label' => trans('global.LABEL_CREATED'),
                      'text' => '',
                  ),
                  'updated_at' => array(
                      'label' => trans('global.LABEL_UPDATED'),
                      'text' => '',
                      //'is_date_format' => 1
                  )
              );
              //print_r($rink);
              foreach ($result as $key => $value) {
                if (!isset($data['rink']->$key)) {
                    continue;
                }
                if (!empty($data['rink']->$key)) {
                    if (!empty($result[$key]['is_date_format'])) {
                        $result[$key]['text'] = date('Y年m月d日', $data['rink']->$key);
                    } elseif (!empty($result[$key]['is_array'])) {
                        $result[$key]['text'] = implode (", ", $data['rink']->$key);
                    } elseif (!empty($result[$key]['related'])) {
                      $related = (string)$result[$key]['related'];
                      $result[$key]['text'] = $data['rink']->$related->name;
                    } elseif ($key == "avatar_image_path") {
                      $result[$key]['text'] = "<img style='max-width:80px;' src='{$BASE_URL}/rink_photo/{$data['rink']->$key}' />";
                    } else {
                        $result[$key]['text'] = $data['rink']->$key;
                    }
                } else {
                    $result[$key]['text'] = '-';
                }
              }
              ?> 
              <dl class="row">
                  <?php foreach ($result as $key => $value) : ?> 
                          <dt class="col-sm-3 mx-20"><?php echo $value['label']; ?></dt>:
                          <dd class="col-sm-8"><?php echo $value['text']; ?></dd>
                      <?php endforeach; ?> 
              </dl>
            </div>
            <div class="card-footer text-center">
                
                <a class="col-sm-2 btn bg-gradient-primary btn-sm text-center" href="<?php echo $BASE_URL . '/rink/edit/' . $data['rink']->id ?>"><?php echo trans('global.LABEL_UPDATE') ?></a>
            
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
