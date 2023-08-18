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
                            <h5 class="mb-0">Edit Package</h5>
                        </div>

                        <form class="package_form" action="{{route('admin.packages.store')}}" method="post" enctype="multipart/form-data" >
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control shadow-sm" name="id" value="{{$package->id}}" >
                                                <label for="title" class="form-label">Title <span class="required">*</span></label>
                                                <input type="text" class="form-control shadow-sm" name="title" id="title" value="{{$package->title}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="description" id="description" rows="11">{{$package->description}}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_label_multiple">
                                                Package Locations <span class="required">*</span>
                                                </label>

                                                <select class="js-example-basic-multiple js-states form-control" id="id_label_multiple"  name="locations[]" multiple="multiple">
                                                    @foreach($allLocations as $location)
                                                        <option value="{{$location->id}}" {{ (isset($propertyLocations) && in_array($location->id, $propertyLocations)) ? "selected" : "" }} >{{$location->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                           
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 ">
                                                <label for="formFile" class="form-label">Choose Image <span class="required">*</span></label>
                                                <img src="{{ asset('storage/packages/images/'.$package->thumbnail.'') }}" id="uploadPreview" class="img-thumbnail" style="height:130px;width:100%" alt="package_image">
                                                <input class="form-control shadow-sm file-placeholder" name="thumbnail" type="file" id="thumbnail"  onchange="PreviewImage();" >
                                                <input name="thumbnailName" type="hidden" value="{{$package->thumbnail}}">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="price" id="price" min="0" value="{{$package->price}}" >
                                            </div>

                                            <div class="mb-3">
                                                <label for="numberofDays" class="form-label ">Number of days <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="numberofDays" id="days" min="0" value="{{$package->days}}" >
                                            </div>
                                        </div>
                                    </div>

                                    

                                    <!--  -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                            <label for="howtoReach" class="form-label">How to Reach <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="howtoReach" id="howtoReach" rows="11">{{$package->howToReach}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="mb-3">
                                        <label for="extraDetails" class="form-label">Extra Details <span class="required">*</span></label>
                                                <textarea class="form-control shadow-sm post-description" name="extraDetails" id="extraDetails" rows="11">{{$package->extraDetails}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!--  -->
                            
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow-sm">Update</button>
                                </div>                        
                            </div>                        
                        </form>
					</div>

                    <div class="card card-white rounded-0 mt-5">
                        <div class="card-header bg-white py-3 border-top" id="packageDetails">
                            <h5 class="mb-0">Package Details</h5>
                        </div>

                        <form class="itineraries_form" action="{{route('admin.packages.storeitineraries')}}" method="post" enctype="multipart/form-data" >
                           @csrf
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="numberofDays" class="form-label ">Number of days <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="newDays" id="days" min="0" value="{{$package->days}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Itineraries <span class="required">*</span></label>
                                                <!-- Accordion Start -->
                                                <div class="accordion" id="packageItinerariesItems">
                                                    @if(!empty($packageItineraries))
                                                        @php 
                                                            $currentItems = 1; 
                                                            $itenariesDays = $package->numberofDays;
                                                        @endphp

                                                        @include('backend.partials.itinerariesItems')
                                                    @endif
                                                </div>
                                                <!-- Accordion End -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow-sm">Update</button>
                                    <input type="hidden" name="packageId" value="{{$package->id}}" >
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