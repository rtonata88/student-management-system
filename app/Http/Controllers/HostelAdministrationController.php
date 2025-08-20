<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hostel;
use App\HostelBlock;
use App\HostelRoom;
use App\HostelBed;
use App\HostelAllocation;
use App\HostelFeeStructure;
use App\HostelPayment;
use App\HostelMaintenance;
use App\HostelVisitor;
use App\User;
use Illuminate\Support\Facades\DB;

class HostelAdministrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hostel-administration');
    }

    public function index()
    {
        $hostels = Hostel::with(['blocks', 'rooms', 'beds'])->get();
        $totalHostels = $hostels->count();
        $totalRooms = HostelRoom::count();
        $totalBeds = HostelBed::count();
        $occupiedBeds = HostelBed::where('status', 'occupied')->count();
        $availableBeds = HostelBed::where('status', 'available')->count();
        $activeAllocations = HostelAllocation::where('status', 'active')->count();
        
        $occupancyRate = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 2) : 0;

        return view('hostel.administration.index', compact(
            'hostels', 'totalHostels', 'totalRooms', 'totalBeds', 
            'occupiedBeds', 'availableBeds', 'activeAllocations', 'occupancyRate'
        ));
    }

    // Hostel Management
    public function hostels()
    {
        $hostels = Hostel::with(['blocks', 'rooms', 'beds'])->get();
        return view('hostel.administration.hostels', compact('hostels'));
    }

    public function createHostel()
    {
        return view('hostel.administration.create-hostel');
    }

    public function storeHostel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:hostels',
            'address' => 'required|string',
            'gender' => 'required|in:male,female,mixed',
            'total_capacity' => 'required|integer|min:1',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'warden_name' => 'nullable|string|max:255',
            'warden_phone' => 'nullable|string|max:20'
        ]);

        Hostel::create($request->all());
        
        return redirect()->route('hostel.administration.hostels')
                        ->with('success', 'Hostel created successfully.');
    }

    public function editHostel(Hostel $hostel)
    {
        return view('hostel.administration.edit-hostel', compact('hostel'));
    }

    public function updateHostel(Request $request, Hostel $hostel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:hostels,code,' . $hostel->id,
            'address' => 'required|string',
            'gender' => 'required|in:male,female,mixed',
            'total_capacity' => 'required|integer|min:1',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'warden_name' => 'nullable|string|max:255',
            'warden_phone' => 'nullable|string|max:20'
        ]);

        $hostel->update($request->all());
        
        return redirect()->route('hostel.administration.hostels')
                        ->with('success', 'Hostel updated successfully.');
    }

    // Block Management
    public function blocks($hostelId = null)
    {
        $query = HostelBlock::with(['hostel', 'rooms']);
        
        if ($hostelId) {
            $query->where('hostel_id', $hostelId);
        }
        
        $blocks = $query->get();
        $hostels = Hostel::active()->get();
        
        return view('hostel.administration.blocks', compact('blocks', 'hostels', 'hostelId'));
    }

    public function createBlock()
    {
        $hostels = Hostel::active()->get();
        return view('hostel.administration.create-block', compact('hostels'));
    }

    public function storeBlock(Request $request)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'floor_count' => 'required|integer|min:1',
            'gender' => 'required|in:male,female,mixed'
        ]);

        // Check unique code within hostel
        $exists = HostelBlock::where('hostel_id', $request->hostel_id)
                            ->where('code', $request->code)
                            ->exists();
        
        if ($exists) {
            return back()->withErrors(['code' => 'Block code already exists in this hostel.']);
        }

        HostelBlock::create($request->all());
        
        return redirect()->route('hostel.administration.blocks')
                        ->with('success', 'Block created successfully.');
    }

    // Room Management
    public function rooms($blockId = null)
    {
        $query = HostelRoom::with(['hostel', 'block', 'beds']);
        
        if ($blockId) {
            $query->where('block_id', $blockId);
        }
        
        $rooms = $query->get();
        $blocks = HostelBlock::with('hostel')->get();
        
        return view('hostel.administration.rooms', compact('rooms', 'blocks', 'blockId'));
    }

    public function createRoom()
    {
        $hostels = Hostel::active()->get();
        $blocks = HostelBlock::with('hostel')->get();
        return view('hostel.administration.create-room', compact('hostels', 'blocks'));
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'block_id' => 'required|exists:hostel_blocks,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:50',
            'floor_number' => 'required|integer|min:1',
            'bed_capacity' => 'required|integer|min:1',
            'room_fee' => 'required|numeric|min:0'
        ]);

        // Check unique room number within block
        $exists = HostelRoom::where('hostel_id', $request->hostel_id)
                           ->where('block_id', $request->block_id)
                           ->where('room_number', $request->room_number)
                           ->exists();
        
        if ($exists) {
            return back()->withErrors(['room_number' => 'Room number already exists in this block.']);
        }

        $room = HostelRoom::create($request->all());
        
        // Auto-create beds for the room
        for ($i = 1; $i <= $request->bed_capacity; $i++) {
            HostelBed::create([
                'hostel_id' => $request->hostel_id,
                'block_id' => $request->block_id,
                'room_id' => $room->id,
                'bed_number' => $i,
                'bed_type' => 'single',
                'bed_fee' => $request->room_fee / $request->bed_capacity,
                'status' => 'available'
            ]);
        }
        
        return redirect()->route('hostel.administration.rooms')
                        ->with('success', 'Room and beds created successfully.');
    }

    // Bed Management
    public function beds($roomId = null)
    {
        $query = HostelBed::with(['hostel', 'block', 'room', 'allocation.student']);
        
        if ($roomId) {
            $query->where('room_id', $roomId);
        }
        
        $beds = $query->get();
        $rooms = HostelRoom::with(['hostel', 'block'])->get();
        
        return view('hostel.administration.beds', compact('beds', 'rooms', 'roomId'));
    }

    // Student Allocation
    public function allocations()
    {
        $allocations = HostelAllocation::with(['student', 'hostel', 'block', 'room', 'bed'])
                                     ->orderBy('created_at', 'desc')
                                     ->get();
        
        return view('hostel.administration.allocations', compact('allocations'));
    }

    public function createAllocation()
    {
        $students = \App\Student::orderBy('surname')->orderBy('student_names')->get();
        
        $availableBeds = HostelBed::with(['hostel', 'block', 'room'])
                                 ->where('status', 'available')
                                 ->get();
        
        return view('hostel.administration.create-allocation', compact('students', 'availableBeds'));
    }

    public function storeAllocation(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'bed_id' => 'required|exists:hostel_beds,id',
            'allocation_date' => 'required|date',
            'monthly_fee' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0'
        ]);

        $bed = HostelBed::findOrFail($request->bed_id);
        
        if ($bed->status !== 'available') {
            return back()->withErrors(['bed_id' => 'Selected bed is not available.']);
        }

        DB::transaction(function () use ($request, $bed) {
            // Create allocation
            $allocation = HostelAllocation::create([
                'student_id' => $request->student_id,
                'hostel_id' => $bed->hostel_id,
                'block_id' => $bed->block_id,
                'room_id' => $bed->room_id,
                'bed_id' => $bed->id,
                'allocation_date' => $request->allocation_date,
                'expected_checkout_date' => $request->expected_checkout_date,
                'monthly_fee' => $request->monthly_fee,
                'security_deposit' => $request->security_deposit,
                'status' => 'active',
                'allocated_by' => auth()->id(),
                'remarks' => $request->remarks
            ]);

            // Create security deposit payment record
            if ($request->security_deposit > 0) {
                HostelPayment::create([
                    'allocation_id' => $allocation->id,
                    'student_id' => $request->student_id,
                    'payment_type' => 'security_deposit',
                    'amount' => $request->security_deposit,
                    'due_date' => $request->allocation_date,
                    'status' => 'pending'
                ]);
            }

            // Generate monthly payment records
            $allocation->generateMonthlyPayments();

            // Update bed status
            $bed->update(['status' => 'occupied']);
            
            // Update room occupied beds count
            $bed->room->increment('occupied_beds');
        });
        
        return redirect()->route('hostel.administration.allocations')
                        ->with('success', 'Student allocated successfully.');
    }

    // Fee Structure Management
    public function feeStructures()
    {
        $feeStructures = HostelFeeStructure::with('hostel')->get();
        $hostels = Hostel::active()->get();
        
        return view('hostel.administration.fee-structures', compact('feeStructures', 'hostels'));
    }

    // Payment Management
    public function payments()
    {
        $payments = HostelPayment::with(['student', 'allocation.hostel'])
                                ->orderBy('due_date', 'desc')
                                ->get();
        
        return view('hostel.administration.payments', compact('payments'));
    }

    public function recordPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:hostel_payments,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_reference' => 'nullable|string',
            'payment_date' => 'required|date'
        ]);

        $payment = HostelPayment::findOrFail($request->payment_id);
        
        $payment->update([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'payment_date' => $request->payment_date,
            'status' => 'paid',
            'received_by' => auth()->id()
        ]);

        return redirect()->route('hostel.administration.payments')
                        ->with('success', 'Payment recorded successfully.');
    }

    public function createPayment()
    {
        $allocations = HostelAllocation::with(['student', 'hostel', 'room'])
                                     ->where('status', 'active')
                                     ->get();
        
        return view('hostel.administration.create-payment', compact('allocations'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'allocation_id' => 'required|exists:hostel_allocations,id',
            'payment_type' => 'required|in:monthly_fee,security_deposit,maintenance,fine,other',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_reference' => 'nullable|string',
            'payment_date' => 'required|date',
            'due_date' => 'nullable|date'
        ]);

        $allocation = HostelAllocation::findOrFail($request->allocation_id);

        HostelPayment::create([
            'allocation_id' => $allocation->id,
            'student_id' => $allocation->student_id,
            'payment_type' => $request->payment_type,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'payment_date' => $request->payment_date,
            'due_date' => $request->due_date ?: $request->payment_date,
            'status' => 'paid',
            'received_by' => auth()->id()
        ]);

        return redirect()->route('hostel.administration.payments')
                        ->with('success', 'Payment recorded successfully.');
    }

    // Maintenance Management
    public function maintenance()
    {
        $maintenanceRecords = HostelMaintenance::with(['hostel', 'block', 'room', 'reportedBy', 'assignedTo'])
                                             ->orderBy('created_at', 'desc')
                                             ->get();
        
        return view('hostel.administration.maintenance', compact('maintenanceRecords'));
    }

    // Visitor Management
    public function visitors()
    {
        $visitors = HostelVisitor::with(['student', 'hostel', 'approvedBy'])
                                ->orderBy('visit_date', 'desc')
                                ->get();
        
        return view('hostel.administration.visitors', compact('visitors'));
    }

    // Reports
    public function reports()
    {
        $occupancyData = DB::table('hostels')
            ->leftJoin('hostel_beds', 'hostels.id', '=', 'hostel_beds.hostel_id')
            ->select('hostels.name', 
                    DB::raw('COUNT(hostel_beds.id) as total_beds'),
                    DB::raw('SUM(CASE WHEN hostel_beds.status = "occupied" THEN 1 ELSE 0 END) as occupied_beds'))
            ->groupBy('hostels.id', 'hostels.name')
            ->get();

        $revenueData = DB::table('hostel_payments')
            ->where('status', 'paid')
            ->whereYear('payment_date', date('Y'))
            ->select(DB::raw('MONTH(payment_date) as month'), 
                    DB::raw('SUM(amount) as total_amount'))
            ->groupBy('month')
            ->get();

        return view('hostel.administration.reports', compact('occupancyData', 'revenueData'));
    }
}
