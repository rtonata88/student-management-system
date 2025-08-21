@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('module-allocations.index') }}">Module Allocations</a></li>
        <li class="breadcrumb-item active">Add Module Allocation</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Modern Search Card with Glassmorphism -->
        <div class="search-container">
            <div class="search-card">
                <div class="search-header">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h4>Add Module Allocation</h4>
                </div>
                
                <div class="search-form">
                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('module-allocations.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="module_id">Subject <span class="text-danger">*</span></label>
                            <select name="module_id" id="module_id" class="form-control" required>
                                <option value="">Select subject</option>
                                @foreach($modules as $module)
                                <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                    {{ $module->subject_code }} - {{ $module->subject_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="academic_year_id">Academic Year <span class="text-danger">*</span></label>
                            <select name="academic_year_id" id="academic_year_id" class="form-control" required>
                                <option value="">Select academic year</option>
                                @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                                    {{ $year->academic_year }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="center_id">Centre <span class="text-danger">*</span></label>
                            <select name="center_id" id="center_id" class="form-control" required>
                                <option value="">Select centre</option>
                                @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->center_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="teacher_id">Teaching Staff <span class="text-danger">*</span></label>
                            <select name="teacher_id" id="teacher_id" class="form-control" required>
                                <option value="">Select teaching staff</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-actions text-center">
                            <button type="submit" class="btn btn-success btn-elevated">
                                <i class="fas fa-save"></i> Save
                            </button>
                            <a href="{{ route('module-allocations.index') }}" class="btn btn-secondary btn-elevated">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.search-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.search-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
}

.search-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 2rem;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.search-header i {
    font-size: 2rem;
    color: white;
    margin-bottom: 0.5rem;
}

.search-header h4 {
    color: white;
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
}

.search-form {
    padding: 2rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: rgba(255, 255, 255, 1);
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.btn-elevated {
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    margin: 0 0.5rem;
}

.btn-elevated:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.btn-success.btn-elevated {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
}

.btn-secondary.btn-elevated {
    background: linear-gradient(135deg, #6c757d, #495057);
    border: none;
    color: white !important;
}

@media (max-width: 768px) {
    .search-container {
        padding: 1rem;
    }
    
    .search-form {
        padding: 1.5rem;
    }
    
    .btn-elevated {
        display: block;
        width: 100%;
        margin: 0.5rem 0;
    }
}
</style>
@endsection
