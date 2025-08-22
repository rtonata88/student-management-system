@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Applications</li>
        <li class="breadcrumb-item active"><a href="/student-letters">Student Letters</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Modern Search Section -->
    <div class="search-container mb-5">
        <div class="search-card">
            <div class="search-header">
                <h4 class="search-title">
                    <i class="fas fa-file-alt me-2"></i>
                    Find Student for Letter Generation
                </h4>
                <p class="search-subtitle">Search by student number or name to generate official student letters</p>
            </div>
            
            {!! Form::open(array('route' => array('student-letters.filter'), 'method' => 'post', 'class'=> 'search-form')) !!}
            
            <div class="search-fields">
                <div class="search-field-group">
                    <div class="search-field">
                        <label for="student_number" class="search-label">
                            <i class="fas fa-id-card me-2"></i>Student Number
                        </label>
                        {{Form::text('student_number', null, [
                            'class' => 'search-input', 
                            'placeholder' => 'Enter student number or allocated number...',
                            'id' => 'student_number'
                        ])}}
                    </div>
                    
                    <div class="search-divider">
                        <span class="divider-text">OR</span>
                    </div>
                    
                    <div class="search-field">
                        <label for="names" class="search-label">
                            <i class="fas fa-user me-2"></i>Student Name
                        </label>
                        {{Form::text('names', null, [
                            'class' => 'search-input', 
                            'placeholder' => 'Enter first name or surname...',
                            'id' => 'names'
                        ])}}
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
            
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Results Section -->
    <div class="row">
        <div class="col-12">
        @if(Session::has('message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('message') }}
        </div>
        @endif
        @if(isset($students))
        <div class="card">
            <div class="card-header">
                <strong> Select student to generate letter </strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Allocated Number</th>
                            <th>Student Names</th>
                            <th>Surname</th>
                            <th>Centre</th>
                            <th>DOB</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{$student->student_number}}</td>
                            <td>{{$student->student_number2}}</td>
                            <td>{{$student->student_names}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->center ? $student->center->center_name : 'N/A'}}</td>
                            <td>{{$student->date_of_birth}}</td>
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <a href="{{route('student-letters.generate', $student->id)}}" class="btn btn-gradient-primary btn-sm">
                                        <i class="fas fa-file-alt me-1"></i>Generate Letter
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        </div>
    </div>
</div>

<script>
function clearForm() {
    document.getElementById('student_number').value = '';
    document.getElementById('names').value = '';
    
    // Also clear any search results if they exist
    const resultsSection = document.querySelector('.col-12 .card');
    if (resultsSection) {
        resultsSection.style.display = 'none';
    }
    
    // Remove any error messages
    const alertDanger = document.querySelector('.alert-danger');
    if (alertDanger) {
        alertDanger.style.display = 'none';
    }
}
</script>

<style>
.search-container {
    max-width: 900px;
    margin: 0 auto;
}

.search-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
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
    color: #667eea;
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
    
    .search-divider {
        order: 2;
    }
    
    .search-actions {
        flex-direction: column;
    }
    
    .btn-search, .btn-clear {
        width: 100%;
    }
}

/* Custom Gradient Buttons */
.btn-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-gradient-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-gradient-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    outline: none;
}
</style>
@endsection
