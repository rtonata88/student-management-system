@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-eye"></i> Notice Details</h4>
                    <div>
                        @permission('edit-notice')
                        <a href="{{ route('notice-board.edit', $notice->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endpermission
                        <a href="{{ route('notice-board.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Notices
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h2 class="mb-3">{{ $notice->title }}</h2>
                            <div class="mb-3">
                                <span class="badge {{ $notice->category_badge }} mr-2">{{ $notice->category }}</span>
                                <span class="badge {{ $notice->status_badge }} mr-2">{{ $notice->status_text }}</span>
                                <span class="badge badge-secondary">{{ $notice->target_campus }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-user"></i> Created by: {{ $notice->creator->name ?? 'Unknown' }}<br>
                                    <i class="fas fa-calendar"></i> Date: {{ $notice->created_at->format('d M Y, H:i') }}<br>
                                    <i class="fas fa-clock"></i> Updated: {{ $notice->updated_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">Short Description</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $notice->short_description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Notice Content</h5>
                                </div>
                                <div class="card-body">
                                    <div style="white-space: pre-wrap;">{{ $notice->body }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($notice->attachments && count($notice->attachments) > 0)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-paperclip"></i> Attachments ({{ count($notice->attachments) }})</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($notice->attachments as $attachment)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card border">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-3">
                                                                    @php
                                                                        $extension = pathinfo($attachment['name'], PATHINFO_EXTENSION);
                                                                        $iconClass = 'fas fa-file';
                                                                        if (in_array($extension, ['pdf'])) $iconClass = 'fas fa-file-pdf text-danger';
                                                                        elseif (in_array($extension, ['doc', 'docx'])) $iconClass = 'fas fa-file-word text-primary';
                                                                        elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) $iconClass = 'fas fa-file-image text-success';
                                                                    @endphp
                                                                    <i class="{{ $iconClass }} fa-2x"></i>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1">{{ $attachment['name'] }}</h6>
                                                                    <small class="text-muted">{{ number_format($attachment['size'] / 1024, 2) }} KB</small>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2">
                                                                <a href="{{ \Illuminate\Support\Facades\Storage::url($attachment['path']) }}" target="_blank" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Target Information:</strong><br>
                                            <small class="text-muted">
                                                Campus: {{ $notice->target_campus }}<br>
                                                Status: {{ $notice->status_text }}<br>
                                                Category: {{ $notice->category }}
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-right">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
