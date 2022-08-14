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
            <!-- // code in resources/views/view.blade.php -->
           <!--  @php
             echo "<pre>";
               print_r(count($data['breadcrumb']));
             echo "</pre>";
            @endphp -->
          </div>
            @php
            echo htmlspecialchars_decode(render2($data['breadcrumb']))
            @endphp
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <form method="get" enctype="multipart/form-data" accept-charset="utf-8" role="form" novalidate="novalidate" autocomplete="off" class="form-table1" action="{{ $CURRENT_URL }}">
                
              <div class="card card-primary card-outline collapsed-card">
                <div class="card-header" data-card-widget="collapse" data-toggle="tooltip">
                    <h3 class="card-title">Search</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                
                  <div class="card-body">

                    <div class="form-group text">
                        <label class="" for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ isset($data['request']['name']) ? $data['request']['name'] : '' }}">
                      </div>
                      <input type="hidden" name="sort" class="form-control" id="sort" value="{{ $data['sort'] }}">
                      <input type="hidden" name="limit" class="form-control" id="limit" value="{{ $data['limit'] }}">
                      <div class="cls">
                        
                      </div>
                    
                  </div>
                  <div class="card-footer text-center">
                    <div class="form-group">
                      <input type="submit" value="Search" class="btn bg-gradient-primary margin-top-15">
                    </div>
                    <div class="cls">
                      
                    </div>
                  </div>
                
                <!-- /.card-body -->
              </div>
            </form>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{$data['Title']}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="table-responsive p-0">
                <div class="card-body">
                  <form method="get" enctype="multipart/form-data" accept-charset="utf-8" class="form-table" id="dataForm" autocomplete="off" action="{{ $CURRENT_URL }}">
                    <div class="form-group button-group result-top">
                      <div class="result-top-buttons">
                        <div class="form-group">
                          <a href="{{ url('/age/add')}}" class="btn btn-primary btn-addnew">Add New</a> 
                        </div>
                      </div>
                      <div class="result-top-elements">
                        <div class="form-group select">
                          <select name="sort" class="form-control" id="sort" data-change="top_result_change">
                            <option value="id-asc" {{!empty($data['sort']) ? (old('sort', $data['sort']) == 'id-asc' ? 'selected' : '') : (old('sort') == 'id-asc' ? 'selected' : '')}}>ID Ascending</option>
                            <option value="id-desc" {{!empty($data['sort']) ? (old('sort', $data['sort']) == 'id-desc' ? 'selected' : '') : (old('sort') == 'id-desc' ? 'selected' : '')}}>ID Descending</option>
                          </select>
                        </div>
                        <div class="form-group select">
                          <label class="" for="limit">Limit</label>
                          <select name="limit" class="form-control" id="limit" data-change="top_result_change">
                            <option value="10" {{!empty($data['limit']) ? (old('limit', $data['limit']) == 10 ? 'selected' : '') : (old('limit') == 10 ? 'selected' : '')}}>10</option>
                            <option value="20" {{!empty($data['limit']) ? (old('limit', $data['limit']) == 20 ? 'selected' : '') : (old('limit') == 20 ? 'selected' : '')}}>20</option>
                            <option value="50" {{!empty($data['limit']) ? (old('limit', $data['limit']) == 50 ? 'selected' : '') : (old('limit') == 50 ? 'selected' : '')}}>50</option>
                            <option value="80" {{!empty($data['limit']) ? (old('limit', $data['limit']) == 80 ? 'selected' : '') : (old('limit') == 80 ? 'selected' : '')}}>80</option>
                            <option value="100" {{!empty($data['limit']) ? (old('limit', $data['limit']) == 100 ? 'selected' : '') : (old('limit') == 100 ? 'selected' : '')}}>100</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="" class="table table-customer table-hover text-nowrap" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data['ages'] as $age)
                            <tr>
                              <td>{{$age->id}}</td>
                              <td>{{$age->name}}</td>
                              <td> 
                                <div class="btn-group">
                                  <a href="{{url('ages').'/'.$age->id}}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="<?php echo $BASE_URL . '/age/edit/' . $age->id ?>" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                  </a> 
                                  <a href="javascript:;" data-id="{{$age->id}}" class="btn btn-danger btn_delete" data-toggle="tooltip" title="Delete">
                                    <i class="fa fa-trash" aria-hidden="true"></i>   
                                  </a>             
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>

                    <input type="hidden" name="action" class="form-control" id="action">
                    <input type="hidden" name="actionId" class="form-control" id="actionId">
                  </form>
                </div>
                <div class="dataTables_paginate paging_bootstrap fr">
                  <div class="paging_sumary">{{$data['sumary']}}</div>
                  {{ $data['ages']->links('pagination.default') }}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @endsection