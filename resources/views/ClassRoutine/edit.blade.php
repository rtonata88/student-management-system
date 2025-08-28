@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-edit"></i> Edit Class Schedule
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('class-routine.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('class-routine.update', $schedule->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="academic_year_id">Academic Year <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" id="academic_year_id" class="form-control" required>
                                        <option value="">Select Academic Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ old('academic_year_id', $schedule->academic_year_id) == $year->id ? 'selected' : '' }}>
                                                {{ $year->academic_year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="center_id">Center <span class="text-danger">*</span></label>
                                    <select name="center_id" id="center_id" class="form-control" required>
                                        <option value="">Select Center</option>
                                        @foreach($centers as $center)
                                            <option value="{{ $center->id }}" {{ old('center_id', $schedule->center_id) == $center->id ? 'selected' : '' }}>
                                                {{ $center->center_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject_allocation_id">Subject <span class="text-danger">*</span></label>
                                    <select name="subject_allocation_id" id="subject_allocation_id" class="form-control" required>
                                        <option value="">Select Subject</option>
                                        @foreach($subjectAllocations as $allocation)
                                            <option value="{{ $allocation->id }}" 
                                                    data-center="{{ $allocation->center_id }}"
                                                    data-academic-year="{{ $allocation->academic_year_id }}"
                                                    {{ old('subject_allocation_id', $schedule->subject_allocation_id) == $allocation->id ? 'selected' : '' }}>
                                                {{ $allocation->module->subject_name }} ({{ $allocation->module->subject_code }}) - 
                                                {{ $allocation->center->center_name }} - 
                                                @if($allocation->user)
                                                    {{ trim($allocation->user->surname . ' ' . $allocation->user->other_names) ?: $allocation->user->name }}
                                                @else
                                                    Not Assigned
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="venue_id">Venue <span class="text-danger">*</span></label>
                                    <select name="venue_id" id="venue_id" class="form-control" required>
                                        <option value="">Select Venue</option>
                                        @foreach($venues as $venue)
                                            <option value="{{ $venue->id }}" 
                                                    data-center="{{ $venue->center_id }}"
                                                    {{ old('venue_id', $schedule->venue_id) == $venue->id ? 'selected' : '' }}>
                                                {{ $venue->venue_name }} - {{ $venue->center->center_name }}
                                                @if($venue->capacity)
                                                    (Capacity: {{ $venue->capacity }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="day_of_week">Day of Week <span class="text-danger">*</span></label>
                                    <select name="day_of_week" id="day_of_week" class="form-control" required>
                                        <option value="">Select Day</option>
                                        @foreach($daysOfWeek as $key => $day)
                                            <option value="{{ $key }}" {{ old('day_of_week', $schedule->day_of_week) == $key ? 'selected' : '' }}>
                                                {{ $day }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_time">Start time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" id="start_time" 
                                           class="form-control" 
                                           value="{{ old('start_time', $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '') }}" 
                                           step="300" pattern="[0-9]{2}:[0-9]{2}" required>
                                    <small class="form-text text-muted">24-hour format (e.g., 07:00, 14:30)</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_time">End time</label>
                                    <input type="time" name="end_time" id="end_time" 
                                           class="form-control" readonly 
                                           style="background-color: #f8f9fa; cursor: not-allowed;">
                                    <small class="form-text text-muted">Auto-calculated (Start time + {{ $defaultDuration }} minutes)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effective_from">Effective From <span class="text-danger">*</span></label>
                                    <input type="date" name="effective_from" id="effective_from" 
                                           class="form-control" value="{{ old('effective_from', $schedule->effective_from->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effective_to">Effective To</label>
                                    <input type="date" name="effective_to" id="effective_to" 
                                           class="form-control" value="{{ old('effective_to', $schedule->effective_to ? $schedule->effective_to->format('Y-m-d') : '') }}">
                                    <small class="form-text text-muted">Leave blank for ongoing schedule</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" 
                                      placeholder="Any additional notes about this schedule">{{ old('notes', $schedule->notes) }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-save"></i> Update Schedule
                            </button>
                            <a href="{{ route('class-routine.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const academicYearSelect = document.getElementById('academic_year_id');
    const centerSelect = document.getElementById('center_id');
    const subjectAllocationSelect = document.getElementById('subject_allocation_id');
    const venueSelect = document.getElementById('venue_id');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    // Default class duration in minutes
    const defaultDuration = {{ $defaultDuration ?? 60 }};

    function filterOptions() {
        const selectedAcademicYear = academicYearSelect.value;
        const selectedCenter = centerSelect.value;
        
        // Filter subject allocations by both academic year and center
        Array.from(subjectAllocationSelect.options).forEach(option => {
            if (option.value === '') return;
            const optionCenter = option.getAttribute('data-center');
            const optionAcademicYear = option.getAttribute('data-academic-year');
            
            const centerMatch = !selectedCenter || optionCenter === selectedCenter;
            const yearMatch = !selectedAcademicYear || optionAcademicYear === selectedAcademicYear;
            
            option.style.display = (centerMatch && yearMatch) ? 'block' : 'none';
        });

        // Filter venues by center
        Array.from(venueSelect.options).forEach(option => {
            if (option.value === '') return;
            const optionCenter = option.getAttribute('data-center');
            option.style.display = (!selectedCenter || optionCenter === selectedCenter) ? 'block' : 'none';
        });

        // Reset selections if they're no longer valid
        if (selectedCenter || selectedAcademicYear) {
            const currentSubjectAllocation = subjectAllocationSelect.value;
            const currentVenue = venueSelect.value;
            
            if (currentSubjectAllocation) {
                const subjectOption = subjectAllocationSelect.querySelector(`option[value="${currentSubjectAllocation}"]`);
                if (subjectOption) {
                    const centerMatch = !selectedCenter || subjectOption.getAttribute('data-center') === selectedCenter;
                    const yearMatch = !selectedAcademicYear || subjectOption.getAttribute('data-academic-year') === selectedAcademicYear;
                    if (!centerMatch || !yearMatch) {
                        subjectAllocationSelect.value = '';
                    }
                }
            }
            
            if (currentVenue) {
                const venueOption = venueSelect.querySelector(`option[value="${currentVenue}"]`);
                if (venueOption && venueOption.getAttribute('data-center') !== selectedCenter) {
                    venueSelect.value = '';
                }
            }
        }
    }

    function calculateEndTime() {
        const startTime = startTimeInput.value;
        if (startTime) {
            const [hours, minutes] = startTime.split(':').map(Number);
            const startDate = new Date();
            startDate.setHours(hours, minutes, 0, 0);
            
            const endDate = new Date(startDate.getTime() + (defaultDuration * 60000));
            const endHours = String(endDate.getHours()).padStart(2, '0');
            const endMinutes = String(endDate.getMinutes()).padStart(2, '0');
            
            endTimeInput.value = `${endHours}:${endMinutes}`;
        } else {
            endTimeInput.value = '';
        }
    }

    academicYearSelect.addEventListener('change', filterOptions);
    centerSelect.addEventListener('change', filterOptions);
    startTimeInput.addEventListener('change', calculateEndTime);
    
    // Initial setup
    filterOptions();
    calculateEndTime();
});
</script>
@endsection
