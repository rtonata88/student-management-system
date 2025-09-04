@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Subject Materials</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.my-subjects') }}">My Subjects</a></li>
                        <li class="breadcrumb-item active">Subject Materials</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                <i class="fas fa-folder-open"></i> Subject Materials
                            </h5>
                            <small class="text-muted">
                                {{ $allocation->module->subject_code }} - {{ $allocation->module->subject_name }}
                                <span class="badge bg-info ms-2">{{ $allocation->academicYear->academic_year }}</span>
                            </small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('student-portal.my-subjects') }}" 
                               class="btn btn-sm" 
                               style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-arrow-left"></i> Back to My Subjects
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <!-- Subject Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-2"><i class="fas fa-book"></i> Subject Information</h6>
                                            <p class="mb-1"><strong>Subject:</strong> {{ $allocation->module->subject_name }}</p>
                                            <p class="mb-1"><strong>Code:</strong> {{ $allocation->module->subject_code }}</p>
                                            <p class="mb-0"><strong>Academic Year:</strong> {{ $allocation->academicYear->academic_year }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Campus:</strong> {{ $allocation->center->center_name }}</p>
                                            <p class="mb-1"><strong>Lecturer:</strong> 
                                                @if($allocation->user)
                                                    {{ $allocation->user->first_name }} {{ $allocation->user->surname }}
                                                @else
                                                    <span class="text-muted">Not Assigned</span>
                                                @endif
                                            </p>
                                            <p class="mb-0"><strong>Student:</strong> {{ $student->student_names }} {{ $student->surname }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('student-portal.subject-materials', $allocation->id) }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Search materials..." 
                                                   value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="category" class="form-control">
                                                <option value="all">All Categories</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn" 
                                                style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('student-portal.subject-materials', $allocation->id) }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Materials List -->
                    @if($materials->count() > 0)
                        <div class="row">
                            @foreach($materials as $material)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-{{ 
                                                $material->category == 'Syllabus' ? 'primary' : 
                                                ($material->category == 'Class Notes' ? 'success' : 
                                                ($material->category == 'General Info' ? 'info' : 
                                                ($material->category == 'Exam Papers' ? 'warning' : 'secondary'))) 
                                            }}">
                                                {{ $material->category }}
                                            </span>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($material->created_at)->format('d M Y') }}
                                            </small>
                                        </div>
                                        
                                        <h6 class="card-title">{{ $material->document_name }}</h6>
                                        
                                        @if($material->document_description)
                                        <p class="card-text text-muted small">
                                            {{ \Illuminate\Support\Str::limit($material->document_description, 100) }}
                                        </p>
                                        @endif
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-file"></i> 
                                                {{ strtoupper(pathinfo($material->file_name, PATHINFO_EXTENSION)) }} 
                                                ({{ number_format($material->file_size / 1024, 2) }} KB)
                                            </small>
                                        </div>
                                        
                                        @if($material->uploader)
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-user"></i> {{ $material->uploader->first_name }} {{ $material->uploader->surname }}
                                        </small>
                                        @endif
                                        
                                        @if($material->end_date)
                                        <small class="text-warning d-block mt-1">
                                            <i class="fas fa-clock"></i> Available until {{ \Carbon\Carbon::parse($material->end_date)->format('d M Y') }}
                                        </small>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('student-portal.download-subject-material', $material->id) }}" 
                                           class="btn btn-sm w-100" 
                                           style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $materials->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5>No Materials Available</h5>
                            <p class="text-muted">
                                @if(request('search') || request('category'))
                                    No materials found matching your search criteria.
                                @else
                                    Subject materials will appear here when uploaded by your lecturer.
                                @endif
                            </p>
                            @if(request('search') || request('category'))
                                <a href="{{ route('student-portal.subject-materials', $allocation->id) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-times"></i> Clear Filters
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
