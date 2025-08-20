@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Driver Performance Report
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
                                    <th>Driver</th>
                                    <th>Employee Number</th>
                                    <th>License Number</th>
                                    <th>Trips This Month</th>
                                    <th>Total Distance</th>
                                    <th>Performance Rating</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->first_name }} {{ $driver->last_name }}</td>
                                    <td>{{ $driver->employee_number }}</td>
                                    <td>{{ $driver->license_number }}</td>
                                    <td>{{ $driver->tripLogs->count() }}</td>
                                    <td>{{ $driver->tripLogs->sum('distance_km') ?? 0 }} km</td>
                                    <td>
                                        @php
                                            $trips = $driver->tripLogs->count();
                                            $rating = $trips > 10 ? 'Excellent' : ($trips > 5 ? 'Good' : ($trips > 0 ? 'Average' : 'No Activity'));
                                            $badgeClass = $trips > 10 ? 'success' : ($trips > 5 ? 'primary' : ($trips > 0 ? 'warning' : 'secondary'));
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ $rating }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $driver->status == 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($driver->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No drivers found</td>
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
