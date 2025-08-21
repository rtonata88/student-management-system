@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.index') }}">My Modules</a></li>
        <li class="breadcrumb-item active">Class Notes</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note"></i> Class Notes - {{ $allocation->module->subject_name }}
                </h5>
                <small class="text-muted">
                    {{ $allocation->academicYear->academic_year }} | {{ $allocation->center->center_name }}
                </small>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Class notes functionality will be implemented here. This will allow you to create, edit and manage notes for your classes.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
