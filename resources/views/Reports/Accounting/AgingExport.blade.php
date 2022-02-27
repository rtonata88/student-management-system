  <table>
      <thead>
          <tr>
              <th>Student number</th>
              <th>Names</th>
              <th>Contact number</th>
              <th>30 Days</th>
              <th>60 Days</th>
              <th>90 Days +</th>
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
              <td>{{number_format($aging_report[$registered_student->student_id]["30"], 2, '.',',')}}</td>
              <td>{{number_format($aging_report[$registered_student->student_id]["60"], 2, '.',',')}}</td>
              <td>{{number_format($aging_report[$registered_student->student_id]["90"], 2, '.',',')}}</td>
          </tr>
          @endforeach
          <tr>
              <th></th>
              <th colspan="2" class="text-right">TOTAL</th>
              <th>{{number_format($_30days,2, '.',',')}}</th>
              <th>{{number_format($_60days,2, '.',',')}}</th>
              <th>{{number_format($_90days,2, '.',',')}}</th>
          </tr>
      </tbody>
  </table>