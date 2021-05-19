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
                <h3 class="card-title">All existing {{$data['Title']}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Family Name</th>
                    <th>About</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>Speciality</th>
                    <th>Experience</th>
                    <th>rink</th>
                    <th>lang</th>
                    <th>price</th>
                    <th>certiface</th>
                    <th>phone</th>
                    <th>watsapp</th>
                    <th>email</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data['users'] as $user)
                  <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->family_name}}</td>
                    <td>{{$user->about}}</td>
                    <td>{{$user->province}}</td>
                    <td>{{$user->city}}</td>
                    <td>{{$user->speciality}}</td>
                    <td>{{$user->experience}}</td>
                    <td>{{$user->rink}}</td>
                    <td>{{$user->lang}}</td>
                    <td>{{$user->price}}</td>
                    <td>{{$user->certificate}}</td>
                    <td>{{$user->phone_number}}</td>
                    <td>{{$user->whatsapp}}</td>
                    <td>{{$user->email}}</td>
                    <td> 
                      <div class="btn-group">
                        <a href="{{url('coaches').'/'.$user->id}}" class="btn btn-primary">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-warning" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a> 
                        <a href="coach/delete/{{$user->id}}" class="btn btn-danger" data-toggle="tooltip" title="Delete">
                          <i class="fa fa-trash" aria-hidden="true"></i>   
                        </a>             
                      </div>
                 </td>
                   </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Family Name</th>
                    <th>About</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>Speciality</th>
                    <th>Experience</th>
                    <th>rink</th>
                    <th>lang</th>
                    <th>price</th>
                    <th>certiface</th>
                    <th>phone</th>
                    <th>watsapp</th>
                    <th>email</th>
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