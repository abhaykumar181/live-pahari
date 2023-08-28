@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Packages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.packages.index')}}">Packages</a></li>
                        <li class="breadcrumb-item active">Gallery</li>
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
                            <h5 class="mb-0">Package Gallery</h5>
                        </div>

                        <form class="gallery_form" action="{{route('admin.packages.storegalleryImages')}}" method="post" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" name="id" value="{{$package->id}}" />
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <div class="container ">
                                                    <div class="row align-content-center">
                                                        @if(isset($allThumbnails))
                                                            @forelse($allThumbnails as $thumbnail)
                                                                <div class="col-md-3 p-1 text-center">
                                                                    <img class="package-thumbnails img-fluid p-1" src="{{asset('/storage/gallery/images/'.$thumbnail->name.'')}}" accept="image/*" />
                                                                    <a href="javascript:void();" class="btn-sm btn-danger text-decoration-none shadow-sm d-inline-block delete-thumbnail" data-type="thumbnail" data-id="{{ $thumbnail->id }}">Remove</a>
                                                                </div>
                                                                @empty
                                                                    <div class="fs-6 text-center ">Package gallery images has not been uploaded yet.</div>
                                                            @endforelse
                                                        @endif
                                                    </div>
                                                </div>
                                           
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <!-- <label for="formFile" class="form-label">Upload Images <span class="required">*</span></label> -->
                                                <button type="button" class="btn btn-success shadow-none" onclick="document.getElementById('thumbnail').click()">Upload Images</button>
                                                <button type="submit"  class="btn btn-primary shadow-sm d-none" id="startUpload">Start Upload</button>
                                                <div id="preview" class="mb-2"></div>
                                                <input class="form-control shadow-sm file-placeholder d-none " name="thumbnail[]" type="file"  id="thumbnail" value="{{old('thumbnail','')}}" multiple >
                                               
                                            </div>
                                        </div>
                                    </div>

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