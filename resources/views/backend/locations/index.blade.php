@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Locations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Locations</li>
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
                            <h5 class="mb-0">Manage Locations</h5>
                        </div>

                        <div class="card-body">
                            <div class="conatiner">
                                <div class="row">
                                    <!-- add locations -->
                                    <div class="col-md-4">
                                        <div class="fw-bold fs-5">Add Location</div>
                                        <div class="input-group my-3">
                                        <form class="form" action="{{route('admin.locations.store')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Enter Location</label>
                                                <input type="text" class="form-control shadow-sm" name="location" id="location">
                                            </div>
                                            <button type="submit" class="btn btn-success shadow-sm">Save</button>
                                        </form>
                                        </div>
                                    </div>
                                    <!-- location listing  -->
                                    <div class="col-md-8">
                                        <table class="table border ">
                                            <thead>
                                                <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $serialno= 1;  @endphp
                                                @foreach($locations as $key => $location)
                                                <tr>
                                                    <th scope="row">{{$serialno++}}</th>
                                                    <td>{{$location->name}}</td>
                                                    <td><a href="{{route('admin.locations.edit', ['locationId' => $location->id])}}" class="btn-sm btn-primary text-decoration-none shadow-sm">Edit</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection