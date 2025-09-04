<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollPeriod;
use App\Models\PayrollItem;
use App\Models\EmployeePayrollSetting;
use App\Models\PaySlip;
use App\Models\PayrollReport;
use App\User;
use App\CompanySetup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PDF;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access-payroll-system');
    }

    // Dashboard
    public function index()
    {
        $this->middleware('permission:view-payroll-dashboard');
        
        $stats = [
            'total_employees' => EmployeePayrollSetting::active()->count(),
            'active_periods' => PayrollPeriod::where('status', 'processing')->count(),
            'pending_approvals' => PaySlip::where('status', 'draft')->count(),
            'completed_periods' => PayrollPeriod::where('status', 'completed')->count()
        ];

        $recentPeriods = PayrollPeriod::with('createdBy')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pendingPaySlips = PaySlip::with(['employee', 'payrollPeriod'])
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('payroll.index', compact('stats', 'recentPeriods', 'pendingPaySlips'));
    }

    // Payroll Periods
    public function periods(Request $request)
    {
        $this->middleware('permission:view-payroll-periods');
        
        $query = PayrollPeriod::with('createdBy');
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('period_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $periods = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('payroll.periods.index', compact('periods'));
    }

    public function createPeriod()
    {
        $this->middleware('permission:create-payroll-periods');
        return view('payroll.periods.create');
    }

    public function storePeriod(Request $request)
    {
        $this->middleware('permission:create-payroll-periods');
        
        $request->validate([
            'period_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pay_date' => 'required|date|after_or_equal:end_date',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            PayrollPeriod::create([
                'period_name' => $request->period_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'pay_date' => $request->pay_date,
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('payroll.periods')->with('success', 'Payroll period created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating payroll period: ' . $e->getMessage());
        }
    }

    public function editPeriod(PayrollPeriod $period)
    {
        $this->middleware('permission:edit-payroll-periods');
        return view('payroll.periods.edit', compact('period'));
    }

    public function updatePeriod(Request $request, PayrollPeriod $period)
    {
        $this->middleware('permission:edit-payroll-periods');
        
        $request->validate([
            'period_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pay_date' => 'required|date|after_or_equal:end_date',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $period->update([
                'period_name' => $request->period_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'pay_date' => $request->pay_date,
                'description' => $request->description,
                'updated_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('payroll.periods')->with('success', 'Payroll period updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating payroll period: ' . $e->getMessage());
        }
    }

    public function deletePeriod(PayrollPeriod $period)
    {
        $this->middleware('permission:delete-payroll-periods');
        
        if (!$period->canBeDeleted()) {
            return back()->with('error', 'Cannot delete a period that is not in draft status.');
        }

        try {
            DB::beginTransaction();
            $period->delete();
            DB::commit();
            return redirect()->route('payroll.periods')->with('success', 'Payroll period deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error deleting payroll period: ' . $e->getMessage());
        }
    }

    // Employee Payroll Settings
    public function employees(Request $request)
    {
        $this->middleware('permission:view-employee-payroll');
        
        $query = EmployeePayrollSetting::with('user');
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('employee_number', 'like', "%{$search}%")
                  ->orWhere('basic_salary', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $employees = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('payroll.employees.index', compact('employees'));
    }

    public function createEmployee()
    {
        $this->middleware('permission:edit-employee-payroll');
        
        // Only show active staff with complete employee profiles
        $users = User::where('user_type', 'staff')
                    ->whereHas('employeeProfile', function($query) {
                        $query->where('is_active', true)
                              ->whereNotNull('employee_number')
                              ->whereNotNull('salary')
                              ->whereNotNull('bank_name')
                              ->whereNotNull('account_number');
                    })
                    ->whereDoesntHave('employeePayrollSetting')
                    ->with('employeeProfile')
                    ->get();
        return view('payroll.employees.create', compact('users'));
    }

    public function storeEmployee(Request $request)
    {
        $this->middleware('permission:edit-employee-payroll');
        
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employee_payroll_settings,user_id',
            'employee_number' => 'required|string|unique:employee_payroll_settings,employee_number',
            'basic_salary' => 'required|numeric|min:0',
            'pay_frequency' => 'required|in:monthly,bi-weekly,weekly',
            'bank_name' => 'nullable|string',
            'bank_branch' => 'nullable|string',
            'account_number' => 'nullable|string',
            'account_type' => 'nullable|string',
            'tax_number' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100'
        ]);

        try {
            DB::beginTransaction();

            EmployeePayrollSetting::create([
                'user_id' => $request->user_id,
                'employee_number' => $request->employee_number,
                'basic_salary' => $request->basic_salary,
                'pay_frequency' => $request->pay_frequency,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'account_number' => $request->account_number,
                'account_type' => $request->account_type,
                'tax_number' => $request->tax_number,
                'tax_rate' => $request->tax_rate ?? 25,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('payroll.employees')->with('success', 'Employee payroll settings created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating employee settings: ' . $e->getMessage());
        }
    }

    public function editEmployee(EmployeePayrollSetting $employee)
    {
        $this->middleware('permission:edit-employee-payroll');
        return view('payroll.employees.edit', compact('employee'));
    }

    public function updateEmployee(Request $request, EmployeePayrollSetting $employee)
    {
        $this->middleware('permission:edit-employee-payroll');
        
        $request->validate([
            'employee_number' => 'required|string|unique:employee_payroll_settings,employee_number,' . $employee->id,
            'basic_salary' => 'required|numeric|min:0',
            'pay_frequency' => 'required|in:monthly,bi-weekly,weekly',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'account_type' => 'nullable|string',
            'tax_number' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100'
        ]);

        try {
            DB::beginTransaction();

            $employee->update([
                'employee_number' => $request->employee_number,
                'basic_salary' => $request->basic_salary,
                'pay_frequency' => $request->pay_frequency,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_type' => $request->account_type,
                'tax_number' => $request->tax_number,
                'tax_rate' => $request->tax_rate ?? 0,
                'updated_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('payroll.employees')->with('success', 'Employee payroll settings updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating employee settings: ' . $e->getMessage());
        }
    }

    // Payroll Processing
    public function processPeriod(PayrollPeriod $period)
    {
        $this->middleware('permission:process-payroll');
        
        if (!$period->canBeProcessed()) {
            return back()->with('error', 'This period cannot be processed.');
        }

        try {
            DB::beginTransaction();

            $employees = EmployeePayrollSetting::active()->get();
            
            foreach ($employees as $employee) {
                $this->generatePaySlip($period, $employee);
            }

            $period->update(['status' => 'processing']);
            $period->calculateTotals();

            DB::commit();
            return redirect()->route('payroll.periods')->with('success', 'Payroll processed successfully for ' . $employees->count() . ' employees.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error processing payroll: ' . $e->getMessage());
        }
    }

    private function generatePaySlip(PayrollPeriod $period, EmployeePayrollSetting $employee)
    {
        // Check if pay slip already exists
        $existingSlip = PaySlip::where('payroll_period_id', $period->id)
            ->where('user_id', $employee->user_id)
            ->first();

        if ($existingSlip) {
            return $existingSlip;
        }

        $basicSalary = $employee->basic_salary;
        $totalAllowances = $employee->getTotalAllowancesAttribute();
        $grossPay = $basicSalary + $totalAllowances;
        $taxAmount = $employee->calculateTaxAmount($grossPay);
        $totalDeductions = $employee->getTotalDeductionsAttribute();
        $netPay = $grossPay - $totalDeductions - $taxAmount;

        return PaySlip::create([
            'payroll_period_id' => $period->id,
            'user_id' => $employee->user_id,
            'slip_number' => PaySlip::generateSlipNumber($period->id),
            'basic_salary' => $basicSalary,
            'gross_pay' => $grossPay,
            'total_allowances' => $totalAllowances,
            'total_deductions' => $totalDeductions,
            'tax_amount' => $taxAmount,
            'net_pay' => $netPay,
            'earnings_breakdown' => $employee->allowances ?? [],
            'deductions_breakdown' => $employee->deductions ?? [],
            'created_by' => Auth::id()
        ]);
    }

    // Pay Slips
    public function paySlips(Request $request)
    {
        $this->middleware('permission:view-pay-slips');
        
        $query = PaySlip::with(['employee', 'payrollPeriod']);

        if ($request->period_id) {
            $query->where('payroll_period_id', $request->period_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $paySlips = $query->orderBy('created_at', 'desc')->paginate(15);
        $periods = PayrollPeriod::orderBy('created_at', 'desc')->get();

        return view('payroll.pay-slips.index', compact('paySlips', 'periods'));
    }

    public function showPaySlip(PaySlip $paySlip)
    {
        $this->middleware('permission:view-pay-slips');
        
        $company = CompanySetup::first();
        return view('payroll.pay-slips.show', compact('paySlip', 'company'));
    }

    public function printPaySlip(PaySlip $paySlip)
    {
        $this->middleware('permission:print-pay-slips');
        
        $company = CompanySetup::first();
        return view('payroll.pay-slips.print', compact('paySlip', 'company'));
    }

    public function downloadPaySlip(PaySlip $paySlip)
    {
        $this->middleware('permission:download-pay-slips');
        
        $company = CompanySetup::first();
        $pdf = PDF::loadView('payroll.pay-slips.print', compact('paySlip', 'company'));
        
        return $pdf->download('payslip-' . $paySlip->slip_number . '.pdf');
    }

    public function approvePaySlip(PaySlip $paySlip)
    {
        $this->middleware('permission:approve-pay-slips');
        
        if (!$paySlip->canBeApproved()) {
            return back()->with('error', 'This pay slip cannot be approved.');
        }

        try {
            DB::beginTransaction();
            $paySlip->approve(Auth::id());
            DB::commit();
            return back()->with('success', 'Pay slip approved successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error approving pay slip: ' . $e->getMessage());
        }
    }

    // Payroll Items
    public function items()
    {
        $this->middleware('permission:view-payroll-items');
        
        $items = PayrollItem::with('createdBy')
            ->orderBy('item_type')
            ->orderBy('item_name')
            ->paginate(15);

        return view('payroll.items.index', compact('items'));
    }

    public function createItem()
    {
        $this->middleware('permission:create-payroll-items');
        return view('payroll.items.create');
    }

    public function storeItem(Request $request)
    {
        $this->middleware('permission:create-payroll-items');
        
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|unique:payroll_items,item_code',
            'item_type' => 'required|in:earning,deduction,allowance,tax',
            'calculation_method' => 'required|in:fixed,percentage,hourly,formula',
            'default_amount' => 'nullable|numeric|min:0',
            'percentage_rate' => 'nullable|numeric|min:0|max:100',
            'formula' => 'nullable|string',
            'is_taxable' => 'boolean',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            PayrollItem::create([
                'item_name' => $request->item_name,
                'item_code' => strtoupper($request->item_code),
                'item_type' => $request->item_type,
                'calculation_method' => $request->calculation_method,
                'default_amount' => $request->default_amount,
                'percentage_rate' => $request->percentage_rate,
                'formula' => $request->formula,
                'is_taxable' => $request->has('is_taxable'),
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('payroll.items')->with('success', 'Payroll item created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating payroll item: ' . $e->getMessage());
        }
    }

    public function editItem(PayrollItem $item)
    {
        $this->middleware('permission:edit-payroll-items');
        return view('payroll.items.edit', compact('item'));
    }

    public function updateItem(Request $request, PayrollItem $item)
    {
        $this->middleware('permission:edit-payroll-items');
        
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|unique:payroll_items,item_code,' . $item->id,
            'item_type' => 'required|in:earning,deduction,allowance,tax',
            'calculation_method' => 'required|in:fixed,percentage,hourly,formula',
            'default_amount' => 'nullable|numeric|min:0',
            'percentage_rate' => 'nullable|numeric|min:0|max:100',
            'formula' => 'nullable|string',
            'is_taxable' => 'boolean',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $item->update([
                'item_name' => $request->item_name,
                'item_code' => strtoupper($request->item_code),
                'item_type' => $request->item_type,
                'calculation_method' => $request->calculation_method,
                'default_amount' => $request->default_amount,
                'percentage_rate' => $request->percentage_rate,
                'formula' => $request->formula,
                'is_taxable' => $request->has('is_taxable'),
                'description' => $request->description,
                'updated_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('payroll.items')->with('success', 'Payroll item updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating payroll item: ' . $e->getMessage());
        }
    }

    public function deleteItem(PayrollItem $item)
    {
        $this->middleware('permission:delete-payroll-items');
        
        try {
            DB::beginTransaction();
            $item->delete();
            DB::commit();
            return redirect()->route('payroll.items')->with('success', 'Payroll item deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error deleting payroll item: ' . $e->getMessage());
        }
    }

    // Reports
    public function reports()
    {
        $this->middleware('permission:view-payroll-reports');
        
        $reports = PayrollReport::with(['payrollPeriod', 'generatedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('payroll.reports.index', compact('reports'));
    }
}
