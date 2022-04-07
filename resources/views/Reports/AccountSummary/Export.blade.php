 <table>
     <thead>
         <tr>
             <th style="width:80px;">Student number</th>
             <th style="width:100px;">Student Names</th>
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
         @foreach($registrations as $registration)
         <tr>
             <td>{{$registration->student->student_number2}}</td>
             <td>{{$registration->student->student_names}} {{$registration->student->surname}}</td>
             <td>{{$registration->center->center_name}}</td>
             <td>{{$registration->student->contact_number}}</td>
             <td>
                 @foreach($registration->student->guardian as $index => $guardian)
                 {{$guardian->guardian_names}} {{$guardian->surname}} ({{$guardian->relationship}}) - {{$guardian->contact_number}}
                 @if($index < (count($registration->student->guardian) - 1))
                     <br>
                     @endif
                     @endforeach
             </td>
             @foreach($modules as $subject)
             <td>
                 @if(in_array($subject->id, $registration->student->registered_modules->pluck("module_id")->toArray()))
                 Enrolled
                 @endif
             </td>
             @endforeach
             <td>{{$registration->tuition_fees}}</td>
             <td>{{$registration->other_fees}}</td>
             <td>{{$registration->payable_amount}}</td>
             <td>{{$registration->course_balance}}</td>
         </tr>
         @endforeach
     </tbody>
 </table>