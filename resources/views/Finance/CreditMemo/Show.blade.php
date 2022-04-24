@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item"><a href="/debit-memos">Credit Memo</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Credit Memo</strong> | <a href="{{route('credit-memos.index')}}">Search another student</a> | <a href="{{route('credit-memos.show', $student->id)}}"> Credit memos </a> | <a href="{{route('invoices.print', $student->id)}}" target="_blank">Print Invoice</a>
            </div>
            <div class="card-body">
                <table class="table-sm" style="width:100%">
                    <tr>
                        <th style="width: 150px">Student number </th>
                        <td>{{$student->student_number2}}</td>
                    </tr>
                    <tr>
                        <th style="width: 150px">Student names </th>
                        <td>{{$student->student_names}}</td>
                    </tr>
                    <tr>
                        <th style="width: 150px">Surname </th>
                        <td>{{$student->surname}}</td>
                    </tr>
                    <tr>
                        <th style="width: 100px">Date of Birth</th>
                        <td>{{$student->date_of_birth}}</td>
                    </tr>

                </table>

                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th>Transaction Date</th>
                        <th>Credit Type</th>
                        <th>Subject name/Extra charge fee</th>
                        <th>Reason</th>
                        <th>Captured by</th>
                        <th>Amount</th>
                    </tr>
                    @foreach($credit_memos as $credit_memo)
                    <tr>
                        <td>{{$credit_memo->transaction_date}}</td>
                        <td>{{ucwords($credit_memo->credit_type)}}</td>
                        <td>
                            @if($credit_memo->credit_type == 'tuition')
                            {{$subjects->where('id', $credit_memo->model_id)->first()->subject_name}}
                            @else
                            {{$other_fees->where('id', $credit_memo->model_id)->first()->fee_description}}
                            @endif
                        </td>
                        <td>{{$credit_memo->reason}}</td>
                        <td>{{$credit_memo->user->name}}</td>
                        <td>{{$credit_memo->amount}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th>{{number_format($credit_memos->sum('amount'), 2, '.',',')}}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection