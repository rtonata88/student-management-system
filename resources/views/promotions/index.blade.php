@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modern Search Section -->
<div class="search-container mb-5">
    <div class="search-card">
        <div class="search-header">
            <h4 class="search-title">
                <i class="fas fa-graduation-cap me-2"></i>
                Student Promotions
            </h4>
            <p class="search-subtitle">Search for students to promote or view all students</p>
        </div>
        
        <form method="GET" action="{{ route('promotions.search') }}" class="search-form">
            <div class="search-fields">
                <div class="search-field-group">
                    <div class="search-field">
                        <label for="student_number" class="search-label">
                            <i class="fas fa-id-card me-2"></i>Student Number
                        </label>
                        <input type="text" 
                               class="search-input" 
                               id="student_number" 
                               name="student_number" 
                               placeholder="Enter student number..."
                               value="{{ old('student_number') }}">
                    </div>
                    
                    <div class="search-divider">
                        <span class="divider-text">OR</span>
                    </div>
                    
                    <div class="search-field">
                        <a href="{{ route('promotions.search') }}" class="btn-show-all">
                            <i class="fas fa-list me-2"></i>Show All Students
                        </a>
                    </div>
                </div>
                
                <div class="filter-field-group">
                    <div class="search-field">
                        <label for="academic_year" class="search-label">
                            <i class="fas fa-calendar me-2"></i>Academic Year
                        </label>
                        <select class="search-input" id="academic_year" name="academic_year">
                            <option value="">Select Academic Year</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->academic_year }}" {{ old('academic_year') == $year->academic_year ? 'selected' : '' }}>
                                    {{ $year->academic_year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="search-divider">
                        <span class="divider-text">AND</span>
                    </div>
                    
                    <div class="search-field">
                        <label for="center_id" class="search-label">
                            <i class="fas fa-building me-2"></i>Centre
                        </label>
                        <select class="search-input" id="center_id" name="center_id">
                            <option value="">Select Centre</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->center_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="search-actions">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                    <button type="button" class="btn-clear" onclick="clearForm()">
                        <i class="fas fa-times me-2"></i>Clear
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function clearForm() {
    document.getElementById('student_number').value = '';
    document.getElementById('academic_year').value = '';
    document.getElementById('center_id').value = '';
}
</script>

<style>
.search-container {
    max-width: 900px;
    margin: 0 auto;
}

.search-card {
    background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 20px 40px rgba(111, 66, 193, 0.15);
    overflow: hidden;
}

.search-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 2rem;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.search-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-subtitle {
    color: rgba(255, 255, 255, 0.8);
    margin: 0.5rem 0 0 0;
    font-size: 0.95rem;
}

.search-form {
    padding: 2rem;
}

.search-fields {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.search-field-group {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 2rem;
    align-items: end;
}

.filter-field-group {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 2rem;
    align-items: end;
}

.search-field {
    display: flex;
    flex-direction: column;
}

.search-label {
    color: white;
    font-weight: 500;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.search-input {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    color: white;
    font-size: 1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    width: 100%;
    min-height: 54px;
    height: 54px;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.search-input:focus {
    outline: none;
    border-color: rgba(255, 255, 255, 0.5);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
}

.search-input option {
    background: #6f42c1;
    color: white;
}

.btn-show-all {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    color: white;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1.75rem;
    min-height: 54px;
    height: 54px;
}

.btn-show-all:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.search-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 1rem;
}

.divider-text {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.search-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-search, .btn-clear {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    min-width: 140px;
    justify-content: center;
}

.btn-search {
    background: rgba(255, 255, 255, 0.9);
    color: #6f42c1;
}

.btn-search:hover {
    background: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
}

.btn-clear {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-clear:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .search-field-group {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .filter-field-group {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .search-divider {
        order: 2;
    }
    
    .search-actions {
        flex-direction: column;
    }
    
    .btn-search, .btn-clear {
        width: 100%;
    }
    
    .btn-show-all {
        margin-top: 0;
    }
}
</style>
@endsection
