@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">Examination Schedule</li>
        <li class="breadcrumb-item active">Manage Venues</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-building"></i> Manage Venues
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('examination-schedule.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 5px;">
                                    <i class="fa fa-arrow-left"></i> Back to Schedule
                                </a>
                                @if(Auth::user()->hasPermission('create-venue'))
                                    <a href="{{ route('venues.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-plus"></i> Add Venue
                                    </a>
                                @endif
                            </div>
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
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Venue Name</th>
                                        <th>Code</th>
                                        <th>Centre</th>
                                        <th>Type</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($venues as $venue)
                                        <tr>
                                            <td>
                                                <strong>{{ $venue->venue_name }}</strong>
                                                @if($venue->description)
                                                    <br><small class="text-muted">{{ $venue->description }}</small>
                                                @endif
                                            </td>
                                            <td><span class="badge badge-info">{{ $venue->venue_code }}</span></td>
                                            <td>{{ $venue->center->center_name ?? 'N/A' }}</td>
                                            <td>{{ $venue->venue_type }}</td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    {{ $venue->capacity }} students
                                                </span>
                                            </td>
                                            <td>
                                                @if($venue->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if(Auth::user()->hasPermission('edit-venue'))
                                                        <a href="{{ route('venues.edit', $venue) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('venues.toggle-status', $venue) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;" 
                                                                    onclick="return confirm('Are you sure you want to {{ $venue->is_active ? 'deactivate' : 'activate' }} this venue?')">
                                                                <i class="fa fa-{{ $venue->is_active ? 'pause' : 'play' }}"></i> {{ $venue->is_active ? 'Disable' : 'Enable' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-venue'))
                                                        <form action="{{ route('venues.destroy', $venue) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;" 
                                                                    onclick="return confirm('Are you sure you want to delete this venue?')">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No venues found</h5>
                                                    <p class="text-muted">Create your first venue to get started.</p>
                                                    @if(Auth::user()->hasPermission('create-venue'))
                                                        <a href="{{ route('venues.create') }}" class="btn btn-primary">
                                                            <i class="fa fa-plus"></i> Add Venue
                                                        </a>
                                                    @endif
                                                </div>
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
</div>
@endsection
