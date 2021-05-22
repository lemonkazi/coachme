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
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="col-md-10">
                  <h3 class="card-title">All existing {{$data['Title']}}</h3>
                </div>
                <div class="col-md-2 float-sm-right ">
                  <a href="{{ url('/user/add')}}" class="btn btn-primary btn-block mb-3">Add New</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Speciality</th>
                    <th>Experience</th>
                    <th>Rink</th>
                    <th>Price</th>
                    <th>Certificate</th>
                    <th>Phone</th>
                    
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data['users'] as $user)
                  <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->speciality_name}}</td>
                    <td>{{$user->experience_name}}</td>
                    <td>{{$user->rink_name}}</td>
                    <td>{{$user->price_name}}</td>
                    <td>{{$user->certificate_name}}</td>
                    <td>{{$user->phone_number}}</td>
                    
                    <td> 
                      <div class="btn-group">
                        <a href="{{url('users').'/'.$user->id}}" class="btn btn-primary">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo $BASE_URL . '/user/edit/' . $user->id ?>" class="btn btn-warning" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a> 
                        <a href="javascript:;" data-id="{{$user->id}}" class="btn btn-danger btn_delete" data-toggle="tooltip" title="Delete">
                          <i class="fa fa-trash" aria-hidden="true"></i>   
                        </a>             
                      </div>
                 </td>
                   </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Speciality</th>
                    <th>Experience</th>
                    <th>Rink</th>
                    <th>Price</th>
                    <th>Certificate</th>
                    <th>Phone</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <div class="box-footer clearfix">
                  {{ $data['users']->links('pagination.default') }}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @endsection