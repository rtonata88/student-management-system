<div class="table-responsive assistant-{{$assistant->id}}">
  <div class="row">
    <div class="col-md-12">
      <div class="pull-right">
        <a href="#" slug="{{$profile->slug}}" class="edit-btn" id="{{$assistant->id}}" section="assistant"><span class="fa fa-pencil"></span> Edit</a> |
        <a href="#" slug="{{$profile->slug}}" class="delete-btn" id="{{$assistant->id}}" section="assistant"><span class="fa fa-trash"></span> Delete</a>
      </div>
    </div>
  </div>
  <br>
  <table class="table" style="background-color: #fcfcfc; border: 1px solid #dbd9d9">
      <tbody>
        <tr>
            <td><strong>Name</strong></td>
            <td><strong>{{$assistant->assistant_name}}</strong></td>
        </tr>
          <tr>
              <td><strong>Email</strong></td>
              <td>
                <strong>P</strong>: {{$assistant->assistant_email1}} <br>
                <strong>S</strong>: {{$assistant->assistant_email2}} <br>
                <strong>O</strong>: {{$assistant->assistant_email3}} <br></td>
          </tr>
          <tr>
              <td><strong>Number</strong></td>
              <td>
                <strong>P</strong>: {{$assistant->assistant_number1}} <br>
                <strong>S</strong>: {{$assistant->assistant_number2}} <br>
                <strong>O</strong>: {{$assistant->assistant_number3}} <br>
               </td>
          </tr>
      </tbody>
  </table>
</div>
