@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-graduation-cap"></i> Promotional Statuses
                        </h4>
                        @if(Auth::user()->hasPermission('add-promotional-statuses'))
                            <a href="{{ route('promotional-statuses.create') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('promotional-statuses.index') }}" class="form-inline">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" name="search" class="form-control" placeholder="Search by description or promotion status..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if($search)
                                            <a href="{{ route('promotional-statuses.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <small class="text-muted">
                                Showing {{ $promotionalStatuses->firstItem() ?? 0 }} to {{ $promotionalStatuses->lastItem() ?? 0 }} 
                                of {{ $promotionalStatuses->total() }} results
                            </small>
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <tr>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Promoted (Yes/No)</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Description</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Active</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promotionalStatuses as $status)
                                <tr>
                                    <td style="padding: 16px 12px;">
                                        <span class="badge {{ $status->promoted_badge }}">
                                            {{ $status->promoted }}
                                        </span>
                                    </td>
                                    <td style="padding: 16px 12px; font-weight: 500;">{{ $status->description }}</td>
                                    <td style="padding: 16px 12px;">
                                        <label class="c-switch c-switch-pill c-switch-success">
                                            <input type="checkbox" class="c-switch-input" {{ $status->active ? 'checked' : '' }} disabled>
                                            <span class="c-switch-slider"></span>
                                        </label>
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        <div class="btn-group" role="group">
                                            @if(Auth::user()->hasPermission('edit-promotional-statuses'))
                                                <a href="{{ route('promotional-statuses.edit', $status->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if(Auth::user()->hasPermission('delete-promotional-statuses'))
                                                <form action="{{ route('promotional-statuses.destroy', $status->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this promotional status?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center" style="padding: 40px; color: #6c757d;">
                                        <i class="fas fa-graduation-cap fa-3x mb-3" style="opacity: 0.3;"></i>
                                        <p class="mb-0">No promotional statuses found. Use the search above or <a href="{{ route('promotional-statuses.create') }}">add a new promotional status</a>.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($promotionalStatuses->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $promotionalStatuses->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
