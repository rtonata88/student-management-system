@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">
            <a href="{{ route('examinations.index') }}" class="text-muted">
                <svg class="c-icon" style="width: 16px; height: 16px;">
                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                </svg>
                Examinations
            </a>
        </li>
        <li class="breadcrumb-item active">Add New Examination</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <strong>Add New Examination</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('examinations.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Examination Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                <small class="form-text text-muted">e.g., Final Exams, Mid-term Exams, Supplementary Exams</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required maxlength="10" style="text-transform: uppercase;">
                                <small class="form-text text-muted">e.g., FE, ME, SE (max 10 characters)</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mark_cap">Mark Cap (%) <span class="text-danger">*</span></label>
                                <input type="number" name="mark_cap" id="mark_cap" class="form-control" value="{{ old('mark_cap', 100) }}" required min="0" max="100" step="0.01">
                                <small class="form-text text-muted">Maximum percentage for this examination type</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="active" id="active" class="form-check-input" value="1" {{ old('active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        Active
                                    </label>
                                    <small class="form-text text-muted">Enable this examination type for use</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <svg class="c-icon mr-1">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                            </svg>
                            Save Examination
                        </button>
                        <a href="{{ route('examinations.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('code').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection
