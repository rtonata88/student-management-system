  <table>
      <thead>
          <tr>
              <th>Student number</th>
              <th>Names</th>
              <th>Center</th>
              <th>Subject</th>
              <th>Registration Status</th>
              <th>Registration Date</th>
              <th>Cancellation Date</th>
              <th>Cancellation Reason</th>
              <th>Guardian</th>
          </tr>
      </thead>
      <tbody>
          @foreach($subject_registration as $registration)

          <tr>
              <td style="width:100px">{{$registration->student->student_number2}}</td>
              <td style="width:200px">{{$registration->student->student_names}} {{$registration->student->surname}}</td>
              <td style="width:100px">
                  {{$registration->registration
                                ->where('student_id', $registration->student_id)
                                ->first()
                                ->center
                                ->center_name}}
              </td>
              <td style="width:200px">{{$registration->subject->subject_name}}</td>
              <td style="width:100px">{{$registration->registration_status}}</td>
              <td style="width:100px">{{$registration->registration_date}}</td>
              <td style="width:100px">{{$registration->cancellation_date}}</td>
              <td style="width:400px">{{$registration->cancellation_reason}}</td>
              <td style="width:400px">
                  @foreach($registration->student->guardian as $index => $guardian)
                  {{$guardian->guardian_names}}
                  {{$guardian->surname}}
                  ({{$guardian->relationship}}) -
                  {{$guardian->contact_number}}
                  @if($index < (count($registration->student->guardian) - 1))
                      <br>
                      @endif
                      @endforeach
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>