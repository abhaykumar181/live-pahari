@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Addons</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.addons.index')}}">Addons</a></li>
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
                            <h5 class="mb-0">Edit Addon</h5>
                        </div>

                        <form class="addon_form" action="{{route('admin.addons.store')}}" method="post" enctype="multipart/form-data" >
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control shadow-sm" name="id" value="{{$addons->id}}" >
                                                <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{$addons->title}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm" name="description" id="description" rows="11">{{$addons->description}}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_label_multiple">
                                                    Select Locations <span class="required">*</span>
                                                </label>

                                                <select class="js-example-basic-multiple js-states form-control" id="id_label_multiple" multiple="multiple">
                                                    @foreach($allLocations as $location)
                                                    <option value="{{$location->id}}">{{$location->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                           
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 ">
                                                <label for="formFile" class="form-label">Choose Image <span class="required">*</span></label>
                                                <img src="{{ asset('storage/addons/images/'.$addons->thumbnail.'') }}" id="uploadPreview" class="img-thumbnail" style="height:130px;width:100%" alt="image">
                                                <input class="form-control shadow-sm file-placeholder" name="thumbnail" type="file" id="thumbnail"  onchange="PreviewImage();" >
                                                <input name="thumbnailName" type="hidden" value="{{$addons->thumbnail}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="price" id="price" min="0" value="{{$addons->price}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Price Type <span class="required">*</span></label>
                                                <select class="form-select shadow-sm" name="priceType" id="status">
                                                    <option selected value="">Select price type</option>
                                                    <option value="fixed" {{ $addons->priceType === 'fixed'  ? 'selected' : '' }}>Fixed</option>
                                                    <option value="unit" {{ $addons->priceType === 'unit'  ? 'selected' : '' }}>Unit</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="addonStatus" class="form-label">Status <span class="required">*</span></label>
                                                <select class="form-select shadow-sm" name="addon_status" id="addonStatus">
                                                    <option selected value="">Select status</option>
                                                    <option value="1" {{ $addons->status === 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $addons->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
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