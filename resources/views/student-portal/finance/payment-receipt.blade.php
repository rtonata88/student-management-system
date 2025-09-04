@extends('layouts.print')
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3>{{$company->company_name ?? config('app.name', 'EDUCIMS TUTORIALS SYSTEM')}}</h3><br>
                                {{$company->address1 ?? 'Educational Institution'}} <br>
                                {{$company->address2 ?? 'P.O. Box 12345, City'}} <br>
                                {{$company->address3 ?? ''}} <br>
                                {{$company->address4 ?? ''}} <br>
                                <strong>C: </strong> {{$company->contact_number ?? '+123 456 7890'}} <br>
                                <strong>F: </strong>{{$company->fax ?? 'N/A'}} <br>
                                <strong>E: </strong>{{$company->email ?? 'info@educims.com'}} <br>
                            </td>
                            <td width="200px; margin-right:20px;">
                                <img src="{{asset('assets/Logo.png')}}" class="img-fluid" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4><strong>PAYMENT RECEIPT</strong></h4>
                    <h5>Receipt No: {{$payment->receipt_number}}</h5>
                </div>

                <!-- Student Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Student Information</strong></h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Student Number:</strong></td>
                                <td>{{$payment->student->student_number ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{$payment->student->student_names ?? 'N/A'}} {{$payment->student->surname ?? ''}}</td>
                            </tr>
                            <tr>
                                <td><strong>Center:</strong></td>
                                <td>{{$payment->student->center->center_name ?? 'N/A'}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Payment Information</strong></h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Payment Date:</strong></td>
                                <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Method:</strong></td>
                                <td>{{$payment->payment_method}}</td>
                            </tr>
                            @if($payment->reference_number)
                            <tr>
                                <td><strong>Reference Number:</strong></td>
                                <td>{{$payment->reference_number}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Payment Source:</strong></td>
                                <td>{{ $payment->payment_source ?? 'Manual Payment' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Processed By:</strong></td>
                                <td>
                                    @if($payment->payment_source === 'Cashier')
                                        {{$payment->cashier->name ?? 'N/A'}}
                                    @else
                                        {{$payment->user->name ?? 'N/A'}}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($payment->notes)
                <!-- Notes Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5><strong>Notes</strong></h5>
                        <p>{{$payment->notes}}</p>
                    </div>
                </div>
                @endif

                <!-- Payment Summary -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5><strong>Payment Summary</strong></h5>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Payment Received</td>
                                    <td class="text-right">N$ {{number_format($payment->payment_amount, 2)}}</td>
                                </tr>
                                <tr class="table-info">
                                    <td><strong>Total Amount Paid</strong></td>
                                    <td class="text-right"><strong>N$ {{number_format($payment->payment_amount, 2)}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <p class="text-muted">This is an official payment receipt generated on {{now()->format('d F Y \a\t H:i:s')}}</p>
                        <p class="text-muted">Please keep this receipt for your records</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-print when page loads
    window.onload = function() {
        window.print();
    }
</script>
@endsection
