@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.show', $asset) }}">{{ $asset->asset_tag }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule Maintenance</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Asset Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Asset Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="color-indicator mr-3" 
                                 style="width: 20px; height: 20px; background-color: {{ $asset->category->color }}; border-radius: 3px;">
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $asset->name }}</h6>
                                <small class="text-muted">{{ $asset->asset_tag }}</small>
                            </div>
                        </div>

                        <table class="table table-sm">
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>{{ $asset->category->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Location:</strong></td>
                                <td>{{ $asset->location }}</td>
                            </tr>
                            @if($asset->department)
                            <tr>
                                <td><strong>Department:</strong></td>
                                <td>{{ $asset->department }}</td>
                            </tr>
                            @endif
                            @if($asset->assigned_to)
                            <tr>
                                <td><strong>Assigned To:</strong></td>
                                <td>{{ $asset->assigned_to }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $asset->status_badge_color }}">
                                        {{ ucfirst($asset->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Condition:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $asset->condition_badge_color }}">
                                        {{ ucfirst($asset->condition) }}
                                    </span>
                                </td>
                            </tr>
                        </table>

                        @if($asset->last_maintenance_date || $asset->next_maintenance_date)
                        <hr>
                        <h6 class="text-muted mb-2">Current Schedule</h6>
                        @if($asset->last_maintenance_date)
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Last Maintenance:</small>
                            <small>{{ \Carbon\Carbon::parse($asset->last_maintenance_date)->format('M d, Y') }}</small>
                        </div>
                        @endif
                        @if($asset->next_maintenance_date)
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Next Maintenance:</small>
                            <small class="{{ $asset->is_maintenance_due ? 'text-danger' : 'text-success' }}">
                                {{ \Carbon\Carbon::parse($asset->next_maintenance_date)->format('M d, Y') }}
                            </small>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>

                <!-- Recent Maintenance History -->
                @if($asset->maintenanceRecords->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Recent Maintenance</h6>
                    </div>
                    <div class="card-body">
                        @foreach($asset->maintenanceRecords->sortByDesc('date')->take(3) as $maintenance)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="badge badge-{{ $maintenance->type_badge_color }} mb-1">
                                        {{ ucfirst($maintenance->type) }}
                                    </span>
                                    <h6 class="mb-1">{{ $maintenance->description }}</h6>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($maintenance->date)->format('M d, Y') }}
                                        @if($maintenance->cost)
                                        • ${{ number_format($maintenance->cost, 2) }}
                                        @endif
                                    </small>
                                </div>
                                <span class="badge badge-{{ $maintenance->status_badge_color }}">
                                    {{ ucfirst($maintenance->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Maintenance Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Schedule Maintenance</h5>
                        <small class="text-muted">Schedule new maintenance for {{ $asset->name }}</small>
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

                        <form method="POST" action="{{ route('fixed-assets.process-maintenance-schedule', $asset) }}">
                            @csrf
                            
                            <!-- Maintenance Type and Date -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Maintenance Type <span class="text-danger">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="preventive" {{ old('type') == 'preventive' ? 'selected' : '' }}>Preventive</option>
                                            <option value="corrective" {{ old('type') == 'corrective' ? 'selected' : '' }}>Corrective</option>
                                            <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                            <option value="inspection" {{ old('type') == 'inspection' ? 'selected' : '' }}>Inspection</option>
                                            <option value="calibration" {{ old('type') == 'calibration' ? 'selected' : '' }}>Calibration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Maintenance Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date" name="date" 
                                               value="{{ old('date', date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="description" name="description" rows="3" 
                                                  placeholder="Describe the maintenance work to be performed..." required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Provider and Performer -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="performed_by">Performed By</label>
                                        <input type="text" class="form-control" id="performed_by" name="performed_by" 
                                               value="{{ old('performed_by') }}" placeholder="Name of person/team">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_provider">Service Provider</label>
                                        <input type="text" class="form-control" id="service_provider" name="service_provider" 
                                               value="{{ old('service_provider', 'Internal') }}" placeholder="Company or Internal">
                                    </div>
                                </div>
                            </div>

                            <!-- Cost and Status -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cost">Estimated Cost</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" id="cost" name="cost" 
                                                   step="0.01" min="0" value="{{ old('cost') }}" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="next_due_date">Next Due Date</label>
                                        <input type="date" class="form-control" id="next_due_date" name="next_due_date" 
                                               value="{{ old('next_due_date') }}">
                                        <small class="form-text text-muted">When is the next maintenance due?</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Parts and Notes -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parts_replaced">Parts Replaced/Used</label>
                                        <textarea class="form-control" id="parts_replaced" name="parts_replaced" rows="3" 
                                                  placeholder="List parts that were replaced or used (one per line)">{{ old('parts_replaced') }}</textarea>
                                        <small class="form-text text-muted">Enter each part on a new line</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="notes">Additional Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                  placeholder="Any additional notes or observations...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Asset Schedule -->
                            <div class="card bg-light mt-4">
                                <div class="card-body">
                                    <h6 class="card-title">Update Asset Maintenance Schedule</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="update_asset_schedule" name="update_asset_schedule" value="1" 
                                               {{ old('update_asset_schedule', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="update_asset_schedule">
                                            Update the asset's last and next maintenance dates based on this record
                                        </label>
                                        <small class="form-text text-muted">
                                            This will set the asset's last maintenance date to the date above and next maintenance date to the "Next Due Date" if specified.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                                    </svg>
                                    Schedule Maintenance
                                </button>
                                <a href="{{ route('fixed-assets.show', $asset) }}" class="btn btn-secondary ml-2">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                                    </svg>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-suggest next due date based on maintenance type
document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const dateField = document.getElementById('next_due_date');
    const maintenanceDate = document.getElementById('date').value;
    
    if (maintenanceDate && type) {
        const date = new Date(maintenanceDate);
        let monthsToAdd = 0;
        
        switch(type) {
            case 'preventive':
                monthsToAdd = 6; // 6 months
                break;
            case 'inspection':
                monthsToAdd = 12; // 1 year
                break;
            case 'calibration':
                monthsToAdd = 12; // 1 year
                break;
            case 'corrective':
            case 'emergency':
                monthsToAdd = 3; // 3 months follow-up
                break;
        }
        
        if (monthsToAdd > 0) {
            date.setMonth(date.getMonth() + monthsToAdd);
            dateField.value = date.toISOString().split('T')[0];
        }
    }
});

// Trigger the calculation when maintenance date changes
document.getElementById('date').addEventListener('change', function() {
    const typeField = document.getElementById('type');
    if (typeField.value) {
        typeField.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
