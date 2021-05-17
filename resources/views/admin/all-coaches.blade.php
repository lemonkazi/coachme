@extends('admin.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Products</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Products</li>
            </ol>
          </div><!-- /.col -->
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
                <h3 class="card-title">All existing Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Title</th>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Desctiption</th>
                    <th>Picture</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data['users'] as $user)
                  <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->title}}</td>
                    <td>{{$user->category}}</td>
                    <td>{{$user->sub_category}}</td>
                    <td>{{$user->description}}</td>
                    <td>{{$user->picture}}</td>
                    <td>{{$user->price}}</td>
                    <td>{{$user->quantity}}</td>
                    <td> <div class="btn-group">
                 <a href="#" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i>
                             </a> 
                 <a href="product_delete/{{$user->id}}" class="btn btn-danger" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash" aria-hidden="true"></i>   </a>             
                           </div>
                 </td>
                   </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Product ID</th>
                  <th>Product Title</th>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Desctiption</th>
                    <th>Picture</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <div class="box-footer clearfix">
                  {{ $data['users']->links('pagination.default') }}
                  
                  <!-- <ul class="pagination pagination-sm no-margin pull-right">
                      @if($data['users']->previousPageUrl())

                        <li><a class="next page-numbers" href="{{$data['users']->previousPageUrl()}}"><< Previous</a></li>

                      @endif

                      @if($data['users']->hasMorePages())

                        <li><a class="next page-numbers" href="{{$data['users']->nextPageUrl()}}">Next >></a></li>

                      @endif
                  </ul> -->
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