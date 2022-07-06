 <table>
     <thead>
         <tr>
             <th style="width:80px;">Student number</th>
             <th style="width:100px;">Names</th>
             <th style="width:100px;">Surname</th>
             <th style="width:100px;">Center</th>
             <th style="width:50px;">Student Contact</th>
             <th style="width:250px;">Guardian Information</th>
             @foreach($modules as $subject)
             <th style="width:100px;"><strong>{{$subject->subject_name}}</strong></th>
             @endforeach
             <th style="width:100px;">Tuition Fees (N$)</th>
             <th style="width:100px;">Other fees (N$)</th>
             <th style="width:100px;">Total Payable (N$)</th>
             <th style="width:100px;">Course Balance (N$)</th>
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
             <td>{{$summary->student_names}}</td>
             <td>{{$summary->surname}}</td>
             <td>{{$centers[$summary->center_id]}}</td>
             <td></td>
             <td>
                 @foreach($guardians->where('student_id', $summary->student_id) as $index => $guardian)
                 <p>{{$guardian->guardian_names}} {{$guardian->surname}} ({{$guardian->relationship}}) - {{$guardian->contact_number}}</p>
                 @endforeach
             </td>
             @foreach($modules as $subject)
             <td>
                 @if($module_registrations->where('module_id', $subject->id)->where('student_id', $summary->student_id)->first())
                 Enrolled
                 @endif
             </td>
             @endforeach
             <td>{{$summary->tuition_fees_payable - $payment}}</td>
             <td>{{$other_fees}}</td>
             <td>{{$payable_amount}}</td>
             <td>{{$course_balance}}</td>
         </tr>
         @endforeach
     </tbody>
 </table>