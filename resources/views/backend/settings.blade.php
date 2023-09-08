@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Global Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Global Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <style>
        .nav-pills {
            border: 1px solid #ddd; 
            .nav-link{
                color:black
            }
        }
    </style>

    @include('backend.layouts.includes.notices')
    <style>
        
        </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3 ">
                            <h5 class="mb-0">Manage Settings</h5>
                        </div>

                        <form class="settings_form" action="{{route('admin.settings.store')}}" method="post" enctype="multipart/form-data" >
                            @csrf
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="d-flex align-items-start">
                                            
                                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                <button class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general" aria-selected="true">General Settings</button>
                                                <button class="nav-link"  id="v-pills-bookings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bookings" type="button" role="tab" aria-controls="v-pills-bookings" aria-selected="false">Booking Settings</button>
                                                <button class="nav-link"  id="v-pills-additional-tab" data-bs-toggle="pill" data-bs-target="#v-pills-additional" type="button" role="tab" aria-controls="v-pills-additional" aria-selected="false">Additional Settings</button>
                                            </div>

                                            <div class="tab-content" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                                                    <!-- 1 -->
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                        <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{old('title',$settings->title)}}" >
                                                    </div>

                                                    <div class="mb-3 ">
                                                        <label for="formFile" class="form-label"> Logo <span class="required">*</span></label>
                                                        <div>
                                                            @if($settings->thumbnail != NULL)
                                                            <img src="{{ asset('storage/images/'.$settings->thumbnail.'') }}" id="uploadPreview" class="img-thumbnail" style="height:130px;width:60%" alt="image">
                                                            @else
                                                            <img id="uploadPreview" class="img-thumbnail d-none" style="height:130px;width:40%" alt="image">
                                                            @endif
                                                        </div>
                                                        
                                                        <input class="form-control shadow-sm file-placeholder" name="logo" type="file" id="thumbnail" onchange="PreviewImage();" value="{{old('thumbnail','')}}">
                                                        <input name="thumbnailName" type="hidden" value="{{$settings->thumbnail}}">
                                                    </div>
                                                    <!--  -->
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-bookings" role="tabpanel" aria-labelledby="v-pills-bookings-tab">
                                                    <!-- 2 -->
                                                    <div class="mb-3">
                                                        <label for="numberofGuests" class="form-label">Max Number of Guests <span class="required">*</span></label>
                                                        <input type="number" class="form-control shadow-sm" name="numberofGuests" id="numberofGuests" min="0" value="{{old('numberofGuests',$settings->maxGuests)}}" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="numberofcuratedGuests" class="form-label">Allow Curate if guests are more than: <span class="required">*</span></label>
                                                        <input type="number" class="form-control shadow-sm" name="numberofcuratedGuests" id="numberofcuratedGuests" min="0" value="{{old('numberofcuratedGuests',$settings->CurateifGuests)}}" >
                                                    </div> 
                                                    <!--  -->

                                                </div>
                                                <div class="tab-pane fade" id="v-pills-additional" role="tabpanel" aria-labelledby="v-pills-additional-tab">
                                                    <!-- 3 -->
                                                    <div class="mb-3">
                                                        <label for="headerscripts" class="form-label">Header Scripts</label>
                                                        <textarea class="form-control shadow-sm post-description" name="headerscripts" id="headerscripts" rows="11">{{old('headerscripts',$settings->headerscripts)}}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="footerscripts" class="form-label">Footer Scripts</label>
                                                        <textarea class="form-control shadow-sm post-description" name="footerscripts" id="footerscripts" rows="11">{{old('footerscripts',$settings->footerscripts)}}</textarea>
                                                    </div>
                                                    <!--  -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow-sm">Update</button>
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