 <table>
     <thead>
         <tr>
             <th style="width:80px;">Student number</th>
             <th style="width:100px;">Student Names</th>
             <th style="width:100px;">Center</th>
             <th style="width:50px;">Student Contact</th>
             <th style="width:250px;">Guardian Information</th>
             <th style="width:50px;">Registration Status</th>
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
                 @foreach($registration->student->guardian as $guardian)
                 {{$guardian->guardian_names}} {{$guardian->surname}} ({{$guardian->relationship}}) - {{$guardian->contact_number}} <br>
                 @endforeach
             </td>
             <td>{{$registration->registration_status}}</td>
             <td>{{$registration->tuition_fees}}</td>
             <td>{{$registration->other_fees}}</td>
             <td>{{$registration->payable_amount}}</td>
             <td>{{$registration->course_balance}}</td>
         </tr>
         @endforeach
         <tr>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th>{{$registrations->sum('tuition_fees')}}</th>
             <th>{{$registrations->sum('other_fees')}}</th>
             <th>{{$registrations->sum('payable_amount')}}</th>
             <th>{{$registrations->sum('course_balance')}}</th>
         </tr>
     </tbody>
 </table>