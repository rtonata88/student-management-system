<table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
    <tr>
    <th style="width:150px; background-color: rgba(227, 227, 227, 0.5)">Organisation name</th>
    <td>{{Form::select('organization[]', $organisations, null, ['class' => 'form-control select2', 'required', 'placeholder'=>'Select organisation'])}}</td>
    </tr>
    <tr>
    <th style="background-color: rgba(227, 227, 227, 0.5)">Position </th>
    <td>{{Form::text('position[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}</td>
    </tr>
    <tr>
    <th style="background-color: rgba(227, 227, 227, 0.5)">Department</th>
    <td>{{Form::text('department[]',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
    </tr>
    <tr>
    <th style="background-color: rgba(227, 227, 227, 0.5)">Work number</th>
    <td>
        {{Form::text('work_number[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Primary number'])}}
        {{Form::text('work_number2[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Secondary number'])}}
        {{Form::text('work_number_other[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Other'])}}

    </td>
    </tr>
    <tr>
    <th style="background-color: rgba(227, 227, 227, 0.5)">Email</th>
        <td>
            {{Form::email('email[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Email'])}}
            {{Form::email('email2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Email'])}}
            {{Form::email('email_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button type="button" class="btn btn-sm text-danger remove-organisation-btn"> 
            Delete this organisation</button>
        </td>
    </tr>
</table> 