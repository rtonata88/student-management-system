@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Room</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('hostel.administration.rooms.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hostel_id">Hostel <span class="text-danger">*</span></label>
                                    <select class="form-control @error('hostel_id') is-invalid @enderror" 
                                            id="hostel_id" name="hostel_id" required onchange="loadBlocks()">
                                        <option value="">Select Hostel</option>
                                        @foreach($hostels as $hostel)
                                        <option value="{{ $hostel->id }}" {{ old('hostel_id') == $hostel->id ? 'selected' : '' }}>
                                            {{ $hostel->name }} ({{ $hostel->code }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('hostel_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="block_id">Block <span class="text-danger">*</span></label>
                                    <select class="form-control @error('block_id') is-invalid @enderror" 
                                            id="block_id" name="block_id" required>
                                        <option value="">Select Block</option>
                                        @foreach($blocks as $block)
                                        <option value="{{ $block->id }}" data-hostel="{{ $block->hostel_id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>
                                            {{ $block->hostel->name }} - {{ $block->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('block_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_number">Room Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                                           id="room_number" name="room_number" value="{{ old('room_number') }}" required>
                                    @error('room_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_type">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('room_type') is-invalid @enderror" 
                                            id="room_type" name="room_type" required>
                                        <option value="">Select Room Type</option>
                                        <option value="standard" {{ old('room_type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                        <option value="deluxe" {{ old('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                        <option value="suite" {{ old('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                    </select>
                                    @error('room_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="floor_number">Floor Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('floor_number') is-invalid @enderror" 
                                           id="floor_number" name="floor_number" value="{{ old('floor_number', 1) }}" 
                                           min="1" required>
                                    @error('floor_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bed_capacity">Bed Capacity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('bed_capacity') is-invalid @enderror" 
                                           id="bed_capacity" name="bed_capacity" value="{{ old('bed_capacity', 2) }}" 
                                           min="1" required>
                                    @error('bed_capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="room_fee">Room Fee <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" step="0.01" class="form-control @error('room_fee') is-invalid @enderror" 
                                       id="room_fee" name="room_fee" value="{{ old('room_fee') }}" required>
                            </div>
                            @error('room_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="has_bathroom" name="has_bathroom" 
                                               value="1" {{ old('has_bathroom', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_bathroom">
                                            Has Bathroom
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="has_ac" name="has_ac" 
                                               value="1" {{ old('has_ac') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_ac">
                                            Has Air Conditioning
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="has_wifi" name="has_wifi" 
                                               value="1" {{ old('has_wifi', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_wifi">
                                            Has WiFi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Room</button>
                            <a href="{{ route('hostel.administration.rooms') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadBlocks() {
    const hostelId = document.getElementById('hostel_id').value;
    const blockSelect = document.getElementById('block_id');
    const options = blockSelect.querySelectorAll('option');
    
    // Show/hide options based on selected hostel
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            const blockHostelId = option.getAttribute('data-hostel');
            option.style.display = (hostelId === '' || blockHostelId === hostelId) ? 'block' : 'none';
        }
    });
    
    // Reset block selection if current selection is not valid for the hostel
    if (blockSelect.value !== '') {
        const selectedOption = blockSelect.querySelector(`option[value="${blockSelect.value}"]`);
        if (selectedOption && selectedOption.getAttribute('data-hostel') !== hostelId) {
            blockSelect.value = '';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadBlocks();
});
</script>
@endsection
