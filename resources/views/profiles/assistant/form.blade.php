<table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
    <tr>
        <th style="width:150px; background-color: rgba(227, 227, 227, 0.5)">Assistant name</th>
        <td>{{Form::text('assistant_name[]',null, ['class' => 'form-control', 'placeholder' => 'Type here', 'required'])}}</td>
    </tr>
    <tr>
    <th style="background-color: rgba(227, 227, 227, 0.5)">Number</th>
        <td>
            {{Form::text('assistant_number1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Number'])}}
            {{Form::text('assistant_number2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Number'])}}
            {{Form::text('assistant_number3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
        </td>
    </tr>
    <tr>
        <th style="background-color: rgba(227, 227, 227, 0.5)">Email</th>
        <td>
            {{Form::email('assistant_email1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Email'])}}
            {{Form::email('assistant_email2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Email'])}}
            {{Form::email('assistant_email3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button type="button" class="btn btn-sm text-danger remove-assistant-btn"> 
            Delete this assistant</button>
        </td>
    </tr>
</table>