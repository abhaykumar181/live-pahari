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
                            <table class="table border">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item type</th>
                                        <th>Item Name</th>
                                        <th>Price</th>
                                        <th>Price Type</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $serialno= 1;  @endphp
                                    @foreach($orderItems as $key => $item)
                                    <tr>
                                        <th>{{ $serialno++ }}</th>
                                        <td>{{ $item->objectType }}</td>
                                        <td>
                                            @if( $item->objectType == "package" )
                                                {{ getPackageDetails($item->objectId)->title }}
                                            @elseif($item->objectType == "property")
                                                {{ getPropertyDetails($item->objectId)->title }}
                                            @elseif($item->objectType == "addon")
                                                {{ getAddonDetails($item->objectId)->title }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->baseprice }}
                                        </td>
                                        <td>
                                            {{ $item->priceType }}
                                        </td>
                                        <td>
                                            {{ $item->totalPrice }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                                <tr>
                                    <td colspan="5"></td>
                                    <td class="table-active text-start">
                                        <span> Sub Total : {{ $orderItems->sum('totalPrice') }} </span>
                                    </td>
                                </tr>

                            </table>
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
                            <table class="table border ">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Property Name</th>
                                        <th>Property Owner</th>
                                        <th>Owner Email</th>
                                        <th>Phone Number</th>
                                        <th>Confirmation</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $serialno= 1;  @endphp
                                    @foreach($propertyDetails as $key => $property)
                                    <tr>
                                        <th>{{ $serialno++ }}</th>
                                        <td>{{ getPropertyDetails($property->propertyId)->title }}</td>
                                        <td>{{ getPropertyDetails($property->propertyId)->ownerName }}</td>
                                        <td>{{ getPropertyDetails($property->propertyId)->email }}</td>
                                        <td>{{ getPropertyDetails($property->propertyId)->phone }}</td>
                                        <td>{{ ucfirst($property->confirmation) }}</td>
                                        <td>{{ ucfirst($property->payment) }}</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
					</div>
                </div>
            </div>


        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
