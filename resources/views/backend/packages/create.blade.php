@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Package</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.packages.index')}}">Packages</a></li>
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
                            <h5 class="mb-0">Create New Package</h5>
                        </div>

                        <form class="package_form" method="post" enctype="multipart/form-data" >
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{old('title','')}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="description" id="description" rows="11">{{old('description','')}}</textarea>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 ">
                                                <label for="formFile" class="form-label">Choose Image <span class="required">*</span></label>
                                                <img id="uploadPreview" class="img-thumbnail d-none" style="height:130px;width:100%" alt="image">
                                                <input class="form-control shadow-sm file-placeholder" name="thumbnail" type="file" id="thumbnail" onchange="PreviewImage();" value="{{old('thumbnail','')}}">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="price" id="price" min="0" value="{{old('price','')}}" >
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_label_multiple">
                                                    Package Locations <span class="required">*</span>
                                                </label>

                                                <select class="js-example-basic-multiple js-states form-control" name="locations[]" id="id_label_multiple" multiple="multiple">
                                                    @foreach($allLocations as $location)
                                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-header bg-white py-3 border-top ">
                                <h5 class="mb-0">Package Details</h5>
                            </div>

                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="days" class="form-label ">Number of days <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="days" id="days" min="0" value="{{old('days','')}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Itineraries <span class="required">*</span></label>
                                                
                                                <!-- Accordion Start -->
                                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                                    
                                                </div>
                                                <!-- Accordion End -->
                                                
                                            </div>
                                            <div class="mb-3">
                                                <label for="howtoReach" class="form-label">How to Reach <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="howtoReach" id="howtoReach" rows="11">{{old('howtoReach','')}}</textarea>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="extraDetails" class="form-label">Extra Details <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="extraDetails" id="extraDetails" rows="11">{{old('extraDetails','')}}</textarea>
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

