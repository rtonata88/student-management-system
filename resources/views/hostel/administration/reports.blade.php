@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hostel Reports</h4>
                    <div class="card-tools">
                        <a href="{{ route('hostel.administration.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
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
                    <div class="row mb-4">
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

                    <!-- Payment Status & Gender Distribution -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Payment Status Overview</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="info-box bg-success">
                                                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Paid This Month</span>
                                                    <span class="info-box-number">$12,450</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 70%"></div>
                                                    </div>
                                                    <span class="progress-description">70% of expected</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-warning">
                                                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Pending Payments</span>
                                                    <span class="info-box-number">$5,280</span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width: 30%"></div>
                                                    </div>
                                                    <span class="progress-description">15 students</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Gender Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="genderChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Allocations & Room Type Distribution -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Recent Allocations</h5>
                                    <div class="card-tools">
                                        <button class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                            <i class="fas fa-eye"></i> View All
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Student</th>
                                                    <th>Hostel</th>
                                                    <th>Room</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>John Doe</td>
                                                    <td>Sunrise Hostel</td>
                                                    <td>Room 101</td>
                                                    <td>2025-01-15</td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jane Smith</td>
                                                    <td>Moonlight Hostel</td>
                                                    <td>Room 205</td>
                                                    <td>2025-01-14</td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mike Johnson</td>
                                                    <td>Sunrise Hostel</td>
                                                    <td>Room 103</td>
                                                    <td>2025-01-13</td>
                                                    <td><span class="badge badge-warning">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Sarah Wilson</td>
                                                    <td>Starlight Hostel</td>
                                                    <td>Room 301</td>
                                                    <td>2025-01-12</td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Room Type Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-responsive">
                                        <canvas id="roomTypeChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance Requests & Occupancy Trends -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Maintenance Requests</h5>
                                    <div class="card-tools">
                                        <button class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                            <i class="fas fa-plus"></i> Add Request
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <div class="text-danger">
                                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                                                <div class="mt-2">
                                                    <strong>8</strong><br>
                                                    <small>Urgent</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="text-warning">
                                                <i class="fas fa-tools fa-2x"></i>
                                                <div class="mt-2">
                                                    <strong>15</strong><br>
                                                    <small>In Progress</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="text-success">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                                <div class="mt-2">
                                                    <strong>42</strong><br>
                                                    <small>Completed</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="recent-requests">
                                        <h6>Recent Requests:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-wrench text-warning"></i> AC repair - Room 205 <span class="float-right text-muted">2h ago</span></li>
                                            <li><i class="fas fa-lightbulb text-info"></i> Light fixture - Room 101 <span class="float-right text-muted">4h ago</span></li>
                                            <li><i class="fas fa-tint text-primary"></i> Plumbing issue - Room 304 <span class="float-right text-muted">1d ago</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Occupancy Trends (Last 6 Months)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="occupancyTrendChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Export & Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Report Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group" role="group">
                                        <button class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 5px;">
                                            <i class="fas fa-file-pdf"></i> Export PDF Report
                                        </button>
                                        <button class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 5px;">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                        <button class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 5px;">
                                            <i class="fas fa-envelope"></i> Email Report
                                        </button>
                                        <button class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-print"></i> Print Report
                                        </button>
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

@push('dataTableScript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    @if($revenueData->count() > 0)
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($revenueData as $data)
                    '{{ $data->month_name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Revenue ($)',
                data: [
                    @foreach($revenueData as $data)
                        {{ $data->total_amount }},
                    @endforeach
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
                    beginAtZero: true
                }
            }
        }
    });
    @endif

    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female', 'Other'],
            datasets: [{
                data: [65, 32, 3],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 206, 86, 0.8)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Room Type Distribution Chart
    const roomTypeCtx = document.getElementById('roomTypeChart').getContext('2d');
    new Chart(roomTypeCtx, {
        type: 'pie',
        data: {
            labels: ['Single', 'Double', 'Triple', 'Quad'],
            datasets: [{
                data: [25, 45, 20, 10],
                backgroundColor: [
                    'rgba(111, 66, 193, 0.8)',
                    'rgba(0, 123, 255, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Occupancy Trends Chart
    const occupancyTrendCtx = document.getElementById('occupancyTrendChart').getContext('2d');
    new Chart(occupancyTrendCtx, {
        type: 'line',
        data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
            datasets: [{
                label: 'Occupancy Rate (%)',
                data: [78, 82, 85, 88, 92, 89],
                borderColor: 'rgba(111, 66, 193, 1)',
                backgroundColor: 'rgba(111, 66, 193, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
