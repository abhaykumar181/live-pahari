@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper-inner" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Bookings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Booking details</li>
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
                            <div class="row">
                                <div class="col-md-6 mb-0 my-auto"><h5>Booking Details</h5></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="container ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                                Booking Code
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->bookingCode }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               PackageName
                                            </div>
                                            <div class="col-md-8 text-success">
                                                {{ getPackageDetails($booking->packageId)-> title }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Customer Name
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->name }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Customer Email
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->email }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Phone Number
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->phone }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Number of Guests
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->guests }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Check-in Date
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->checkInDate }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Check-out Date
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->checkOutDate }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Status
                                            </div>
                                            <div class="col-md-8">
                                                {{ ucfirst($booking->status) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 fw-bold">
                                               Booking Created on 
                                            </div>
                                            <div class="col-md-8">
                                                {{ $booking->created_at }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3 ">
                            <div class="row">
                                <div class="col-md-6 mb-0 my-auto"><h5>Order Details</h5></div>
                            </div>
                        </div>

                        <div class="card-body">                            
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Item type
                                    </div>
                                    <div class="col-md-4 fs-5 fw-bold mb-2">
                                    Item Name
                                    </div>
                                    <div class="col-md-3 fs-5 fw-bold mb-2">
                                    Price
                                    </div>
                                    <div class="col-md-3 fs-5 fw-bold mb-2">
                                    Total Price
                                    </div>

                                    @foreach($orderItems as $key => $item)
                                        <div class="col-md-2">
                                            {{ ucfirst($item->objectType) }}
                                        </div>
                                        <div class="col-md-4">
                                            @if( $item->objectType == "package" )
                                                {{ getPackageDetails($item->objectId)->title }}
                                            @elseif($item->objectType == "property")
                                                {{ getPropertyDetails($item->objectId)->title }}
                                            @elseif($item->objectType == "addon")
                                                {{ getAddonDetails($item->objectId)->title }}
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            {{ $item->baseprice }} ({{$item->priceType}})
                                        </div>
                                        <div class="col-md-3">
                                            {{ $item->totalPrice }}
                                        </div>
                                    @endforeach
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3 fs-6 fw-bold"> Sub Total : {{ $orderItems->sum('totalPrice') }} </div>
                                </div>
                            </div>
                        </div>
                        
					</div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3 ">
                            <div class="row">
                                <div class="col-md-6 mb-0 my-auto"><h5>Property Details</h5></div>
                            </div>
                        </div>

                        <div class="card-body">                            
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Property Name
                                    </div>
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Property Owner
                                    </div>
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Owner Email
                                    </div>
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Phone Number
                                    </div>
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Confirmation
                                    </div>
                                    <div class="col-md-2 fs-5 fw-bold mb-2">
                                    Payment Status
                                    </div>

                                   
                                    @forelse($propertyDetails as $key => $property)
                                        <div class="col-md-2 ">
                                            {{ getPropertyDetails($property->propertyId)->title }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ getPropertyDetails($property->propertyId)->ownerName }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ getPropertyDetails($property->propertyId)->email }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ getPropertyDetails($property->propertyId)->phone }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ ucfirst($property->confirmation) }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ ucfirst($property->payment) }}
                                        </div>
                                        @empty
                                        <div class="col-md-12 text-center mt-2"> No property found </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
					</div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
