@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-dollar-sign"></i> Cost Analysis Report
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.reports') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Reports
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-gas-pump"></i> Monthly Fuel Costs</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($fuelCosts as $cost)
                                        <tr>
                                            <td>{{ date('F', mktime(0, 0, 0, $cost->month, 1)) }}</td>
                                            <td>${{ number_format($cost->total, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No fuel cost data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-wrench"></i> Monthly Maintenance Costs</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($maintenanceCosts as $cost)
                                        <tr>
                                            <td>{{ date('F', mktime(0, 0, 0, $cost->month, 1)) }}</td>
                                            <td>${{ number_format($cost->total, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No maintenance cost data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5><i class="fas fa-chart-bar"></i> Cost Summary</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box bg-primary">
                                        <span class="info-box-icon"><i class="fas fa-gas-pump"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Fuel Costs</span>
                                            <span class="info-box-number">${{ number_format($fuelCosts->sum('total'), 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-wrench"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Maintenance</span>
                                            <span class="info-box-number">${{ number_format($maintenanceCosts->sum('total'), 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Fleet Costs</span>
                                            <span class="info-box-number">${{ number_format($fuelCosts->sum('total') + $maintenanceCosts->sum('total'), 2) }}</span>
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
