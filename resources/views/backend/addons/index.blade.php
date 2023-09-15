@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Add-ons</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add-ons</li>
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
                                <div class="col-md-6 mb-0 my-auto"><h5>All Add-ons</h5></div>
                                <div class="col-md-6 mb-0 my-auto text-end"><a class="btn shadow-sm btn-primary" href="{{route('admin.addons.create')}}">Create New Add-on</a></div>
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
                                    <th>Status</th>
                                    <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $serialno= 1;  @endphp
                                    @foreach($addons as $key => $addon)
                                    <tr>
                                        <th>{{ $serialno++ }}</th>
                                        <td>{{ $addon->title }}</td>
                                        <td>{{ $addon->price }}</td>
                                        <td>{{ ucwords($addon->priceType) }}</td>
                                        <td>{{ $addon->status === 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                             <a href="{{route('admin.addons.edit', ['addonId'=> $addon->id ])}}" class="btn-sm btn-primary text-decoration-none shadow-sm d-inline-block"> <i class="fa-solid fa-pencil"></i> </a>
                                             <a href="javascript:void();" class="btn-sm btn-danger text-decoration-none shadow-sm d-inline-block delete-addon " data-type="addon" data-id="{{ $addon->id }}"> <i class="fa-solid fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach
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