@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">
            <a href="{{ route('result-codes.index') }}" class="text-muted">
                <svg class="c-icon" style="width: 16px; height: 16px;">
                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                </svg>
                Result Codes
            </a>
        </li>
        <li class="breadcrumb-item active">Edit Result Code</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <strong>Edit Result Code</strong>
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

                <form action="{{ route('result-codes.update', $resultCode->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Result Code Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $resultCode->name) }}" required>
                                <small class="form-text text-muted">e.g., Distinction, Credit, Pass, Fail</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $resultCode->code) }}" required maxlength="10" style="text-transform: uppercase;">
                                <small class="form-text text-muted">e.g., D, C, P, F (max 10 characters)</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $resultCode->description) }}</textarea>
                                <small class="form-text text-muted">Optional description of the result code</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass_fail">Pass/Fail Status <span class="text-danger">*</span></label>
                                <select name="pass_fail" id="pass_fail" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="Pass" {{ old('pass_fail', $resultCode->pass_fail) == 'Pass' ? 'selected' : '' }}>Pass</option>
                                    <option value="Fail" {{ old('pass_fail', $resultCode->pass_fail) == 'Fail' ? 'selected' : '' }}>Fail</option>
                                </select>
                                <small class="form-text text-muted">Indicates whether this result code represents a pass or fail</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="active" id="active" class="form-check-input" value="1" {{ old('active', $resultCode->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        Active
                                    </label>
                                    <small class="form-text text-muted">Enable this result code for use</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <svg class="c-icon mr-1">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                            </svg>
                            Update Result Code
                        </button>
                        <a href="{{ route('result-codes.index') }}" class="btn btn-secondary ml-2">Cancel</a>
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
