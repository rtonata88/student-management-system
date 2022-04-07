@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active">Audit </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('reports.audit.search'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    <label class="text-right control-label col-form-label">Event action</label>
                    {{Form::select('event', ['created' => "New record event", 'updated' => "Update record event"], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'All events'])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">From date</label>
                    {{Form::date('date_from', date('Y-m-d'), ['class' => 'form-control form-control-sm', 'required'])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">To date</label>
                    {{Form::date('date_to', date('Y-m-d'), ['class' => 'form-control form-control-sm', 'required'])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Module</label>
                    {{Form::select('model', $audit_models, null, ['class' => 'form-control form-control-sm select'])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">User</label>
                    {{Form::select('user_id', $users, null, ['class' => 'form-control form-control-sm select', 'placeholder' =>'Select all'])}}
                </div>

                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                    <a href="{{route('reports.audit')}}" class="btn btn-sm">Clear</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong>
            </div>
            <div class="card-body">
                @if($audit_logs)
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Event</th>
                            <th>User</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audit_logs->take(100) as $log)
                        <tr>
                            <td>{{$log->auditable_type}}</td>
                            <td>{{$log->event}}</td>
                            <td>{{$log->user->name}}</td>
                            <td>{{$log->created_at}}</td>
                            <td>
                                <a href="{{route('reports.audit.show', $log->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                Nothing to show here
                            </td>
                        </tr>

                        @endforelse
                    </tbody>
                </table>

                @endif
            </div>
        </div>
    </div>
</div>
@endsection