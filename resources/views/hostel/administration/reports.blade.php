@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hostel Reports</h4>
                    <div class="card-tools">
                        <a href="{{ route('hostel.administration.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Occupancy Report -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Occupancy Report</h5>
                                </div>
                                <div class="card-body">
                                    @if($occupancyData->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Hostel</th>
                                                        <th>Total Beds</th>
                                                        <th>Occupied</th>
                                                        <th>Occupancy %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($occupancyData as $data)
                                                    <tr>
                                                        <td>{{ $data->name }}</td>
                                                        <td>{{ $data->total_beds }}</td>
                                                        <td>{{ $data->occupied_beds }}</td>
                                                        <td>
                                                            @php
                                                                $percentage = $data->total_beds > 0 ? round(($data->occupied_beds / $data->total_beds) * 100, 1) : 0;
                                                            @endphp
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar 
                                                                    @if($percentage >= 90) bg-danger
                                                                    @elseif($percentage >= 70) bg-warning
                                                                    @else bg-success
                                                                    @endif" 
                                                                    role="progressbar" 
                                                                    style="width: {{ $percentage }}%">
                                                                    {{ $percentage }}%
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No occupancy data available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Revenue Report -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Monthly Revenue ({{ date('Y') }})</h5>
                                </div>
                                <div class="card-body">
                                    @if($revenueData->count() > 0)
                                        <canvas id="revenueChart" width="400" height="200"></canvas>
                                    @else
                                        <p class="text-muted">No revenue data available for this year.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Hostels</span>
                                    <span class="info-box-number">{{ $occupancyData->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Beds</span>
                                    <span class="info-box-number">{{ $occupancyData->sum('total_beds') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Occupied Beds</span>
                                    <span class="info-box-number">{{ $occupancyData->sum('occupied_beds') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Revenue</span>
                                    <span class="info-box-number">${{ number_format($revenueData->sum('total_amount'), 2) }}</span>
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

@push('dataTableScript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    @if($revenueData->count() > 0)
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            datasets: [{
                label: 'Revenue ($)',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                        {{ $revenueData->where('month', $i)->first()->total_amount ?? 0 }},
                    @endfor
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    @endif
});
</script>
@endpush
