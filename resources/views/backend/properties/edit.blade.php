@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Properties</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.properties.index')}}">Properties</a></li>
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
                            <h5 class="mb-0">Edit Property</h5>
                        </div>

                        <form class="property_form" action="{{route('admin.properties.store')}}" method="post" enctype="multipart/form-data" >
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control shadow-sm" name="id" value="{{$property->id}}" >
                                                <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{$property->title}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="description" id="description" rows="11">{{$property->description}}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_label_multiple">
                                                Property Locations <span class="required">*</span>
                                                </label>

                                                <select class="js-example-basic-multiple js-states form-control" id="id_label_multiple"  name="locations[]" multiple="multiple">
                                                    @foreach($allLocations as $location)
                                                        <option value="{{$location->id}}" {{ (isset($propertyLocations) && in_array($location->id, $propertyLocations)) ? "selected" : "" }} >{{$location->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="excerpt" class="form-label">Excerpt <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm " name="excerpt" id="excerpt" rows="5">{{$property->excerpt}}</textarea>
                                            </div>

                                           
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 ">
                                                <label for="formFile" class="form-label">Choose Image <span class="required">*</span></label>
                                                <img src="{{ asset('storage/images/'.$property->thumbnail.'') }}" id="uploadPreview" class="img-thumbnail" style="height:130px;width:100%" alt="property_image">
                                                <input class="form-control shadow-sm file-placeholder" name="thumbnail" type="file" id="thumbnail"  onchange="PreviewImage();" >
                                                <input name="thumbnailName" type="hidden" value="{{$property->thumbnail}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Price Type <span class="required">*</span></label>
                                                <select class="form-select shadow-sm" name="priceType" id="status">
                                                    <option selected value="">Select price type</option>
                                                    <option value="fixed" {{ $property->priceType === 'fixed'  ? 'selected' : '' }}>Fixed</option>
                                                    <option value="unit" {{ $property->priceType === 'unit'  ? 'selected' : '' }}>Unit</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="price" id="price" min="0" value="{{$property->price}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="propertystatus" class="form-label">Status <span class="required">*</span></label>
                                                <select class="form-select shadow-sm" name="addon_status" id="propertystatus">
                                                    <option selected value="">Select status</option>
                                                    <option value="1" {{ $property->status === 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $property->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header bg-white py-3 border-top ">
                                <h5 class="mb-0">Property Details</h5>
                            </div>

                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ownerName" class="form-label">Owner Name <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="ownerName" id="ownerName" value="{{$property->ownerName}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span class="required">*</span></label>
                                                <input type="email" class="form-control shadow-sm" name="email" id="email" value="{{$property->email}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone Number <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="phone" id="phone" min="0" value="{{$property->phone}}" >
                                            </div>

                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Confirmation <span class="required">*</span></label>
                                                <div class="d-flex">
                                                    <div >
                                                        <input class="form-check-input shadow-sm" type="radio" name="confirmation" id="radio1" value="{{old('confirmation','1')}}" {{ $property->confirmationRequired === 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio1">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="mx-3">
                                                        <input class="form-check-input shadow-sm" type="radio" name="confirmation" id="radio2" value="{{old('confirmation','0')}}" {{ $property->confirmationRequired === 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio2">
                                                            No
                                                        </label>
                                                    </div>
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