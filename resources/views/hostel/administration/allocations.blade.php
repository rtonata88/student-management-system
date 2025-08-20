@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Student Allocations</h4>
                    <a href="{{ route('hostel.administration.allocations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Allocate Student
                    </a>
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
                        <table class="table table-striped" id="allocationsTable">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Hostel</th>
                                    <th>Block</th>
                                    <th>Room</th>
                                    <th>Bed</th>
                                    <th>Allocation Date</th>
                                    <th>Check-in Date</th>
                                    <th>Monthly Fee</th>
                                    <th>Security Deposit</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allocations as $allocation)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $allocation->student->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $allocation->student->email ?? '' }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $allocation->hostel->name }}</td>
                                    <td>{{ $allocation->block->name }}</td>
                                    <td>{{ $allocation->room->room_number }}</td>
                                    <td>{{ $allocation->bed->bed_number }}</td>
                                    <td>{{ $allocation->allocation_date->format('d/m/Y') }}</td>
                                    <td>{{ $allocation->check_in_date ? $allocation->check_in_date->format('d/m/Y') : 'Not checked in' }}</td>
                                    <td>${{ number_format($allocation->monthly_fee, 2) }}</td>
                                    <td>${{ number_format($allocation->security_deposit, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $allocation->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($allocation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($allocation->status == 'active')
                                            <button class="btn btn-sm btn-outline-warning" title="Check Out">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                            @endif
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
    $('#allocationsTable').DataTable({
        "responsive": true,
        "order": [[5, "desc"]]
    });
});
</script>
@endpush
