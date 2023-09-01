<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @include('backend.layouts.includes.head')
    </head>
    <body>
       
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto mt-5">
                    <div class="card card-white rounded-0">
                        
                        <div class="card-header bg-white py-3 ">
                            <h5 class="mb-0">Confirmtaion Pending Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Booking ID
                                                </div>
                                                <div class="col">
                                                {{ $booking->bookingCode }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Customer Name
                                                </div>
                                                <div class="col">
                                                {{ $booking->name }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Email
                                                </div>
                                                <div class="col">
                                                {{ $booking->email }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Phone Number
                                                </div>
                                                <div class="col">
                                                {{ $booking->phone }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Number of Guests
                                                </div>
                                                <div class="col">
                                                {{ $booking->guests }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Check-in Date
                                                </div>
                                                <div class="col">
                                                {{ $booking->checkInDate }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Check-in Date
                                                </div>
                                                <div class="col">
                                                {{ $booking->checkOutDate }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    Confirmation
                                                </div>
                                                <div class="col">
                                                {{ $confirmationItem->confirmation }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{ asset('storage/images/'.$property->thumbnail.'') }}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $property->title }}</h5>
                                            <p class="card-text">{!! setTextlimit($property->description) !!}</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                <form class="confirm-property" action="{{route('bookings.confirmProperty')}}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $confirmationItem->id }}" />
                                    <button type="submit" class="btn btn-primary shadow-sm" id="btn-confirm">Confirm</button>
                                </form>
                                <a href="javascript:void();" class="btn btn-danger text-decoration-none shadow-sm d-inline-block reject-property" data-type="rejectProperty" data-id=""> Reject </a>
                            </div>                        
                        </div>        
					</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
      
    @include('backend.layouts.includes.scripts')
        
    </body>
</html>
