@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment">Enrolment</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header Section with Title, Filters and Add Button -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h2 class="mb-1">Student Enrollment</h2>
                    <p class="text-muted mb-0">Register students with full admission status for enrollment</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!-- Search Filters -->
                    {!! Form::open(array('route' => array('enrolment.filter'), 'method' => 'post', 'class'=> 'd-flex align-items-center flex-wrap gap-2 me-3')) !!}
                    <div class="input-group" style="width: 200px;">
                        {{Form::text('student_number', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student Number'])}}
                    </div>
                    <div class="input-group" style="width: 200px;">
                        {{Form::text('names', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student Name'])}}
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <a href="/enrolment" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-refresh"></i> Clear
                    </a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (Session::has('not_found'))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{Session::get('not_found')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-3">STUDENT #</th>
                                    <th class="border-0">SET #</th>
                                    <th class="border-0">SURNAME</th>
                                    <th class="border-0">FIRST NAMES</th>
                                    <th class="border-0">CENTER</th>
                                    <th class="border-0">D.O.B</th>
                                    <th class="border-0">ID NUMBER</th>
                                    <th class="border-0">MOBILE #</th>
                                    <th class="border-0 text-center">ADMISSION STATUS</th>
                                    <th class="border-0 text-center">ENROLL</th>
                                    <th class="border-0 text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr class="border-bottom">
                                    <td class="ps-3 py-3">
                                        <strong class="text-primary">{{$student->student_number}}</strong>
                                    </td>
                                    <td class="py-3">
                                        <strong class="text-primary">{{$student->student_number2}}</strong>
                                    </td>
                                    <td class="py-3">{{$student->surname}}</td>
                                    <td class="py-3">{{$student->student_names}}</td>
                                    <td class="py-3">
                                        @if($student->center)
                                            {{$student->center->center_name}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($student->date_of_birth)
                                            {{\Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($student->id_number)
                                            {{$student->id_number}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($student->contact_number)
                                            {{$student->contact_number}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-success">Full Admission</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <a href="{{route('enrolment.showEnrollmentScreen', $student->id)}}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-user-plus"></i> Register
                                        </a>
                                    </td>
                                    <td class="py-3 text-center">
                                        @php
                                            $currentYear = date('Y');
                                            $registration = $student->registration->where('academic_year', $currentYear)->first();
                                            $isRegistered = $registration && $registration->registration_status == 'Registered';
                                        @endphp
                                        <div class="dropdown d-flex justify-content-center">
                                            <button class="btn btn-sm btn-light border" type="button" data-toggle="dropdown" aria-expanded="false" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                <span style="font-weight: bold; font-size: 18px; color: #333; line-height: 1;">⋯</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if($isRegistered)
                                                    <a class="dropdown-item" href="{{route('enrolment.show', $student->id)}}">
                                                        View Registration
                                                    </a>
                                                @else
                                                    <span class="dropdown-item text-muted" style="cursor: not-allowed;">
                                                        View Registration
                                                    </span>
                                                @endif
                                                
                                                <a class="dropdown-item" href="{{route('enrolment.adjustment.showScreen', $student->id)}}">
                                                    Modify Registration
                                                </a>
                                                
                                                <a class="dropdown-item" href="{{route('cancellation.showCancellationScreen', $student->id)}}">
                                                    Cancel Registration
                                                </a>
                                                
                                                @if($isRegistered)
                                                    <a class="dropdown-item" href="{{route('enrolment.proof', $student->id)}}">
                                                        Proof of Registration
                                                    </a>
                                                @else
                                                    <span class="dropdown-item text-muted" style="cursor: not-allowed;">
                                                        Proof of Registration
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa fa-graduation-cap fa-3x mb-3"></i>
                                            <h5>No Students Available for Enrollment</h5>
                                            <p>Use the search filters above to find students with full admission status.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if(isset($students) && $students->hasPages())
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                            </div>
                            <div>
                                {{$students->links()}}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

.gap-2 {
    gap: 0.5rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}

.dropdown-toggle::after {
    display: none;
}

/* Primary button with gradient */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

/* Search button styling */
.btn-outline-primary {
    border: 2px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Student number styling */
.text-primary {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600 !important;
}

/* Pagination styling */
.pagination .page-link {
    color: var(--primary-color) !important;
    border-color: #dee2e6;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.active .page-link {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
}

/* Clear button styling */
.btn-outline-secondary:hover {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
}

/* Badge styling */
.badge.bg-success {
    background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%) !important;
}

.dropdown-menu {
    z-index: 1050 !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    border: 1px solid rgba(0,0,0,0.1);
}

.dropdown {
    position: relative;
}

.table-responsive {
    overflow: visible !important;
}

.table td {
    position: relative;
}

@media (max-width: 768px) {
    .d-flex.flex-wrap .input-group {
        width: 100% !important;
        margin-bottom: 0.5rem;
    }
    .d-flex.flex-wrap .btn {
        margin-bottom: 0.5rem;
    }
}
</style>

@endsection