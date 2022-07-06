  <table>
      <thead>
          <tr>
              <th>Student number</th>
              <th>Names</th>
              <th>Surname</th>
              <th>Contact number</th>
              <th>Total Debit(N$)</th>
              <th>Total Credit(N$)</th>
              <th>Balance (N$)</th>
          </tr>
      </thead>
      <tbody>
          @foreach($invoices as $invoice)
          <tr>
              <td>{{$invoice->student_number2}}</td>
              <td>{{$invoice->student_names}} </td>
              <td>{{$invoice->surname}} </td>
              <td>{{$invoice->contact_number}}</td>
              <td>{{$invoice->debit_amount}}</td>
              <td>{{$invoice->credit_amount}}</td>
              <td>{{$invoice->balance}}</td>
          </tr>
          @endforeach
          <tr>
              <th colspan="3" class="text-right">TOTAL</th>
              <th>{{$invoices->sum('debit_amount')}}</th>
              <th>{{$invoices->sum('credit_amount')}}</th>
              <th>{{$invoices->sum('balance')}}</th>
          </tr>
      </tbody>
  </table>