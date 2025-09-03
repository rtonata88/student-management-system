<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\CashierPayment;
use App\CompanySetup;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CapturedPaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the captured payments listing page
     */
    public function index()
    {
        return view('Finance.CapturedPayments.Index');
    }

    /**
     * Search and display captured payments
     */
    public function search(Request $request)
    {
        try {
            $query = $this->buildPaymentsQuery($request);
            $payments = $query->paginate(20);

            // Handle AJAX requests
            if ($request->ajax() || $request->has('ajax') || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                try {
                    $html = view('Finance.CapturedPayments.ResultsPartial', compact('payments', 'request'))->render();
                    return response()->json([
                        'html' => $html,
                        'total' => $payments->total(),
                        'success' => true
                    ]);
                } catch (\Exception $viewException) {
                    return response()->json([
                        'error' => true,
                        'message' => 'View rendering error: ' . $viewException->getMessage(),
                        'html' => '<div class="alert alert-danger">Error rendering results view.</div>',
                        'total' => 0
                    ]);
                }
            }

            return view('Finance.CapturedPayments.Results', compact('payments', 'request'));
        } catch (\Exception $e) {
            if ($request->ajax() || $request->has('ajax') || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'html' => '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>',
                    'total' => 0
                ]);
            }
            throw $e;
        }
    }

    /**
     * Build the unified payments query from both tables
     */
    private function buildPaymentsQuery(Request $request)
    {
        // Get cashier payments
        $cashierPayments = CashierPayment::select([
            'id',
            'student_id',
            'receipt_number',
            'amount as payment_amount',
            'payment_method',
            'reference_number',
            'notes',
            'payment_date',
            'cashier_id as received_by',
            'created_at',
            DB::raw("'Cashier' as payment_source")
        ])
        ->with(['student', 'cashier']);

        // Apply filters to cashier payments
        if ($request->filled('student_search')) {
            $studentSearch = $request->student_search;
            $cashierPayments->whereHas('student', function($q) use ($studentSearch) {
                $q->where('student_names', 'LIKE', "%{$studentSearch}%")
                  ->orWhere('surname', 'LIKE', "%{$studentSearch}%")
                  ->orWhere('student_number', 'LIKE', "%{$studentSearch}%");
            });
        }

        if ($request->filled('receipt_number')) {
            $cashierPayments->where('receipt_number', 'LIKE', "%{$request->receipt_number}%");
        }

        if ($request->filled('reference_number')) {
            $cashierPayments->where('reference_number', 'LIKE', "%{$request->reference_number}%");
        }

        if ($request->filled('date_from')) {
            $cashierPayments->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $cashierPayments->whereDate('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('payment_method')) {
            $cashierPayments->where('payment_method', $request->payment_method);
        }

        // Apply quick search to cashier payments
        if ($request->filled('quick_search')) {
            $quickSearch = $request->quick_search;
            $cashierPayments->where(function($q) use ($quickSearch) {
                $q->where('receipt_number', 'LIKE', "%{$quickSearch}%")
                  ->orWhere('reference_number', 'LIKE', "%{$quickSearch}%")
                  ->orWhere('payment_method', 'LIKE', "%{$quickSearch}%")
                  ->orWhere('notes', 'LIKE', "%{$quickSearch}%")
                  ->orWhereHas('student', function($sq) use ($quickSearch) {
                      $sq->where('student_names', 'LIKE', "%{$quickSearch}%")
                        ->orWhere('surname', 'LIKE', "%{$quickSearch}%")
                        ->orWhere('student_number', 'LIKE', "%{$quickSearch}%");
                  })
                  ->orWhereHas('cashier', function($cq) use ($quickSearch) {
                      $cq->where('name', 'LIKE', "%{$quickSearch}%");
                  });
            });
        }

        // Get manual payments
        $manualPayments = Payment::select([
            'id',
            'student_id', 
            'receipt_number',
            'payment_amount',
            'payment_method',
            DB::raw('NULL as reference_number'),
            DB::raw('NULL as notes'),
            'payment_date',
            'received_by',
            'created_at',
            DB::raw("'Manual' as payment_source")
        ])
        ->with(['student', 'user']);

        // Apply filters to manual payments
        if ($request->filled('student_search')) {
            $studentSearch = $request->student_search;
            $manualPayments->whereHas('student', function($q) use ($studentSearch) {
                $q->where('student_names', 'LIKE', "%{$studentSearch}%")
                  ->orWhere('surname', 'LIKE', "%{$studentSearch}%")
                  ->orWhere('student_number', 'LIKE', "%{$studentSearch}%");
            });
        }

        if ($request->filled('receipt_number')) {
            $manualPayments->where('receipt_number', 'LIKE', "%{$request->receipt_number}%");
        }

        if ($request->filled('date_from')) {
            $manualPayments->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $manualPayments->whereDate('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('payment_method')) {
            $manualPayments->where('payment_method', $request->payment_method);
        }

        // Apply quick search to manual payments
        if ($request->filled('quick_search')) {
            $quickSearch = $request->quick_search;
            $manualPayments->where(function($q) use ($quickSearch) {
                $q->where('receipt_number', 'LIKE', "%{$quickSearch}%")
                  ->orWhere('payment_method', 'LIKE', "%{$quickSearch}%")
                  ->orWhere('document_type', 'LIKE', "%{$quickSearch}%")
                  ->orWhereHas('student', function($sq) use ($quickSearch) {
                      $sq->where('student_names', 'LIKE', "%{$quickSearch}%")
                        ->orWhere('surname', 'LIKE', "%{$quickSearch}%")
                        ->orWhere('student_number', 'LIKE', "%{$quickSearch}%");
                  })
                  ->orWhereHas('user', function($uq) use ($quickSearch) {
                      $uq->where('name', 'LIKE', "%{$quickSearch}%");
                  });
            });
        }

        if ($request->filled('payment_source')) {
            if ($request->payment_source === 'Cashier') {
                return $cashierPayments->orderBy('payment_date', 'desc');
            } elseif ($request->payment_source === 'Manual') {
                return $manualPayments->orderBy('payment_date', 'desc');
            }
        }

        // Union both queries and order by payment_date
        return $cashierPayments->union($manualPayments)->orderBy('payment_date', 'desc');
    }

    /**
     * Reprint receipt for a payment
     */
    public function reprintReceipt(Request $request)
    {
        $paymentSource = $request->payment_source;
        $paymentId = $request->payment_id;
        $company = CompanySetup::find(1);

        if ($paymentSource === 'Cashier') {
            $payment = CashierPayment::with(['student', 'cashier'])->findOrFail($paymentId);
            return view('Finance.CapturedPayments.CashierReceipt', compact('payment', 'company'));
        } else {
            $payment = Payment::with(['student', 'user'])->findOrFail($paymentId);
            return view('Finance.CapturedPayments.ManualReceipt', compact('payment', 'company'));
        }
    }

    /**
     * Export captured payments to Excel/CSV
     */
    public function export(Request $request)
    {
        $query = $this->buildPaymentsQuery($request);
        $payments = $query->get();

        $filename = 'captured_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Receipt Number',
                'Student Number',
                'Student Name',
                'Payment Amount',
                'Payment Method',
                'Reference Number',
                'Payment Date',
                'Payment Source',
                'Processed By',
                'Notes'
            ]);

            foreach ($payments as $payment) {
                $studentName = $payment->student ? 
                    $payment->student->student_names . ' ' . $payment->student->surname : 'N/A';
                
                $processedBy = $payment->payment_source === 'Cashier' ? 
                    ($payment->cashier ? $payment->cashier->name : 'N/A') :
                    ($payment->user ? $payment->user->name : 'N/A');

                fputcsv($file, [
                    $payment->receipt_number,
                    $payment->student ? $payment->student->student_number : 'N/A',
                    $studentName,
                    number_format($payment->payment_amount, 2),
                    $payment->payment_method,
                    $payment->reference_number ?? 'N/A',
                    $payment->payment_date ? $payment->payment_date->format('Y-m-d H:i:s') : 'N/A',
                    $payment->payment_source,
                    $processedBy,
                    $payment->notes ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Void a payment transaction
     */
    public function voidPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|integer',
            'payment_source' => 'required|in:Cashier,Manual',
            'void_reason' => 'required|string',
            'other_reason' => 'nullable|string|required_if:void_reason,Other'
        ]);

        try {
            DB::beginTransaction();

            $paymentId = $request->payment_id;
            $paymentSource = $request->payment_source;
            $voidReason = $request->void_reason;
            $otherReason = $request->other_reason;

            // Get the original payment
            if ($paymentSource === 'Cashier') {
                $payment = CashierPayment::with('student')->findOrFail($paymentId);
            } else {
                $payment = Payment::with('student')->findOrFail($paymentId);
            }

            // Check if payment is already voided
            $existingVoid = DB::table('voided_payments')
                ->where('original_payment_id', $paymentId)
                ->where('payment_source', $paymentSource)
                ->first();

            if ($existingVoid) {
                return redirect()->back()->with('error', 'This payment has already been voided.');
            }

            // Create void record
            DB::table('voided_payments')->insert([
                'original_payment_id' => $paymentId,
                'payment_source' => $paymentSource,
                'student_id' => $payment->student_id,
                'receipt_number' => $payment->receipt_number,
                'payment_amount' => $paymentSource === 'Cashier' ? $payment->amount : $payment->payment_amount,
                'payment_method' => $payment->payment_method,
                'reference_number' => $paymentSource === 'Cashier' ? $payment->reference_number : null,
                'notes' => $paymentSource === 'Cashier' ? $payment->notes : null,
                'original_payment_date' => $payment->payment_date,
                'original_received_by' => $paymentSource === 'Cashier' ? $payment->cashier_id : $payment->received_by,
                'void_reason' => $voidReason === 'Other' ? $otherReason : $voidReason,
                'other_reason' => $voidReason === 'Other' ? $otherReason : null,
                'voided_by' => auth()->id(),
                'voided_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Reverse the payment from student account
            $paymentAmount = $paymentSource === 'Cashier' ? $payment->amount : $payment->payment_amount;
            
            // Add a debit entry to reverse the payment
            StudentAccount::create([
                'student_id' => $payment->student_id,
                'transaction_type' => 'Void Payment',
                'description' => "Voided Payment - Receipt #{$payment->receipt_number} - Reason: " . ($voidReason === 'Other' ? $otherReason : $voidReason),
                'debit_amount' => $paymentAmount,
                'credit_amount' => 0,
                'balance' => 0, // Will be calculated by model
                'transaction_date' => now(),
                'reference_number' => $payment->receipt_number,
                'created_by' => auth()->id()
            ]);

            // Update the original payment status (if there's a status field)
            if ($paymentSource === 'Cashier') {
                // Add voided flag if the table supports it
                try {
                    $payment->update(['status' => 'voided']);
                } catch (\Exception $e) {
                    // If status column doesn't exist, continue without error
                }
            } else {
                try {
                    $payment->update(['status' => 'voided']);
                } catch (\Exception $e) {
                    // If status column doesn't exist, continue without error
                }
            }

            DB::commit();

            return redirect()->back()->with('success', "Payment #{$payment->receipt_number} has been successfully voided.");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error voiding payment: ' . $e->getMessage());
        }
    }
}
