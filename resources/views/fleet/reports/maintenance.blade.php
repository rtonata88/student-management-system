@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-wrench"></i> Maintenance Report
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
                            <h5><i class="fas fa-clock"></i> Upcoming Services</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Vehicle</th>
                                            <th>Service Type</th>
                                            <th>Scheduled Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($upcomingServices as $service)
                                        <tr>
                                            <td>{{ $service->vehicle->registration_number ?? 'N/A' }}</td>
                                            <td>{{ $service->service_type }}</td>
                                            <td>{{ $service->service_date }}</td>
                                            <td><span class="badge badge-warning">{{ ucfirst($service->status) }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No upcoming services</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-chart-pie"></i> Service Summary</h5>
                            <div class="info-box bg-primary">
                                <span class="info-box-icon"><i class="fas fa-wrench"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Services</span>
                                    <span class="info-box-number">{{ $services->count() }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Cost</span>
                                    <span class="info-box-number">${{ number_format($services->sum('cost'), 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5><i class="fas fa-history"></i> Service History</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Service Type</th>
                                    <th>Description</th>
                                    <th>Cost</th>
                                    <th>Provider</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                <tr>
                                    <td>{{ $service->service_date }}</td>
                                    <td>{{ $service->vehicle->registration_number ?? 'N/A' }}</td>
                                    <td>{{ $service->service_type }}</td>
                                    <td>{{ Str::limit($service->description, 50) }}</td>
                                    <td>${{ number_format($service->cost, 2) }}</td>
                                    <td>{{ $service->service_provider }}</td>
                                    <td>
                                        <span class="badge badge-{{ $service->status == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No service records found</td>
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
