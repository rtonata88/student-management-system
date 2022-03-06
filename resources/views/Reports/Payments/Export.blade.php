  <table>
      <thead>
          <tr>
              <th>Receipt number</th>
              <th>Student number</th>
              <th>Student name</th>
              <th>Transaction date</th>
              <th>Amount</th>
              <th>Received by</th>
          </tr>
      </thead>
      <tbody>
          @foreach($payments as $payment)
          <tr>
              <td style="width:100px;">{{$payment->receipt_number}}</td>
              <td style="width:100px;">{{$payment->student->student_number2}}</td>
              <td style="width:250px;">{{$payment->student->student_names}} {{$payment->student->surname}}</td>
              <td style="width:100px;">{{$payment->payment_date}}</td>
              <td style="width:100px;">{{$payment->payment_amount}}</td>
              <td style="width:150px;">{{$payment->user->name}}</td>
          </tr>
          @endforeach
      </tbody>
  </table>