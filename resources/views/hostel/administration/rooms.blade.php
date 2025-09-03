@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Rooms</h4>
                    <div>
                        @if($blocks->count() > 1)
                        <select class="form-control d-inline-block mr-2" style="width: auto;" onchange="filterByBlock(this.value)">
                            <option value="">All Blocks</option>
                            @foreach($blocks as $block)
                            <option value="{{ $block->id }}" {{ $blockId == $block->id ? 'selected' : '' }}>
                                {{ $block->hostel->name }} - {{ $block->name }}
                            </option>
                            @endforeach
                        </select>
                        @endif
                        <a href="{{ route('hostel.administration.rooms.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Add New Room
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped" id="roomsTable">
                            <thead>
                                <tr>
                                    <th>Hostel</th>
                                    <th>Block</th>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Floor</th>
                                    <th>Bed Capacity</th>
                                    <th>Occupied Beds</th>
                                    <th>Room Fee</th>
                                    <th>Amenities</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                <tr>
                                    <td>{{ $room->hostel->name }}</td>
                                    <td>{{ $room->block->name }}</td>
                                    <td>{{ $room->room_number }}</td>
                                    <td>{{ ucfirst($room->room_type) }}</td>
                                    <td>{{ $room->floor_number }}</td>
                                    <td>{{ $room->bed_capacity }}</td>
                                    <td>{{ $room->occupied_beds }}</td>
                                    <td>${{ number_format($room->room_fee, 2) }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            @if($room->has_bathroom)
                                                <span class="badge badge-info mr-1 mb-1">Bathroom</span>
                                            @endif
                                            @if($room->has_ac)
                                                <span class="badge badge-success mr-1 mb-1">AC</span>
                                            @endif
                                            @if($room->has_wifi)
                                                <span class="badge badge-primary mr-1 mb-1">WiFi</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <a href="{{ route('hostel.administration.beds', $room->id) }}" 
                                               class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;" title="View Beds">
                                                <i class="fas fa-bed"></i> Beds
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">
                                        No rooms found. 
                                        @if($blocks->count() > 0)
                                            <a href="{{ route('hostel.administration.rooms.create') }}">Create your first room</a>
                                        @else
                                            <a href="{{ route('hostel.administration.blocks.create') }}">Create a block first</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterByBlock(blockId) {
    if (blockId) {
        window.location.href = "{{ route('hostel.administration.rooms', '') }}/" + blockId;
    } else {
        window.location.href = "{{ route('hostel.administration.rooms', '') }}";
    }
}
</script>
@endsection

@push('dataTableScript')
<script>
$(document).ready(function() {
    $('#roomsTable').DataTable({
        "responsive": true,
        "order": [[0, "asc"], [1, "asc"], [2, "asc"]]
    });
});
</script>
@endpush
