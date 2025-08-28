@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-graduation-cap"></i> Students for Promotion
                        </h4>
                        <a href="{{ route('promotions.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Search
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('promotions.search') }}" class="form-inline">
                                <div class="form-group mr-3">
                                    <input type="text" name="student_number" class="form-control" placeholder="Student Number..." value="{{ request('student_number') }}">
                                </div>
                                <div class="form-group mr-3">
                                    <input type="text" name="student_name" class="form-control" placeholder="Student Name..." value="{{ request('student_name') }}">
                                </div>
                                <div class="form-group mr-3">
                                    <select name="academic_year" class="form-control">
                                        <option value="">Academic Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->academic_year }}" {{ request('academic_year') == $year->academic_year ? 'selected' : '' }}>
                                                {{ $year->academic_year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <select name="center_id" class="form-control">
                                        <option value="">Centre</option>
                                        @foreach($centers as $center)
                                            <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                                {{ $center->center_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn mr-2" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('promotions.search') }}" class="btn mr-2" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-list"></i> Show All
                                </a>
                                <button type="button" class="btn" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" onclick="clearForm()">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Students Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <tr>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Student Number</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Student Name</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Centre</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Year</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Email Address</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Phone Number</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Actions</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600; width: 60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td style="padding: 16px 12px; font-weight: 500;">
                                        <div>{{ $student->student_number }}</div>
                                        @if($student->student_number2)
                                            <small class="text-muted">{{ $student->student_number2 }}</small>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        <strong>{{ $student->surname }}, {{ $student->student_names }}</strong>
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $student->center->center_name ?? 'N/A' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        @php
                                            $lastRegistration = $student->registration()->orderBy('academic_year', 'desc')->first();
                                        @endphp
                                        {{ $lastRegistration ? $lastRegistration->academic_year : 'N/A' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $student->contact_email ?? 'N/A' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $student->contact_number ?? 'N/A' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        <div class="btn-group" role="group">
                                            @if(Auth::user()->hasPermission('promote-students'))
                                                <a href="{{ route('promotions.marks', $student->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Promote Student">
                                                    <i class="fas fa-graduation-cap"></i> Promote
                                                </a>
                                            @endif
                                            @if(Auth::user()->hasPermission('view-promotion-history'))
                                                <a href="{{ route('promotions.history', $student->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-left: 5px;" title="View History">
                                                    <i class="fas fa-history"></i> History
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 16px 12px; text-align: center; width: 60px;">
                                        @php
                                            // Simple check for any promotion record for this student
                                            $hasPromotion = DB::table('student_promotions')->where('student_id', $student->id)->exists();
                                        @endphp
                                        @if($hasPromotion)
                                            <i class="fas fa-check-circle" style="color: rgba(40, 167, 69, 0.6); font-size: 18px;" title="Promoted"></i>
                                        @else
                                            <i class="fas fa-times-circle" style="color: rgba(220, 53, 69, 0.6); font-size: 18px;" title="Not Promoted"></i>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center" style="padding: 40px; color: #6c757d;">
                                        <i class="fas fa-users fa-3x mb-3" style="opacity: 0.3;"></i>
                                        <p class="mb-0">No students found. Try adjusting your search criteria.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($students->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $students->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Apply standard gradient theme to pagination */
.pagination .page-link {
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%) !important;
    color: white !important;
    border: none !important;
    border-radius: 6px !important;
    margin: 0 2px !important;
    padding: 0.375rem 0.75rem !important;
    transition: all 0.3s ease !important;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #5a32a3 0%, #0056b3 100%) !important;
    color: white !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(111, 66, 193, 0.3) !important;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #5a32a3 0%, #0056b3 100%) !important;
    color: white !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.4) !important;
}

.pagination .page-item.disabled .page-link {
    background: linear-gradient(135deg, rgba(111, 66, 193, 0.5) 0%, rgba(0, 123, 255, 0.5) 100%) !important;
    color: rgba(255, 255, 255, 0.6) !important;
    border: none !important;
}
</style>

<script>
function clearForm() {
    // Clear all form inputs
    document.querySelector('input[name="student_number"]').value = '';
    document.querySelector('input[name="student_name"]').value = '';
    document.querySelector('select[name="academic_year"]').value = '';
    document.querySelector('select[name="center_id"]').value = '';
    
    // Redirect to clear the search results and reset the page
    window.location.href = '{{ route("promotions.search") }}';
}
</script>
@endsection
