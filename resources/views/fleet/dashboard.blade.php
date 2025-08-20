@extends('layouts.app')

@section('content')
<style>
.fleet-dashboard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.dashboard-header {
    text-align: center;
    color: white;
    margin-bottom: 3rem;
}

.dashboard-header h1 {
    font-size: 2.5rem;
    font-weight: 300;
    margin-bottom: 0.5rem;
}

.dashboard-header p {
    font-size: 1.1rem;
    opacity: 0.9;
}

.stats-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.stats-card.vehicle-card::before {
    background: linear-gradient(90deg, #4facfe, #00f2fe);
}

.stats-card.driver-card::before {
    background: linear-gradient(90deg, #43e97b, #38f9d7);
}

.stats-card.maintenance-card::before {
    background: linear-gradient(90deg, #fa709a, #fee140);
}

.stats-card.trip-card::before {
    background: linear-gradient(90deg, #a8edea, #fed6e3);
}

.stats-card.fuel-card::before {
    background: linear-gradient(90deg, #ff9a9e, #fecfef);
}

.stats-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.stats-icon.vehicle-icon {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
}

.stats-icon.driver-icon {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
}

.stats-icon.maintenance-icon {
    background: linear-gradient(135deg, #fa709a, #fee140);
}

.stats-icon.trip-icon {
    background: linear-gradient(135deg, #a8edea, #fed6e3);
    color: #333;
}

.stats-icon.fuel-icon {
    background: linear-gradient(135deg, #ff9a9e, #fecfef);
}

.stats-number {
    font-size: 3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    text-align: center;
}

.stats-label {
    font-size: 1.1rem;
    color: #7f8c8d;
    text-align: center;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.stats-link {
    display: inline-flex;
    align-items: center;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
    justify-content: center;
    width: 100%;
}

.stats-link:hover {
    color: #764ba2;
    text-decoration: none;
}

.stats-link i {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.stats-link:hover i {
    transform: translateX(3px);
}

.quick-actions {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-top: 2rem;
}

.quick-actions h3 {
    color: #2c3e50;
    margin-bottom: 2rem;
    text-align: center;
    font-weight: 600;
}

.action-btn {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 15px;
    padding: 1rem 1.5rem;
    color: white;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
    width: 100%;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.action-btn i {
    margin-right: 0.5rem;
    font-size: 1.1rem;
}

.action-btn.btn-vehicle {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
}

.action-btn.btn-driver {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
}

.action-btn.btn-trip {
    background: linear-gradient(135deg, #fa709a, #fee140);
}

.action-btn.btn-fuel {
    background: linear-gradient(135deg, #ff9a9e, #fecfef);
}
</style>

<div class="fleet-dashboard">
    <div class="container-fluid">
        <div class="dashboard-header">
            <h1><i class="fas fa-truck"></i> Fleet Management Dashboard</h1>
            <p>Monitor and manage your institution's vehicle fleet</p>
        </div>

        <div class="row">
            <!-- Vehicle Statistics -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card vehicle-card">
                    <div class="stats-icon vehicle-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="stats-number">{{ $totalVehicles }}</div>
                    <div class="stats-label">Total Vehicles</div>
                    <a href="{{ route('fleet.vehicles') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card vehicle-card">
                    <div class="stats-icon vehicle-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-number">{{ $activeVehicles }}</div>
                    <div class="stats-label">Active Vehicles</div>
                    <a href="{{ route('fleet.vehicles') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card maintenance-card">
                    <div class="stats-icon maintenance-icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="stats-number">{{ $maintenanceVehicles }}</div>
                    <div class="stats-label">Under Maintenance</div>
                    <a href="{{ route('fleet.services') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card trip-card">
                    <div class="stats-icon trip-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="stats-number">{{ $ongoingTrips }}</div>
                    <div class="stats-label">Ongoing Trips</div>
                    <a href="{{ route('fleet.trips') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Driver Statistics -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card driver-card">
                    <div class="stats-icon driver-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number">{{ $totalDrivers }}</div>
                    <div class="stats-label">Total Drivers</div>
                    <a href="{{ route('fleet.drivers') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card driver-card">
                    <div class="stats-icon driver-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stats-number">{{ $activeDrivers }}</div>
                    <div class="stats-label">Active Drivers</div>
                    <a href="{{ route('fleet.drivers') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card fuel-card">
                    <div class="stats-icon fuel-icon">
                        <i class="fas fa-gas-pump"></i>
                    </div>
                    <div class="stats-number">${{ number_format($monthlyFuelCost, 0) }}</div>
                    <div class="stats-label">Monthly Fuel Cost</div>
                    <a href="{{ route('fleet.fuel') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="stats-card maintenance-card">
                    <div class="stats-icon maintenance-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stats-number">{{ $pendingServices }}</div>
                    <div class="stats-label">Pending Services</div>
                    <a href="{{ route('fleet.services') }}" class="stats-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="quick-actions">
                    <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    <div class="row">
                        @permission('fleet-vehicles-create')
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <a href="{{ route('fleet.vehicles.create') }}" class="action-btn btn-vehicle">
                                <i class="fas fa-plus"></i> Add Vehicle
                            </a>
                        </div>
                        @endpermission

                        @permission('fleet-drivers-create')
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <a href="{{ route('fleet.drivers.create') }}" class="action-btn btn-driver">
                                <i class="fas fa-user-plus"></i> Add Driver
                            </a>
                        </div>
                        @endpermission

                        @permission('fleet-trips-create')
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <a href="{{ route('fleet.trips.create') }}" class="action-btn btn-trip">
                                <i class="fas fa-route"></i> Log Trip
                            </a>
                        </div>
                        @endpermission

                        @permission('fleet-fuel-create')
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <a href="{{ route('fleet.fuel.create') }}" class="action-btn btn-fuel">
                                <i class="fas fa-gas-pump"></i> Add Fuel Record
                            </a>
                        </div>
                        @endpermission
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
