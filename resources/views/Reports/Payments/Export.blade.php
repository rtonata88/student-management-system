  <table>
      <thead>
          <tr>
              <th>Receipt number</th>
              <th>Student number</th>
              <th>Student name</th>
              <th>Transaction date</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Captured by</th>
              <th>Guardians</th>
          </tr>
      </thead>
      <tbody>
          @foreach($payments as $payment)
          <tr>
              <td style="width:100px;">{{$payment->reference_number}}</td>
              <td style="width:100px;">{{$payment->student->student_number2}}</td>
              <td style="width:250px;">{{$payment->student->student_names}} {{$payment->student->surname}}</td>
              <td style="width:100px;">{{$payment->transaction_date}}</td>
              <td style="width:200px;">{{$payment->line_description}}</td>
              <td style="width:100px;">{{$payment->credit_amount}}</td>
              <td style="width:200px;">{{$users->where('id', $payment->capturedBy->received_by)->first()->name}}</td>
              <td style="width:300px;">
                  @foreach($guardians->where('student_id', $payment->student_id) as $index => $guardian)
                  <p>{{$guardian->guardian_names}} {{$guardian->surname}} ({{$guardian->relationship}}) - {{$guardian->contact_number}}</p>
                  @endforeach
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>