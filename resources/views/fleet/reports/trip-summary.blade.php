@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-route"></i> Trip Summary Report
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.reports') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Reports
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box bg-primary">
                                <span class="info-box-icon"><i class="fas fa-route"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Trips</span>
                                    <span class="info-box-number">{{ $totalTrips }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-road"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Distance</span>
                                    <span class="info-box-number">{{ number_format($totalDistance, 2) }} km</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Purpose</th>
                                    <th>Destination</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th>Distance</th>
                                    <th>Passengers</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trips as $trip)
                                <tr>
                                    <td>{{ $trip->departure_time->format('Y-m-d') }}</td>
                                    <td>{{ $trip->vehicle->registration_number ?? 'N/A' }}</td>
                                    <td>{{ $trip->driver->first_name ?? 'N/A' }} {{ $trip->driver->last_name ?? '' }}</td>
                                    <td>{{ $trip->trip_purpose }}</td>
                                    <td>{{ $trip->destination }}</td>
                                    <td>{{ $trip->departure_time->format('H:i') }}</td>
                                    <td>{{ $trip->arrival_time ? $trip->arrival_time->format('H:i') : 'Ongoing' }}</td>
                                    <td>{{ $trip->distance_km ?? 0 }} km</td>
                                    <td>{{ $trip->passengers_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No trips found for this month</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
