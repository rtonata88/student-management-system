<div class="qualifications-container">
    <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
        <tr>
            <th style="background-color: rgba(227, 227, 227, 0.5)">Qualification title</th>
            <td>
                {{Form::text('qualification_name',null, ['class' => 'form-control', 'placeholder'=>'Primary mobile number'])}}
                <input type="hidden" name="model" value="Therapist">
            </td>
        </tr>
        <tr>
            <th style="background-color: rgba(227, 227, 227, 0.5)">Institution</th>
            <td>
                {{Form::text('institution',null, ['class' => 'form-control', 'placeholder'=>'Institution'])}}
            </td>
        </tr>
        <tr>
            <th style="background-color: rgba(227, 227, 227, 0.5)">Start year</th>
            <td>
                {{Form::number('start_year',null, ['class' => 'form-control', 'placeholder'=>'Start year'])}}
            </td>
        </tr>
        <tr>
            <th style="background-color: rgba(227, 227, 227, 0.5)">End year</th>
            <td>
                {{Form::number('start_year',null, ['class' => 'form-control', 'placeholder'=>'End year'])}}
            </td>
        </tr>
    </table>
</div>