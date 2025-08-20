<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Driver;
use App\TripLog;
use App\FuelRecord;
use App\VehicleService;
use App\VehicleAssignment;
use App\VehicleCategory;

class FleetManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fleet-management');
    }

    /**
     * Display fleet management dashboard
     */
    public function index()
    {
        $totalVehicles = Vehicle::count();
        $activeVehicles = Vehicle::where('status', 'active')->count();
        $maintenanceVehicles = Vehicle::where('status', 'maintenance')->count();
        $totalDrivers = Driver::count();
        $activeDrivers = Driver::where('status', 'active')->count();
        $ongoingTrips = TripLog::where('status', 'ongoing')->count();
        $monthlyFuelCost = FuelRecord::whereMonth('fuel_date', now()->month)->sum('total_cost');
        $pendingServices = VehicleService::where('status', 'scheduled')->count();

        return view('fleet.dashboard', compact(
            'totalVehicles', 'activeVehicles', 'maintenanceVehicles',
            'totalDrivers', 'activeDrivers', 'ongoingTrips',
            'monthlyFuelCost', 'pendingServices'
        ));
    }

    /**
     * Vehicle management
     */
    public function vehicles()
    {
        // Remove authorize call - permission already checked by middleware
        
        $vehicles = Vehicle::with(['category', 'currentDriver.driver'])->paginate(15);
        $categories = VehicleCategory::active()->get();
        
        return view('fleet.vehicles.index', compact('vehicles', 'categories'));
    }

    public function createVehicle()
    {
        // Permission checked by middleware
        
        $categories = VehicleCategory::active()->get();
        return view('fleet.vehicles.create', compact('categories'));
    }

    public function storeVehicle(Request $request)
    {
        // Permission checked by middleware
        
        $request->validate([
            'registration_number' => 'required|unique:vehicles',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seating_capacity' => 'required|integer|min:1',
            'fuel_capacity' => 'required|numeric|min:0',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'category_id' => 'required|exists:vehicle_categories,id'
        ]);

        Vehicle::create($request->all());
        
        return redirect()->route('fleet.vehicles')->with('success', 'Vehicle added successfully');
    }

    public function editVehicle(Vehicle $vehicle)
    {
        // Permission checked by middleware
        
        $categories = VehicleCategory::active()->get();
        return view('fleet.vehicles.edit', compact('vehicle', 'categories'));
    }

    public function updateVehicle(Request $request, Vehicle $vehicle)
    {
        // Permission checked by middleware
        
        $request->validate([
            'registration_number' => 'required|unique:vehicles,registration_number,' . $vehicle->id,
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seating_capacity' => 'required|integer|min:1',
            'fuel_capacity' => 'required|numeric|min:0',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'category_id' => 'required|exists:vehicle_categories,id'
        ]);

        $vehicle->update($request->all());
        
        return redirect()->route('fleet.vehicles')->with('success', 'Vehicle updated successfully');
    }

    public function destroyVehicle(Vehicle $vehicle)
    {
        // Permission checked by middleware
        
        $vehicle->delete();
        return redirect()->route('fleet.vehicles')->with('success', 'Vehicle deleted successfully');
    }

    /**
     * Driver management
     */
    public function drivers()
    {
        // Permission checked by middleware
        
        $drivers = Driver::with('currentVehicle.vehicle')->paginate(15);
        return view('fleet.drivers.index', compact('drivers'));
    }

    public function createDriver()
    {
        // Permission checked by middleware
        
        return view('fleet.drivers.create');
    }

    public function storeDriver(Request $request)
    {
        // Permission checked by middleware
        
        $request->validate([
            'employee_number' => 'required|unique:drivers',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'license_number' => 'required|unique:drivers',
            'license_expiry' => 'required|date|after:today',
            'license_class' => 'required|in:A,B,C,D,E',
            'hire_date' => 'required|date'
        ]);

        Driver::create($request->all());
        
        return redirect()->route('fleet.drivers')->with('success', 'Driver added successfully');
    }

    public function editDriver(Driver $driver)
    {
        // Permission checked by middleware
        
        return view('fleet.drivers.edit', compact('driver'));
    }

    public function updateDriver(Request $request, Driver $driver)
    {
        // Permission checked by middleware
        
        $request->validate([
            'employee_number' => 'required|unique:drivers,employee_number,' . $driver->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'license_number' => 'required|unique:drivers,license_number,' . $driver->id,
            'license_expiry' => 'required|date|after:today',
            'license_class' => 'required|in:A,B,C,D,E',
            'hire_date' => 'required|date'
        ]);

        $driver->update($request->all());
        
        return redirect()->route('fleet.drivers')->with('success', 'Driver updated successfully');
    }

    public function destroyDriver(Driver $driver)
    {
        // Permission checked by middleware
        
        $driver->delete();
        return redirect()->route('fleet.drivers')->with('success', 'Driver deleted successfully');
    }

    /**
     * Trip management
     */
    public function trips()
    {
        // Permission checked by middleware
        
        $trips = TripLog::with(['vehicle', 'driver'])->latest()->paginate(15);
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        
        // Statistics for summary cards
        $totalTrips = TripLog::count();
        $totalDistance = TripLog::sum('distance_km') ?? 0;
        $totalFuelConsumed = TripLog::sum('fuel_consumed') ?? 0;
        $activeTrips = TripLog::whereNull('arrival_date')->count();
        
        return view('fleet.trips.index', compact('trips', 'vehicles', 'drivers', 'totalTrips', 'totalDistance', 'totalFuelConsumed', 'activeTrips'));
    }

    public function createTrip()
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::active()->get();
        $drivers = Driver::active()->get();
        return view('fleet.trips.create', compact('vehicles', 'drivers'));
    }

    public function storeTrip(Request $request)
    {
        // Permission checked by middleware
        
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'trip_purpose' => 'required',
            'destination' => 'required',
            'departure_time' => 'required|date',
            'odometer_start' => 'required|integer|min:0'
        ]);

        TripLog::create($request->all());
        
        return redirect()->route('fleet.trips')->with('success', 'Trip log created successfully');
    }

    /**
     * Fuel management
     */
    public function fuel()
    {
        // Permission checked by middleware
        
        $fuelRecords = FuelRecord::with(['vehicle', 'driver'])->latest()->paginate(15);
        return view('fleet.fuel.index', compact('fuelRecords'));
    }

    public function createFuelRecord()
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::active()->get();
        $drivers = Driver::active()->get();
        return view('fleet.fuel.create', compact('vehicles', 'drivers'));
    }

    public function storeFuelRecord(Request $request)
    {
        // Permission checked by middleware
        
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'fuel_date' => 'required|date',
            'liters' => 'required|numeric|min:0',
            'cost_per_liter' => 'required|numeric|min:0',
            'odometer_reading' => 'required|integer|min:0',
            'fuel_station' => 'required'
        ]);

        FuelRecord::create($request->all());
        
        return redirect()->route('fleet.fuel')->with('success', 'Fuel record added successfully');
    }

    /**
     * Service management
     */
    public function services()
    {
        // Permission checked by middleware
        
        $services = VehicleService::with('vehicle')->latest()->paginate(15);
        return view('fleet.services.index', compact('services'));
    }

    public function createService()
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::all();
        return view('fleet.services.create', compact('vehicles'));
    }

    public function storeService(Request $request)
    {
        // Permission checked by middleware
        
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_type' => 'required|in:routine,repair,inspection,emergency',
            'service_description' => 'required',
            'service_date' => 'required|date',
            'odometer_reading' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'service_provider' => 'required'
        ]);

        VehicleService::create($request->all());
        
        return redirect()->route('fleet.services')->with('success', 'Service record added successfully');
    }

    /**
     * Vehicle assignments
     */
    public function assignments()
    {
        // Permission checked by middleware
        
        $assignments = VehicleAssignment::with(['vehicle', 'driver'])->latest()->paginate(15);
        return view('fleet.assignments.index', compact('assignments'));
    }

    public function createAssignment()
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::active()->get();
        $drivers = Driver::active()->get();
        return view('fleet.assignments.create', compact('vehicles', 'drivers'));
    }

    public function storeAssignment(Request $request)
    {
        // Permission checked by middleware
        
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'assigned_date' => 'required|date'
        ]);

        VehicleAssignment::create($request->all());
        
        return redirect()->route('fleet.assignments')->with('success', 'Vehicle assigned successfully');
    }

    /**
     * Reports
     */
    public function reports()
    {
        // Permission checked by middleware
        
        return view('fleet.reports.index');
    }
}
