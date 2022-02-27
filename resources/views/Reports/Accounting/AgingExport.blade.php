  <table>
      <thead>
          <tr>
              <th>Student number</th>
              <th>Names</th>
              <th>Contact number</th>
              <th>Guardian</th>
              <th>30 Days</th>
              <th>60 Days</th>
              <th>90 Days +</th>
              <th>Total Arrears</th>
          </tr>
      </thead>
      <tbody>
          @foreach($registered_students as $registered_student)
          <?php
            $_30days += $aging_report[$registered_student->student_id]["30"];
            $_60days += $aging_report[$registered_student->student_id]["60"];
            $_90days += $aging_report[$registered_student->student_id]["90"];
            ?>
          <tr>
              <td>{{$registered_student->student->student_number2}}</td>
              <td>{{$registered_student->student->student_names}} {{$invoice->surname}}</td>
              <td>{{$registered_student->student->contact_number}}</td>
              <td style="width:400px">
                  @foreach($registered_student->student->guardian as $index => $guardian)
                  {{$guardian->guardian_names}}
                  {{$guardian->surname}}
                  ({{$guardian->relationship}}) -
                  {{$guardian->contact_number}}
                  @if($index < (count($registered_student->student->guardian) - 1))
                      <br>
                      @endif
                      @endforeach
              </td>
              <td>{{number_format($aging_report[$registered_student->student_id]["30"], 2, '.',',')}}</td>
              <td>{{number_format($aging_report[$registered_student->student_id]["60"], 2, '.',',')}}</td>
              <td>{{number_format($aging_report[$registered_student->student_id]["90"], 2, '.',',')}}</td>
              <td>
                  {{number_format(($aging_report[$registered_student->student_id]["30"] + $aging_report[$registered_student->student_id]["60"] + $aging_report[$registered_student->student_id]["90"]), 2, '.',',')}}
              </td>
          </tr>
          @endforeach
          <tr>
              <th></th>
              <th colspan="3" class="text-right">TOTAL</th>
              <th>{{number_format($_30days,2, '.',',')}}</th>
              <th>{{number_format($_60days,2, '.',',')}}</th>
              <th>{{number_format($_90days,2, '.',',')}}</th>
              <th>{{number_format(($_30days+$_60days+$_90days),2, '.',',')}}</th>
          </tr>
      </tbody>
  </table>