@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-bullhorn"></i> Notice Board</h4>
                    @permission('create-notice')
                    <a href="{{ route('notice-board.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Add Notice for Staff
                    </a>
                    @endpermission
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('notice-board.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search notices..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-3 text-right">
                                @permission('create-notice')
                                <a href="{{ route('notice-board.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-bullhorn"></i> Notice to Students
                                </a>
                                @endpermission
                            </div>
                        </div>
                    </form>

                    <!-- Notices List -->
                    @if($notices->count() > 0)
                        <div class="row">
                            @foreach($notices as $notice)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge {{ $notice->category_badge }}">{{ $notice->category }}</span>
                                                <span class="badge {{ $notice->status_badge }}">{{ $notice->status_text }}</span>
                                            </div>
                                            <small class="text-muted">{{ $notice->formatted_date }}</small>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $notice->title }}</h5>
                                            <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($notice->short_description, 100) }}</p>
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> {{ $notice->creator->name ?? 'Unknown' }} | 
                                                    <i class="fas fa-map-marker-alt"></i> {{ $notice->target_campus }}
                                                </small>
                                            </div>
                                            @if($notice->attachments && count($notice->attachments) > 0)
                                                <div class="mb-2">
                                                    <small class="text-info">
                                                        <i class="fas fa-paperclip"></i> {{ count($notice->attachments) }} attachment(s)
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('notice-board.show', $notice->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                @permission('edit-notice')
                                                <a href="{{ route('notice-board.edit', $notice->id) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                @endpermission
                                                @permission('publish-notice')
                                                <a href="{{ route('notice-board.toggle-publish', $notice->id) }}" class="btn btn-sm btn-outline-{{ $notice->publish ? 'secondary' : 'success' }}" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-{{ $notice->publish ? 'eye-slash' : 'eye' }}"></i> {{ $notice->publish ? 'Unpublish' : 'Publish' }}
                                                </a>
                                                @endpermission
                                                @permission('delete-notice')
                                                <form method="POST" action="{{ route('notice-board.destroy', $notice->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this notice?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                                @endpermission
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $notices->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No notices found</h5>
                            <p class="text-muted">Start by creating your first notice.</p>
                            @permission('create-notice')
                            <a href="{{ route('notice-board.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-plus"></i> Create Notice
                            </a>
                            @endpermission
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
