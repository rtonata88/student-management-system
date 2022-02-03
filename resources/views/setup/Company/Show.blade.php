@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Setup</li>
        <li class="breadcrumb-item active">Company Setup</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Company information</strong> | <a href="{{route('company.edit', 1)}}">Edit company information</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5); width: 200px">Company name</th>
                        <td>{{$company->company_name}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Address </th>
                        <td>
                            {{$company->address1}} <br>
                            {{$company->address2}} <br>
                            {{$company->address3}} <br>
                            {{$company->address4}} <br>
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number </th>
                        <td>{{$company->contact_number}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Fax </th>
                        <td>{{$company->fax}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email </th>
                        <td>{{$company->email}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Logo </th>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection