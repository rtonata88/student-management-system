<table>
    <tr>
        <th style="width:150px; text-align: right;"><strong>Company Name:</strong></th>
        <th>{{ $company->company_name}}</th>
    </tr>
    <tr>
        <th style="width:150px; text-align: right;"><strong>Address:</strong></th>
        <th>{{ $company->address1 }}</th>
    </tr>
    <tr>
        <th></th>
        <th>{{ $company->address2 }}</th>
    </tr>
    <tr>
        <th></th>
        <th>{{ $company->address3 }}</th>
    </tr>
    <tr>
        <th><strong></strong></th>
        <th>{{ $company->address4n}}</th>
    </tr>
    <tr>
        <th style="width:150px; text-align: right;"><strong>Email:</strong></th>
        <th>{{ $company->email}}</th>
    </tr>
    <tr>
        <th style="width:150px; text-align: right;"><strong>Account Summary Date:</strong></th>
        <th>{{ date('Y-m-d H:i:s') }}</th>
    </tr>
</table>


<table style="font-size: 10px; font-family: Arial, sans-serif;">
    <thead>
        <tr style="border: 2px solid black;">
            <th style="width:80px;"><strong>STUDENT NUMBER</strong></th>
            <th style="width:100px;"><strong>NAMES</strong></th>
            <th style="width:100px;"><strong>SURNAME</strong></th>
            <th style="width:100px;"><strong>CENTER</strong></th>
            <th style="width:50px;"><strong>CONTACT NUMBER</strong></th>
            <th style="width:350px;"><strong>GUARDIANS</strong></th>
            <th style="width:100px;"><strong>TOTAL PAYABLE (N$)</strong></th>
            <th style="width:100px;"><strong>COURSE BALANCE (N$)</strong></th>
            <th style="width:100px;"><strong>TUITION FEES (N$)</strong></th>
            <th style="width:100px;"><strong>OTHER FEES (N$)</strong></th>
            @foreach($fees as $fee)
            <th style="width:100px; text-align: center;" colspan="2"><strong>{{strtoupper($fee->fee_description)}}</strong></th>
            @endforeach
            @foreach($modules as $subject)
            <th style="width:100px; text-align: center;"><strong>{{strtoupper($subject->subject_name)}}</strong></th>
            @endforeach

        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            @foreach($fees as $fee)
            <th style="width:100px; text-align: center;"><strong>PAID</strong></th>
            <th style="width:100px; text-align: center;"><strong>OUTSTANDING</strong></th>
            @endforeach
            @foreach($modules as $subject)
            <th></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($account_summary as $summary)
        <?php
        $payment = $payments->where('student_id', $summary->student_id)->first()->payments ?? 0;
        $other_fees = $extra_charges->where('student_id', $summary->student_id)->first()->outstanding ?? 0;
        $payable_amount = ($other_fees + $summary->tuition_fees_payable) - $payment;
        $debit = $invoices->where('student_id', $summary->student_id)->first()->debit ?? 0;
        $credit = $invoices->where('student_id', $summary->student_id)->first()->credit ?? 0;
        $course_balance = $debit - $credit;
        ?>
        <tr>
            <td>{{$summary->student_number2}}</td>
            <td>{{strtoupper($summary->student_names)}}</td>
            <td>{{strtoupper($summary->surname)}}</td>
            <td>{{strtoupper($centers[$summary->center_id])}}</td>
            <td>{{$summary->contact_number}}</td>
            <td>
                @foreach($guardians->where('student_id', $summary->student_id) as $index => $guardian)
                {{strtoupper($guardian->guardian_names)}} {{strtoupper($guardian->surname)}} ({{strtoupper($guardian->relationship)}}) - {{$guardian->contact_number}}
                @endforeach
            </td>
            <td>{{$payable_amount}}</td>
            <td>{{$course_balance}}</td>
            <td>{{$summary->tuition_fees_payable - $payment}}</td>
            <td>{{$other_fees}}</td>

            @foreach($fees as $fee)
            <td>
                <?php
                $fee_detail = $extra_charges_details->where('fee_id', $fee->id)->where('student_id', $summary->student_id)->first();
                ?>
                @if($fee_detail)
                {{$fee_detail->amount_paid}}
                @endif
            </td>
            <td>
                @if($fee_detail)
                {{$fee_detail->outstanding}}
                @endif
            </td>
            @endforeach
            @foreach($modules as $subject)
            <td>
                @if($module_registrations->where('module_id', $subject->id)->where('student_id', $summary->student_id)->first())
                X
                @endif
            </td>
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>