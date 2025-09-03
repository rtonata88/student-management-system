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
    public function vehicles(Request $request)
    {
        // Remove authorize call - permission already checked by middleware
        
        $query = Vehicle::with(['category', 'currentDriver.driver']);
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhere('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('engine_number', 'like', "%{$search}%")
                  ->orWhere('chassis_number', 'like', "%{$search}%");
            });
        }
        
        $vehicles = $query->paginate(15);
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
        
        $validated = $request->validate([
            'registration_number' => 'required|unique:vehicles',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seating_capacity' => 'required|integer|min:1',
            'fuel_capacity' => 'required|numeric|min:0',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'category_id' => 'required|exists:vehicle_categories,id'
        ]);

        try {
            Vehicle::create($validated);
            return redirect()->route('fleet.vehicles')->with('success', 'Vehicle added successfully');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to save vehicle: ' . $e->getMessage()]);
        }
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
        
        $validated = $request->validate([
            'registration_number' => 'required|unique:vehicles,registration_number,' . $vehicle->id,
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'seating_capacity' => 'required|integer|min:1',
            'fuel_capacity' => 'required|numeric|min:0',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'category_id' => 'required|exists:vehicle_categories,id',
            'engine_number' => 'nullable|string',
            'chassis_number' => 'nullable|string',
            'color' => 'nullable|string',
            'current_odometer' => 'nullable|integer|min:0',
            'status' => 'required|in:active,maintenance,retired,accident',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'insurance_expiry' => 'nullable|date',
            'license_expiry' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $vehicle->update($validated);
        
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
    public function drivers(Request $request)
    {
        // Permission checked by middleware
        
        $query = Driver::with('currentVehicle.vehicle');
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }
        
        $drivers = $query->paginate(15);
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
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'required|unique:drivers,employee_number',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'license_number' => 'required|unique:drivers',
            'license_class' => 'required|in:A,B,C,CDL',
            'license_expiry_date' => 'required|date|after:today',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,suspended',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('driver_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Map form fields to database fields
        $driverData = [
            'employee_number' => $validated['employee_id'],
            'first_name' => explode(' ', $validated['name'])[0],
            'last_name' => implode(' ', array_slice(explode(' ', $validated['name']), 1)) ?: explode(' ', $validated['name'])[0],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'license_number' => $validated['license_number'],
            'license_class' => $validated['license_class'],
            'license_expiry' => $validated['license_expiry_date'],
            'hire_date' => $validated['hire_date'] ?? now(),
            'status' => $validated['status'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_phone' => $validated['emergency_contact_phone'],
            'notes' => $validated['notes'],
            'photo' => $validated['photo'] ?? null
        ];

        Driver::create($driverData);
        
        return redirect()->route('fleet.drivers')->with('success', 'Driver added successfully');
    }

    public function showDriver(Driver $driver)
    {
        // Permission checked by middleware
        
        $driver->load(['currentVehicle.vehicle', 'tripLogs', 'assignments.vehicle']);
        return view('fleet.drivers.show', compact('driver'));
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
    public function trips(Request $request)
    {
        // Permission checked by middleware
        
        $query = TripLog::with(['vehicle', 'driver']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('destination', 'like', "%{$search}%")
                  ->orWhere('trip_purpose', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                      $vehicleQuery->where('registration_number', 'like', "%{$search}%")
                                   ->orWhere('make', 'like', "%{$search}%")
                                   ->orWhere('model', 'like', "%{$search}%");
                  })
                  ->orWhereHas('driver', function($driverQuery) use ($search) {
                      $driverQuery->where('first_name', 'like', "%{$search}%")
                                  ->orWhere('last_name', 'like', "%{$search}%")
                                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                  });
            });
        }
        
        $trips = $query->latest()->paginate(15);
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        
        // Statistics for summary cards
        $totalTrips = TripLog::count();
        $totalDistance = TripLog::sum('distance_km') ?? 0;
        $totalFuelConsumed = TripLog::sum('fuel_liters') ?? 0;
        $activeTrips = TripLog::whereNull('arrival_time')->count();
        
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
        
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'trip_purpose' => 'required',
            'destination' => 'required',
            'departure_time' => 'required|date',
            'expected_return_time' => 'nullable|date|after:departure_time',
            'arrival_time' => 'nullable|date',
            'odometer_start' => 'required|integer|min:0',
            'odometer_end' => 'required|integer|min:0',
            'distance_km' => 'nullable|numeric|min:0',
            'fuel_type' => 'nullable|string|in:petrol,diesel,cng,electric',
            'fuel_liters' => 'nullable|numeric|min:0',
            'price_per_liter' => 'nullable|numeric|min:0',
            'total_fuel_cost' => 'nullable|numeric|min:0',
            'fuel_station' => 'nullable|string|max:255',
            'fuel_town_city' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'passenger_count' => 'nullable|integer|min:0',
            'fuel_filled_up' => 'nullable|string|in:yes,no',
            'fuel_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('fuel_receipt')) {
            $file = $request->file('fuel_receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('fuel_receipts', $filename, 'public');
            $validated['fuel_receipt_path'] = $path;
        }

        TripLog::create($validated);
        
        return redirect()->route('fleet.trips')->with('success', 'Trip logged successfully');
    }

    public function showTrip(TripLog $trip)
    {
        // Permission checked by middleware
        
        $trip->load(['vehicle', 'driver']);
        return view('fleet.trips.show', compact('trip'));
    }

    public function editTrip(TripLog $trip)
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::active()->get();
        $drivers = Driver::active()->get();
        return view('fleet.trips.edit', compact('trip', 'vehicles', 'drivers'));
    }

    public function updateTrip(Request $request, TripLog $trip)
    {
        // Permission checked by middleware
        
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'trip_purpose' => 'required',
            'destination' => 'required',
            'departure_time' => 'required|date',
            'expected_return_time' => 'nullable|date|after:departure_time',
            'arrival_time' => 'nullable|date',
            'odometer_start' => 'required|integer|min:0',
            'odometer_end' => 'required|integer|gte:odometer_start',
            'distance_km' => 'nullable|numeric|min:0',
            'fuel_type' => 'nullable|string|in:petrol,diesel,cng,electric',
            'fuel_liters' => 'nullable|numeric|min:0',
            'price_per_liter' => 'nullable|numeric|min:0',
            'total_fuel_cost' => 'nullable|numeric|min:0',
            'fuel_station' => 'nullable|string|max:255',
            'fuel_town_city' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'passenger_count' => 'nullable|integer|min:0',
            'fuel_filled_up' => 'nullable|string|in:yes,no',
            'fuel_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('fuel_receipt')) {
            $file = $request->file('fuel_receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('fuel_receipts', $filename, 'public');
            $validated['fuel_receipt_path'] = $path;
        }

        $trip->update($validated);
        
        return redirect()->route('fleet.trips')->with('success', 'Trip updated successfully');
    }

    public function destroyTrip(TripLog $trip)
    {
        // Permission checked by middleware
        
        $trip->delete();
        
        return redirect()->route('fleet.trips')->with('success', 'Trip deleted successfully');
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
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0',
            'fuel_type' => 'required',
            'odometer_reading' => 'required|integer|min:0',
            'fuel_station' => 'required'
        ]);

        FuelRecord::create($request->all());
        
        return redirect()->route('fleet.fuel')->with('success', 'Fuel record added successfully');
    }

    /**
     * Service management
     */
    public function services(Request $request)
    {
        // Permission checked by middleware
        
        $query = VehicleService::with('vehicle');
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('service_provider', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                      $vehicleQuery->where('registration_number', 'like', "%{$search}%")
                                   ->orWhere('make', 'like', "%{$search}%")
                                   ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }
        
        $services = $query->latest()->paginate(15);
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
            'service_type' => 'required|in:routine,repair,inspection,oil_change,tire_service,brake_service,other',
            'description' => 'required',
            'service_date' => 'required|date',
            'odometer_reading' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'service_provider' => 'required',
            'next_service_date' => 'nullable|date',
            'next_service_odometer' => 'nullable|integer|min:0|gte:odometer_reading',
            'parts_replaced' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled'
        ]);

        VehicleService::create($request->all());
        
        return redirect()->route('fleet.services')->with('success', 'Service record added successfully');
    }

    public function showService(VehicleService $service)
    {
        // Permission checked by middleware
        
        return view('fleet.services.show', compact('service'));
    }

    public function editService(VehicleService $service)
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::all();
        return view('fleet.services.edit', compact('service', 'vehicles'));
    }

    public function updateService(Request $request, VehicleService $service)
    {
        // Permission checked by middleware
        
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_type' => 'required|in:routine,repair,inspection,oil_change,tire_service,brake_service,other',
            'description' => 'required',
            'service_date' => 'required|date',
            'odometer_reading' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'service_provider' => 'required',
            'next_service_date' => 'nullable|date',
            'next_service_odometer' => 'nullable|integer|min:0|gte:odometer_reading',
            'parts_replaced' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled'
        ]);

        $service->update($request->all());
        
        return redirect()->route('fleet.services')->with('success', 'Service record updated successfully');
    }

    public function destroyService(VehicleService $service)
    {
        // Permission checked by middleware
        
        $service->delete();
        
        return redirect()->route('fleet.services')->with('success', 'Service record deleted successfully');
    }

    /**
     * Vehicle assignments
     */
    public function assignments(Request $request)
    {
        // Permission checked by middleware
        
        $query = VehicleAssignment::with(['vehicle', 'driver']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('assignment_type', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                      $vehicleQuery->where('registration_number', 'like', "%{$search}%")
                                   ->orWhere('make', 'like', "%{$search}%")
                                   ->orWhere('model', 'like', "%{$search}%");
                  })
                  ->orWhereHas('driver', function($driverQuery) use ($search) {
                      $driverQuery->where('first_name', 'like', "%{$search}%")
                                  ->orWhere('last_name', 'like', "%{$search}%")
                                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                  });
            });
        }
        
        $assignments = $query->latest()->paginate(15);
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
            'assignment_type' => 'required|in:primary,secondary,temporary',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        VehicleAssignment::create($request->all());
        
        return redirect()->route('fleet.assignments')->with('success', 'Vehicle assignment created successfully');
    }

    public function showAssignment(VehicleAssignment $assignment)
    {
        // Permission checked by middleware
        
        $assignment->load(['vehicle', 'driver']);
        return view('fleet.assignments.show', compact('assignment'));
    }

    public function editAssignment(VehicleAssignment $assignment)
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::active()->get();
        $drivers = Driver::active()->get();
        return view('fleet.assignments.edit', compact('assignment', 'vehicles', 'drivers'));
    }

    public function updateAssignment(Request $request, VehicleAssignment $assignment)
    {
        // Permission checked by middleware
        
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'assignment_type' => 'required|in:primary,secondary,temporary',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        $assignment->update($request->all());
        
        return redirect()->route('fleet.assignments')->with('success', 'Vehicle assignment updated successfully');
    }

    public function destroyAssignment(VehicleAssignment $assignment)
    {
        // Permission checked by middleware
        
        $assignment->delete();
        
        return redirect()->route('fleet.assignments')->with('success', 'Vehicle assignment deleted successfully');
    }

    /**
     * Reports
     */
    public function reports()
    {
        // Permission checked by middleware
        
        $totalVehicles = Vehicle::count();
        $totalTrips = TripLog::count();
        $monthlyFuelCost = TripLog::whereMonth('created_at', now()->month)->sum('total_fuel_cost');
        $pendingServices = VehicleService::where('status', 'scheduled')->count();
        
        return view('fleet.reports.index', compact('totalVehicles', 'totalTrips', 'monthlyFuelCost', 'pendingServices'));
    }

    /**
     * Vehicle Utilization Report
     */
    public function vehicleUtilizationReport()
    {
        // Permission checked by middleware
        
        $vehicles = Vehicle::with(['tripLogs' => function($query) {
            $query->whereMonth('departure_time', now()->month);
        }])->get();
        
        return view('fleet.reports.vehicle-utilization', compact('vehicles'));
    }

    /**
     * Fuel Consumption Report
     */
    public function fuelConsumptionReport()
    {
        // Permission checked by middleware
        
        $fuelRecords = FuelRecord::with('vehicle')
            ->whereMonth('fuel_date', now()->month)
            ->orderBy('fuel_date', 'desc')
            ->get();
            
        $totalFuelCost = $fuelRecords->sum('total_cost');
        $totalQuantity = $fuelRecords->sum('quantity');
        
        return view('fleet.reports.fuel-consumption', compact('fuelRecords', 'totalFuelCost', 'totalQuantity'));
    }

    /**
     * Maintenance Report
     */
    public function maintenanceReport()
    {
        // Permission checked by middleware
        
        $services = VehicleService::with('vehicle')->orderBy('service_date', 'desc')->get();
        $upcomingServices = VehicleService::where('status', 'scheduled')->get();
        
        return view('fleet.reports.maintenance', compact('services', 'upcomingServices'));
    }

    /**
     * Driver Performance Report
     */
    public function driverPerformanceReport()
    {
        // Permission checked by middleware
        
        $drivers = Driver::with(['tripLogs' => function($query) {
            $query->whereMonth('departure_time', now()->month);
        }])->get();
        
        return view('fleet.reports.driver-performance', compact('drivers'));
    }

    /**
     * Cost Analysis Report
     */
    public function costAnalysisReport()
    {
        // Permission checked by middleware
        
        $fuelCosts = FuelRecord::selectRaw('MONTH(fuel_date) as month, SUM(total_cost) as total')
            ->whereYear('fuel_date', now()->year)
            ->groupBy('month')
            ->get();
            
        $maintenanceCosts = VehicleService::selectRaw('MONTH(service_date) as month, SUM(cost) as total')
            ->whereYear('service_date', now()->year)
            ->groupBy('month')
            ->get();
        
        return view('fleet.reports.cost-analysis', compact('fuelCosts', 'maintenanceCosts'));
    }

    /**
     * Trip Summary Report
     */
    public function tripSummaryReport()
    {
        // Permission checked by middleware
        
        $trips = TripLog::with(['vehicle', 'driver'])
            ->whereMonth('departure_time', now()->month)
            ->orderBy('departure_time', 'desc')
            ->get();
            
        $totalDistance = $trips->sum('distance_km');
        $totalTrips = $trips->count();
        
        return view('fleet.reports.trip-summary', compact('trips', 'totalDistance', 'totalTrips'));
    }
}
