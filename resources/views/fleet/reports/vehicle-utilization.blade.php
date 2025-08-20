@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-car"></i> Vehicle Utilization Report
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.reports') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Reports
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Vehicle</th>
                                    <th>Registration</th>
                                    <th>Status</th>
                                    <th>Trips This Month</th>
                                    <th>Total Distance</th>
                                    <th>Utilization Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->registration_number }}</td>
                                    <td>
                                        <span class="badge badge-{{ $vehicle->status == 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $vehicle->tripLogs->count() }}</td>
                                    <td>{{ $vehicle->tripLogs->sum('distance_km') ?? 0 }} km</td>
                                    <td>
                                        @php
                                            $utilization = $vehicle->tripLogs->count() > 0 ? 'High' : 'Low';
                                            $badgeClass = $vehicle->tripLogs->count() > 5 ? 'success' : ($vehicle->tripLogs->count() > 2 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ $utilization }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No vehicles found</td>
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
