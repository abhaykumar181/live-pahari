@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Pages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pages</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @include('backend.layouts.includes.notices')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3 ">
                            <div class="row">
                                <div class="col-md-6 mb-0 my-auto"><h5>All Pages</h5></div>
                                <div class="col-md-6 mb-0 my-auto text-end"><a class="btn shadow-sm btn-primary" href="{{route('admin.pages.create')}}">Create New Page</a></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table border ">
                                <thead>
                                    <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Price Type</th>
                                    <th>Confirmation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                  
                                </tbody>
                                
                            </table>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection