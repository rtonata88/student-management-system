@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active">Show Audit log </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Audit log details</strong> | <a href="{{route('reports.audit')}}">Back</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm no-wrap">
                    <tbody>
                        <tr>
                            <th style="width: 100px">Module</th>
                            <td>{{$log->auditable_type}}</td>
                        </tr>
                        <tr>
                            <th style="width: 100px">Event Action</th>
                            <td>{{$log->event}}</td>
                        </tr>
                        <tr>
                            <th style="width: 100px">User</th>
                            <td>{{$log->user->name}}</td>
                        </tr>
                        <tr>
                            <th style="width: 100px">Date & Time</th>
                            <td>{{$log->created_at}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-responsive-sm table-bordered table-sm no-wrap">
                    <tbody>
                        <tr>
                            <th>Fields</th>
                            <th>New value</th>
                            @if($log->event == "updated")
                            <th>Old value</th>
                            @endif
                        </tr>
                        <?php $old_values = json_decode($log->old_values); ?>
                        @foreach(json_decode($log->new_values) as $key=>$audit)
                        <tr>
                            <td>
                                {{$key ?? "Null"}}
                            </td>
                            <td>
                                {{$audit }}
                            </td>
                            @if($log->event == "updated")
                            <td>
                                {{$old_values->$key ?? "Null"}}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('reports.audit')}}">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection