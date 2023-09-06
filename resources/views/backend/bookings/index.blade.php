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
                        <li class="breadcrumb-item active">Bookings</li>
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
                                <div class="col-md-6 mb-0 my-auto"><h5>All Bookings</h5></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table border ">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Booking Code</th>
                                        <th>Name</th>
                                        <th>Package Name</th>
                                        <th>Check-in Date</th>
                                        <th>Number of Guests</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $serialno= 1;  @endphp
                                    @foreach($bookings as $key => $booking)
                                    <tr>
                                        <th>{{$serialno++}}</th>
                                        <td>{{$booking->bookingCode}}</td>
                                        <td>{{$booking->name}}</td>
                                        <td>{{getPackageName($booking->packageId)}}</td>
                                        <td>{{$booking->checkInDate}}</td>
                                        <td>{{$booking->guests}}</td>
                                        <td>{{ucfirst($booking->status)}}</td>
                                        <td>
                                            <a href="{{ route('admin.bookings.view-details', ['bookingId' => $booking->id]) }}" class="btn-sm btn-primary text-decoration-none shadow-sm d-inline-block" > <i class="fa-solid fa-eye"></i> </a>
                                        </td>
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