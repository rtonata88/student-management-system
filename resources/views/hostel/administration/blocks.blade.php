@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Hostel Blocks</h4>
                    <div>
                        @if($hostels->count() > 1)
                        <select class="form-control d-inline-block mr-2" style="width: auto;" onchange="filterByHostel(this.value)">
                            <option value="">All Hostels</option>
                            @foreach($hostels as $hostel)
                            <option value="{{ $hostel->id }}" {{ $hostelId == $hostel->id ? 'selected' : '' }}>
                                {{ $hostel->name }}
                            </option>
                            @endforeach
                        </select>
                        @endif
                        <a href="{{ route('hostel.administration.blocks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Block
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
                        <table class="table table-striped" id="blocksTable">
                            <thead>
                                <tr>
                                    <th>Hostel</th>
                                    <th>Block Name</th>
                                    <th>Block Code</th>
                                    <th>Description</th>
                                    <th>Floor Count</th>
                                    <th>Total Rooms</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blocks as $block)
                                <tr>
                                    <td>{{ $block->hostel->name }}</td>
                                    <td>{{ $block->name }}</td>
                                    <td>{{ $block->code }}</td>
                                    <td>{{ Str::limit($block->description, 50) ?: 'No description' }}</td>
                                    <td>{{ $block->floor_count }}</td>
                                    <td>{{ $block->rooms->count() }}</td>
                                    <td>
                                        <span class="badge badge-{{ $block->gender == 'male' ? 'primary' : ($block->gender == 'female' ? 'danger' : 'info') }}">
                                            {{ ucfirst($block->gender) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $block->is_active ? 'success' : 'secondary' }}">
                                            {{ $block->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="{{ route('hostel.administration.rooms', $block->id) }}" 
                                               class="btn btn-sm btn-outline-success" title="View Rooms">
                                                <i class="fas fa-door-open"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        No blocks found. 
                                        @if($hostels->count() > 0)
                                            <a href="{{ route('hostel.administration.blocks.create') }}">Create your first block</a>
                                        @else
                                            <a href="{{ route('hostel.administration.hostels.create') }}">Create a hostel first</a>
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
function filterByHostel(hostelId) {
    if (hostelId) {
        window.location.href = "{{ route('hostel.administration.blocks', '') }}/" + hostelId;
    } else {
        window.location.href = "{{ route('hostel.administration.blocks') }}";
    }
}
</script>
@endsection

@push('dataTableScript')
<script>
$(document).ready(function() {
    $('#blocksTable').DataTable({
        "responsive": true,
        "order": [[0, "asc"], [1, "asc"]]
    });
});
</script>
@endpush
