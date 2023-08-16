@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Testimonials</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Testimonials</li>
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
                        
                        <div class="card-header bg-white py-3  ">
                            <div class="row">
                                <div class="col-md-6 mb-0 my-auto"><h5>All Testimonials</h5></div>
                                <div class="col-md-6 mb-0 my-auto text-end"><a class="btn shadow-sm btn-primary" href="{{route('admin.testimonials.create')}}">Create New Testimonial</a></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table border ">
                                <thead>
                                    <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th style="width:30%">Testimonial</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serialno= 1;  @endphp
                                    @foreach($testimonials as $key => $testimonial)
                                    <tr>
                                        <th>{{$serialno++}}</th>
                                        <td>{{$testimonial->name}}</td>
                                        <td>{{$testimonial->title}}</td>
                                        <td>{{setTextlimit($testimonial->testimonial)}}</td>
                                        <td>{{ $testimonial->status === 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                             <a href="{{route('admin.testimonials.edit', ['testimonialId'=> $testimonial->id ])}}" class="btn-sm btn-primary text-decoration-none shadow-sm d-inline-block"> <i class="fa-solid fa-pencil"></i> </a>
                                             <a href="javascript:void();" class="btn-sm btn-danger text-decoration-none shadow-sm d-inline-block delete " data-type="testimonial" data-id="{{ $testimonial->id }}"> <i class="fa-solid fa-trash"></i> </a>
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