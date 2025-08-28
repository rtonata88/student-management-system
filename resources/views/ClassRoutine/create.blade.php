@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-plus"></i> Create Class Schedule
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('class-routine.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
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

                    <!-- Real-time conflict alerts -->
                    <div id="conflict-alerts" style="display: none;">
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <span id="conflict-message"></span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('class-routine.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="academic_year_id">Academic Year <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" id="academic_year_id" class="form-control" required>
                                        <option value="">Select Academic Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ old('academic_year_id', $currentAcademicYear->id ?? '') == $year->id ? 'selected' : '' }}>
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
                                            <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
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
                                                    {{ old('subject_allocation_id') == $allocation->id ? 'selected' : '' }}>
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
                                                    {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
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
                                            <option value="{{ $key }}" {{ old('day_of_week') == $key ? 'selected' : '' }}>
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
                                           class="form-control" value="{{ old('start_time') }}" 
                                           required>
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
                                           class="form-control" value="{{ old('effective_from', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effective_to">Effective To</label>
                                    <input type="date" name="effective_to" id="effective_to" 
                                           class="form-control" value="{{ old('effective_to') }}">
                                    <small class="form-text text-muted">Leave blank for ongoing schedule</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" 
                                      placeholder="Any additional notes about this schedule">{{ old('notes') }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-save"></i> Create Schedule
                            </button>
                            <a href="{{ route('class-routine.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-left: 5px;">
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
    const dayOfWeekSelect = document.getElementById('day_of_week');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const effectiveFromInput = document.getElementById('effective_from');
    
    // Default class duration in minutes
    const defaultDuration = {{ $defaultDuration ?? 60 }};

    // Store original options for filtering
    const originalSubjectOptions = Array.from(subjectAllocationSelect.querySelectorAll('option')).slice(1); // Skip first empty option
    const originalVenueOptions = Array.from(venueSelect.querySelectorAll('option')).slice(1); // Skip first empty option

    function checkForConflicts() {
        const subjectAllocationId = subjectAllocationSelect.value;
        const venueId = venueSelect.value;
        const dayOfWeek = dayOfWeekSelect.value;
        const startTime = startTimeInput.value;
        const effectiveFrom = effectiveFromInput.value;

        if (subjectAllocationId && venueId && dayOfWeek && startTime && effectiveFrom) {
            // Make AJAX request to check for conflicts
            fetch('{{ route("class-routine.check-conflicts") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    subject_allocation_id: subjectAllocationId,
                    venue_id: venueId,
                    day_of_week: dayOfWeek,
                    start_time: startTime,
                    effective_from: effectiveFrom
                })
            })
            .then(response => response.json())
            .then(data => {
                const conflictAlerts = document.getElementById('conflict-alerts');
                const conflictMessage = document.getElementById('conflict-message');
                
                if (data.conflicts && data.conflicts.length > 0) {
                    conflictMessage.innerHTML = data.conflicts.join('<br>');
                    conflictAlerts.style.display = 'block';
                } else {
                    conflictAlerts.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error checking conflicts:', error);
            });
        }
    }

    function filterOptions() {
        const selectedAcademicYear = academicYearSelect.value;
        const selectedCenter = centerSelect.value;
        
        // Clear current options (keep first empty option)
        subjectAllocationSelect.innerHTML = '<option value="">Select Subject</option>';
        venueSelect.innerHTML = '<option value="">Select Venue</option>';
        
        // Filter and add subject allocations based on BOTH academic year AND center
        originalSubjectOptions.forEach(option => {
            const optionCenter = option.getAttribute('data-center');
            const optionAcademicYear = option.getAttribute('data-academic-year');
            
            const centerMatch = !selectedCenter || optionCenter === selectedCenter;
            const academicYearMatch = !selectedAcademicYear || optionAcademicYear === selectedAcademicYear;
            
            if (centerMatch && academicYearMatch) {
                subjectAllocationSelect.appendChild(option.cloneNode(true));
            }
        });

        // Filter venues by center only
        originalVenueOptions.forEach(option => {
            const optionCenter = option.getAttribute('data-center');
            if (!selectedCenter || optionCenter === selectedCenter) {
                venueSelect.appendChild(option.cloneNode(true));
            }
        });
    }

    function calculateEndTime() {
        const startTime = startTimeInput.value;
        console.log('Start time value:', startTime);
        
        if (startTime) {
            // Handle both 24-hour format (HH:MM) and potential browser variations
            let timeValue = startTime;
            
            // If the browser returns time in 12-hour format, convert it
            if (timeValue.includes('AM') || timeValue.includes('PM')) {
                const timeParts = timeValue.replace(/\s*(AM|PM)/i, '').split(':');
                let hours = parseInt(timeParts[0]);
                const minutes = parseInt(timeParts[1]);
                
                if (timeValue.toUpperCase().includes('PM') && hours !== 12) {
                    hours += 12;
                } else if (timeValue.toUpperCase().includes('AM') && hours === 12) {
                    hours = 0;
                }
                
                timeValue = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
            }
            
            const [hours, minutes] = timeValue.split(':').map(Number);
            console.log('Parsed hours:', hours, 'minutes:', minutes);
            
            const startDate = new Date();
            startDate.setHours(hours, minutes, 0, 0);
            
            // Add class duration
            const endDate = new Date(startDate.getTime() + (defaultDuration * 60000));
            
            // Format end time as HH:MM
            const endHours = endDate.getHours().toString().padStart(2, '0');
            const endMinutes = endDate.getMinutes().toString().padStart(2, '0');
            
            endTimeInput.value = `${endHours}:${endMinutes}`;
            console.log('Calculated end time:', endTimeInput.value);
        } else {
            endTimeInput.value = '';
        }
    }

    academicYearSelect.addEventListener('change', function() {
        filterOptions();
        checkForConflicts();
    });
    centerSelect.addEventListener('change', function() {
        filterOptions();
        checkForConflicts();
    });
    subjectAllocationSelect.addEventListener('change', checkForConflicts);
    venueSelect.addEventListener('change', checkForConflicts);
    dayOfWeekSelect.addEventListener('change', checkForConflicts);
    startTimeInput.addEventListener('change', function() {
        calculateEndTime();
        checkForConflicts();
    });
    effectiveFromInput.addEventListener('change', checkForConflicts);
    
    // Initial setup
    filterOptions();
    calculateEndTime();
    
    // Debug: Check if defaultDuration is properly set
    console.log('Default duration:', defaultDuration);
});
</script>
@endsection
