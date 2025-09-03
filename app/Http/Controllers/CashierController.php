<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\CashierPayment;
use App\Payment;
use App\Invoice;
use App\AcademicYear;
use App\CompanySetup;
use App\Services\StudentBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CashierController extends Controller
{
    /**
     * Display the cashier search interface
     */
    public function index()
    {
        return view('cashier.index');
    }

    /**
     * Search for students
     */
    public function search(Request $request, StudentBalance $studentBalance)
    {
        $validator = Validator::make($request->all(), [
            'student_number' => 'nullable|string',
            'names' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $query = Student::with('center');

        // Search by student number (both student_number and student_number2)
        if ($request->filled('student_number')) {
            $studentNumber = $request->student_number;
            $query->where(function($q) use ($studentNumber) {
                $q->where('student_number', 'LIKE', "%{$studentNumber}%")
                  ->orWhere('student_number2', 'LIKE', "%{$studentNumber}%");
            });
        }

        // Search by names (first name or surname)
        if ($request->filled('names')) {
            $names = $request->names;
            $query->where(function($q) use ($names) {
                $q->where('student_names', 'LIKE', "%{$names}%")
                  ->orWhere('surname', 'LIKE', "%{$names}%");
            });
        }

        // Ensure at least one search criteria is provided
        if (!$request->filled('student_number') && !$request->filled('names')) {
            return redirect()->back()
                ->with('message', 'Please provide either a student number or name to search.')
                ->withInput();
        }

        $students = $query->limit(50)->get();

        if ($students->isEmpty()) {
            return redirect()->back()
                ->with('message', 'No students found matching your search criteria.')
                ->withInput();
        }

        // Get current academic year for balance calculation
        $academic_year = AcademicYear::where('status', 1)->first();
        $current_year = $academic_year ? $academic_year->academic_year : null;

        // Calculate balance for each student
        foreach ($students as $student) {
            if ($current_year) {
                $student->balance = $studentBalance->calculateBalance($current_year, $student->id);
            } else {
                $student->balance = 0;
            }
        }

        return view('cashier.index', compact('students'));
    }

    /**
     * Show payment form for selected student
     */
    public function paymentForm($studentId)
    {
        $student = Student::with('center')->findOrFail($studentId);
        
        // Get student's recent payments for reference
        $recentPayments = CashierPayment::where('student_id', $studentId)
            ->with('cashier')
            ->orderBy('payment_date', 'desc')
            ->limit(5)
            ->get();

        return view('cashier.payment-form', compact('student', 'recentPayments'));
    }

    /**
     * Process the payment
     */
    public function processPayment(Request $request, $studentId)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'payment_method' => 'required|in:Cash,Card,Bank Transfer,Mobile Money,Cheque',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Student::findOrFail($studentId);
        $academic_year = AcademicYear::where('status', 1)->first()->academic_year;

        try {
            DB::beginTransaction();

            // Create cashier payment record
            $cashierPayment = CashierPayment::create([
                'student_id' => $studentId,
                'receipt_number' => CashierPayment::generateReceiptNumber(),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'cashier_id' => Auth::id(),
                'payment_date' => now(),
            ]);

            // Also create a regular payment record to update student statement
            $payment = Payment::create([
                'student_id' => $studentId,
                'payment_amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'receipt_number' => $cashierPayment->receipt_number,
                'payment_date' => now(),
                'received_by' => Auth::id(),
            ]);

            // Create Invoice record to update student financial statement
            Invoice::create([
                'student_id' => $studentId,
                'reference_number' => $cashierPayment->receipt_number,
                'model' => "CashierPayment",
                'model_id' => $cashierPayment->id,
                'financial_year' => $academic_year,
                'transaction_date' => now(),
                'line_description' => "Cashier Payment - " . $request->payment_method,
                'debit_amount' => 0,
                'credit_amount' => $request->amount
            ]);

            DB::commit();

            return redirect()->route('cashier.receipt', $cashierPayment->id)
                ->with('success', 'Payment processed successfully! Receipt generated.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error processing payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display payment receipt
     */
    public function receipt($paymentId)
    {
        $payment = CashierPayment::with(['student.center', 'cashier'])
            ->findOrFail($paymentId);

        return view('cashier.receipt', compact('payment'));
    }

    /**
     * Print receipt (same view but with print-friendly styling)
     */
    public function printReceipt($paymentId)
    {
        $payment = CashierPayment::with(['student.center', 'cashier'])
            ->findOrFail($paymentId);
        
        $company = CompanySetup::find(1);

        return view('cashier.print-receipt', compact('payment', 'company'));
    }

    /**
     * Get payment history for a student (AJAX)
     */
    public function paymentHistory($studentId)
    {
        $payments = CashierPayment::where('student_id', $studentId)
            ->with('cashier')
            ->orderBy('payment_date', 'desc')
            ->get();

        return response()->json($payments);
    }
}
