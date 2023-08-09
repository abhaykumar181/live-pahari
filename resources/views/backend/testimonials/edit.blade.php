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
                        <li class="breadcrumb-item"><a href="{{route('admin.testimonials.index')}}">Testimonials</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h5 class="mb-0">Edit Testimonial</h5>
                        </div>

                        <form class="testimonial_form" action="{{route('admin.testimonials.update')}}" method="post" enctype="multipart/form-data" >
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="name" id="name" value="{{$testimonial->name}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{$testimonial->title}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="testimonial" class="form-label">Testimonial <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm" name="testimonial" id="testimonial" rows="4">{{$testimonial->testimonial}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 ">
                                                <label for="formFile" class="form-label">Choose Image</label>
                                                <input class="form-control shadow-sm file-placeholder" name="thumbnail" type="file" id="thumbnail" value="{{old('thumbnail','')}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span class="required">*</span></label>
                                                <select class="form-select shadow-sm" name="testimonial_status" id="status">
                                                    <option selected value="">Select status</option>
                                                    <option value="1" {{ $testimonial->status === 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $testimonial->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>                        
                            </div>                        
                        </form>
					</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection