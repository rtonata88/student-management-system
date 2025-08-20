@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Beds</h4>
                    <div>
                        @if($rooms->count() > 1)
                        <select class="form-control d-inline-block mr-2" style="width: auto;" onchange="filterByRoom(this.value)">
                            <option value="">All Rooms</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $roomId == $room->id ? 'selected' : '' }}>
                                {{ $room->hostel->name }} - {{ $room->block->name }} - Room {{ $room->room_number }}
                            </option>
                            @endforeach
                        </select>
                        @endif
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
                        <table class="table table-striped" id="bedsTable">
                            <thead>
                                <tr>
                                    <th>Hostel</th>
                                    <th>Block</th>
                                    <th>Room</th>
                                    <th>Bed Number</th>
                                    <th>Bed Type</th>
                                    <th>Bed Fee</th>
                                    <th>Current Student</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beds as $bed)
                                <tr>
                                    <td>{{ $bed->hostel->name }}</td>
                                    <td>{{ $bed->block->name }}</td>
                                    <td>{{ $bed->room->room_number }}</td>
                                    <td>{{ $bed->bed_number }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $bed->bed_type)) }}</td>
                                    <td>${{ number_format($bed->bed_fee, 2) }}</td>
                                    <td>
                                        @if($bed->allocation && $bed->allocation->student)
                                            <div>
                                                <strong>{{ $bed->allocation->student->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $bed->allocation->student->email }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">Not allocated</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $bed->status == 'available' ? 'success' : ($bed->status == 'occupied' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($bed->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($bed->status == 'available')
                                            <a href="{{ route('hostel.administration.allocations.create') }}?bed_id={{ $bed->id }}" 
                                               class="btn btn-sm btn-outline-success" title="Allocate Student">
                                                <i class="fas fa-user-plus"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        No beds found. 
                                        @if($rooms->count() > 0)
                                            Beds are automatically created when rooms are added.
                                        @else
                                            <a href="{{ route('hostel.administration.rooms.create') }}">Create a room first</a>
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
function filterByRoom(roomId) {
    if (roomId) {
        window.location.href = "{{ route('hostel.administration.beds', '') }}/" + roomId;
    } else {
        window.location.href = "{{ route('hostel.administration.beds', '') }}";
    }
}
</script>
@endsection

@push('dataTableScript')
<script>
$(document).ready(function() {
    $('#bedsTable').DataTable({
        "responsive": true,
        "order": [[0, "asc"], [1, "asc"], [2, "asc"], [3, "asc"]]
    });
});
</script>
@endpush
