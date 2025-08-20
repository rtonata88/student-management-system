@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-gas-pump"></i> Fuel Consumption Report
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.reports') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Reports
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-gas-pump"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Fuel Cost</span>
                                    <span class="info-box-number">${{ number_format($totalFuelCost, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-tint"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Quantity</span>
                                    <span class="info-box-number">{{ number_format($totalQuantity, 2) }} L</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avg Price/Liter</span>
                                    <span class="info-box-number">${{ $totalQuantity > 0 ? number_format($totalFuelCost / $totalQuantity, 2) : '0.00' }}</span>
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
                                    <th>Fuel Type</th>
                                    <th>Quantity (L)</th>
                                    <th>Price/Liter</th>
                                    <th>Total Cost</th>
                                    <th>Fuel Station</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fuelRecords as $record)
                                <tr>
                                    <td>{{ $record->date->format('Y-m-d') }}</td>
                                    <td>{{ $record->vehicle->registration_number ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($record->fuel_type) }}</td>
                                    <td>{{ number_format($record->quantity, 2) }}</td>
                                    <td>${{ number_format($record->price_per_liter, 2) }}</td>
                                    <td>${{ number_format($record->total_cost, 2) }}</td>
                                    <td>{{ $record->fuel_station }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No fuel records found for this month</td>
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
