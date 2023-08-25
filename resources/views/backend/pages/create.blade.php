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
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.addons.index')}}">Pages</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                            <h5 class="mb-0">Create New Page</h5>
                        </div>

                        <form class="property_form" method="post" enctype="multipart/form-data" >
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-7">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{old('title','')}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="description" id="description" >{{old('description','')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="excerpt" class="form-label">Excerpt <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm " name="excerpt" id="excerpt" rows="5">{{old('excerpt','')}}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pageStatus" class="form-label">Status <span class="required">*</span></label>
                                                <select class="form-select shadow-sm" name="pageStatus" id="pageStatus">
                                                    <option selected value="">Select status</option>
                                                    <option value="publish" {{ "publish" === old('pageStatus') ? 'selected' : '' }}>Publish</option>
                                                    <option value="draft" {{ "draft" === old('pageStatus') ? 'selected' : '' }}>Draft</option>
                                                    <option value="trash" {{ "trash" === old('pageStatus') ? 'selected' : '' }}>Trash</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        

                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow-sm">Create</button>
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