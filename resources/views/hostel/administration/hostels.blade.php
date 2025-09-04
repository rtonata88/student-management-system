@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Hostels</h4>
                    <div class="d-flex" style="gap: 10px;">
                        <a href="{{ route('hostel.administration.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('hostel.administration.hostels.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Add New Hostel
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
                        <table class="table table-striped" id="hostelsTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Warden</th>
                                    <th>Capacity</th>
                                    <th>Blocks</th>
                                    <th>Rooms</th>
                                    <th>Beds</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hostels as $hostel)
                                <tr>
                                    <td>{{ $hostel->name }}</td>
                                    <td>{{ $hostel->code }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($hostel->address, 30) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $hostel->gender == 'male' ? 'primary' : ($hostel->gender == 'female' ? 'danger' : 'info') }}">
                                            {{ ucfirst($hostel->gender) }}
                                        </span>
                                    </td>
                                    <td>{{ $hostel->warden_name ?: 'Not assigned' }}</td>
                                    <td>{{ $hostel->total_capacity }}</td>
                                    <td>{{ $hostel->blocks->count() }}</td>
                                    <td>{{ $hostel->rooms->count() }}</td>
                                    <td>{{ $hostel->beds->count() }}</td>
                                    <td>
                                        <span class="badge badge-{{ $hostel->is_active ? 'success' : 'secondary' }}">
                                            {{ $hostel->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hostel.administration.hostels.edit', $hostel) }}" 
                                               class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('hostel.administration.blocks', $hostel->id) }}" 
                                               class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;" title="View Blocks">
                                                <i class="fas fa-th-large"></i> Blocks
                                            </a>
                                            <a href="{{ route('hostel.administration.rooms', ['blockId' => null]) }}?hostel={{ $hostel->id }}" 
                                               class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;" title="View Rooms">
                                                <i class="fas fa-door-open"></i> Rooms
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('dataTableScript')
<script>
$(document).ready(function() {
    $('#hostelsTable').DataTable({
        "responsive": true,
        "order": [[0, "asc"]]
    });
});
</script>
@endpush
