@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Fleet Reports
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Vehicle Utilization Report -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-car"></i> Vehicle Utilization</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">View vehicle usage statistics, mileage reports, and utilization rates.</p>
                                    @permission('fleet-reports-view')
                                    <a href="{{ route('fleet.reports.vehicle-utilization') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-eye"></i> View Report
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>

                        <!-- Fuel Consumption Report -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-gas-pump"></i> Fuel Consumption</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Analyze fuel consumption patterns, costs, and efficiency metrics.</p>
                                    @permission('fleet-reports-view')
                                    <a href="{{ route('fleet.reports.fuel-consumption') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-eye"></i> View Report
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>

                        <!-- Maintenance Report -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0"><i class="fas fa-wrench"></i> Maintenance</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Track maintenance schedules, costs, and upcoming service requirements.</p>
                                    @permission('fleet-reports-view')
                                    <a href="{{ route('fleet.reports.maintenance') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-eye"></i> View Report
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>

                        <!-- Driver Performance Report -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-user"></i> Driver Performance</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Evaluate driver performance, trip statistics, and safety records.</p>
                                    @permission('fleet-reports-view')
                                    <a href="{{ route('fleet.reports.driver-performance') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-eye"></i> View Report
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>

                        <!-- Cost Analysis Report -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0"><i class="fas fa-dollar-sign"></i> Cost Analysis</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Comprehensive cost breakdown including fuel, maintenance, and operations.</p>
                                    @permission('fleet-reports-view')
                                    <a href="{{ route('fleet.reports.cost-analysis') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-eye"></i> View Report
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>

                        <!-- Trip Summary Report -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fas fa-route"></i> Trip Summary</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Detailed trip logs, routes, distances, and time analysis.</p>
                                    @permission('fleet-reports-view')
                                    <a href="{{ route('fleet.reports.trip-summary') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-eye"></i> View Report
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5><i class="fas fa-tachometer-alt"></i> Quick Statistics</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <span class="info-box-icon" style="color: white; opacity: 0.9;"><i class="fas fa-car"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="color: white; font-weight: 500;">Total Vehicles</span>
                                            <span class="info-box-number" style="color: white; font-size: 2rem; font-weight: bold;">{{ $totalVehicles }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <span class="info-box-icon" style="color: white; opacity: 0.9;"><i class="fas fa-route"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="color: white; font-weight: 500;">Total Trips</span>
                                            <span class="info-box-number" style="color: white; font-size: 2rem; font-weight: bold;">{{ $totalTrips }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <span class="info-box-icon" style="color: white; opacity: 0.9;"><i class="fas fa-gas-pump"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="color: white; font-weight: 500;">Fuel Cost (MTD)</span>
                                            <span class="info-box-number" style="color: white; font-size: 2rem; font-weight: bold;">${{ number_format($monthlyFuelCost, 0) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <span class="info-box-icon" style="color: white; opacity: 0.9;"><i class="fas fa-wrench"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="color: white; font-weight: 500;">Pending Services</span>
                                            <span class="info-box-number" style="color: white; font-size: 2rem; font-weight: bold;">{{ $pendingServices }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
