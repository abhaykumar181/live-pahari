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
                        <li class="breadcrumb-item active">Itineraries</li>
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
                        <div class="card-header bg-white py-3 border-top" id="packageDetails">
                            <h5 class="mb-0">Itineraries Details</h5>
                        </div>

                        <form class="itineraries_form" action="{{route('admin.packages.storeitineraries')}}" method="post" enctype="multipart/form-data" >
                           @csrf
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="numberofDays" class="form-label ">Number of days <span class="required">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="numberofDays" id="numberofDays" min="0" value="{{ old('numberofDays') ? old('numberofDays') : $package->days}}" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Itineraries <span class="required">*</span></label>
                                                <!-- Accordion Start -->
                                                <div class="accordion" id="packageItinerariesItems">
                                                    @if(!empty($packageItineraries))
                                                        @php 
                                                            $currentItems = 1;
                                                            $itenariesDays = old('numberofDays') ? old('numberofDays') : $package->days;
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
                                    <button type="submit" class="btn btn-success shadow-sm" id="itineraryUpdate">Update</button>
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