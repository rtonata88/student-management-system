@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-clock"></i> Exam Timetable</h4>
                    <small>View your scheduled examinations</small>
                </div>
                <div class="card-body">
                    @if($examSchedules->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <h5>No Subject Registrations</h5>
                            <p>You are not currently registered for any subjects. Exam schedules will be available once you have been admitted and registered for subjects.</p>
                            <div class="alert alert-info mt-3" role="alert">
                                <i class="fas fa-info-circle"></i>
                                <strong>Note:</strong> If you have submitted an application, please wait for admission approval and subject registration to view your exam timetable.
                            </div>
                        </div>
                    @else
                        <!-- Filter and Actions -->
                        <div class="row mb-4 no-print">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="examFilter">Filter Exams:</label>
                                    <select id="examFilter" class="form-control">
                                        <option value="all">All Exams</option>
                                        <option value="upcoming">Upcoming Exams</option>
                                        <option value="completed">Completed Exams</option>
                                        <option value="today">Today's Exams</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <button onclick="window.print()" class="btn btn-secondary me-2">
                                    <i class="fas fa-print"></i> Print Timetable
                                </button>
                                <button onclick="downloadTimetable()" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-download"></i> Download PDF
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Exam Type</th>
                                        <th>Subject</th>
                                        <th>Head Invigilator</th>
                                        <th>Centre</th>
                                        <th>Venue</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="examTableBody">
                                    @foreach($examSchedules->sortBy('exam_date') as $schedule)
                                        @php
                                            $examDate = \Carbon\Carbon::parse($schedule->exam_date);
                                            $isUpcoming = $examDate->isFuture();
                                            $isToday = $examDate->isToday();
                                            $isPast = $examDate->isPast() && !$isToday;
                                            $rowClass = $isToday ? 'table-warning' : ($isUpcoming ? '' : 'table-light');
                                        @endphp
                                        <tr class="exam-row {{ $rowClass }}" 
                                            data-status="{{ $isToday ? 'today' : ($isUpcoming ? 'upcoming' : 'completed') }}"
                                            data-date="{{ $schedule->exam_date }}">
                                            <td>
                                                <strong>{{ $examDate->format('d M Y') }}</strong>
                                                <br><small class="text-muted">{{ $examDate->format('l') }}</small>
                                                @if($isToday)
                                                    <br><span class="badge badge-warning">Today</span>
                                                @elseif($isUpcoming)
                                                    <br><span class="badge badge-success">{{ $examDate->diffForHumans() }}</span>
                                                @else
                                                    <br><span class="badge badge-secondary">Completed</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($schedule->classDuration)
                                                    <span class="badge badge-info">{{ $schedule->time_range }}</span>
                                                @else
                                                    <span class="text-muted">Time not set</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($schedule->examination)
                                                    <span class="badge badge-primary">{{ $schedule->examination->name }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $schedule->subject_name }}</strong><br>
                                                <small class="text-muted">{{ $schedule->subject_code }}</small>
                                            </td>
                                            <td>
                                                <i class="fas fa-user-tie text-primary"></i>
                                                {{ $schedule->head_invigilator_name }}
                                            </td>
                                            <td>
                                                @if($schedule->center)
                                                    {{ $schedule->center->center_name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($schedule->venue)
                                                    <strong>{{ $schedule->venue->venue_name }}</strong><br>
                                                    <small class="text-muted">{{ $schedule->venue->venue_code }}</small>
                                                @else
                                                    <span class="text-muted">Venue TBA</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($schedule->venue)
                                                    <span class="badge badge-secondary">{{ $schedule->venue->capacity }} students</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($isToday)
                                                    <span class="badge badge-warning">Today</span>
                                                @elseif($isUpcoming)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-clock"></i> Upcoming
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-check"></i> Completed
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Exam Statistics -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-chart-bar"></i> Exam Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $examSchedules->count() }}</h4>
                                            <p class="text-muted mb-0">Total Exams</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $examSchedules->where('exam_date', '>', now())->count() }}</h4>
                                            <p class="text-muted mb-0">Upcoming</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-warning">{{ $examSchedules->where('exam_date', '<=', now())->count() }}</h4>
                                            <p class="text-muted mb-0">Completed</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $examSchedules->unique('subjectAllocation.subject.id')->count() }}</h4>
                                            <p class="text-muted mb-0">Subjects</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="text-center mt-4 no-print">
                        <a href="{{ route('student-portal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-header {
        background: white !important;
        color: black !important;
        border-bottom: 2px solid #000 !important;
    }
    
    .table {
        font-size: 12px;
    }
    
    .badge {
        border: 1px solid #000 !important;
        color: #000 !important;
        background: white !important;
    }
}

.exam-row.filtered-out {
    display: none;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.table-light {
    background-color: rgba(248, 249, 250, 0.5) !important;
}

.badge-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
}

.badge-primary {
    background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterSelect = document.getElementById('examFilter');
    const examRows = document.querySelectorAll('.exam-row');
    
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const filterValue = this.value;
            
            examRows.forEach(row => {
                const status = row.getAttribute('data-status');
                
                if (filterValue === 'all') {
                    row.classList.remove('filtered-out');
                } else if (filterValue === status) {
                    row.classList.remove('filtered-out');
                } else {
                    row.classList.add('filtered-out');
                }
            });
            
            // Update visible count
            const visibleRows = document.querySelectorAll('.exam-row:not(.filtered-out)');
            console.log(`Showing ${visibleRows.length} of ${examRows.length} exams`);
        });
    }
});

function downloadTimetable() {
    // Create a form to submit for PDF download
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("student-portal.exam-timetable-pdf") }}';
    form.style.display = 'none';
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endsection
