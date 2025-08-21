@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">
            <a href="#" onclick="history.back()" class="text-muted">
                <svg class="c-icon" style="width: 16px; height: 16px;">
                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                </svg>
                Settings
            </a>
        </li>
        <li class="breadcrumb-item active">Examinations</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('examinations.index') }}" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search examinations..." value="{{ $search }}" style="width: 300px;">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <svg class="c-icon">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @permission('add-examinations')
                <a href="/examinations/create" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <svg class="c-icon mr-1">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                    </svg>
                    Add New
                </a>
                @endpermission
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('success') }}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('error') }}
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover" style="width:100%">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="font-weight: 600; color: #6c757d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">EXAMINATION NAME</th>
                                <th style="font-weight: 600; color: #6c757d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">CODE</th>
                                <th style="font-weight: 600; color: #6c757d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">MARK CAP (%)</th>
                                <th style="font-weight: 600; color: #6c757d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">ACTIVE</th>
                                <th style="font-weight: 600; color: #6c757d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examinations as $examination)
                            <tr>
                                <td style="padding: 16px 12px; font-weight: 500;">{{ $examination->name }}</td>
                                <td style="padding: 16px 12px; color: #6c757d;">{{ $examination->code }}</td>
                                <td style="padding: 16px 12px; color: #6c757d;">{{ number_format($examination->mark_cap, 2) }}</td>
                                <td style="padding: 16px 12px;">
                                    <label class="c-switch c-switch-pill c-switch-success">
                                        <input type="checkbox" class="c-switch-input" {{ $examination->active ? 'checked' : '' }} disabled>
                                        <span class="c-switch-slider"></span>
                                    </label>
                                </td>
                                <td style="padding: 16px 12px;">
                                    @permission('edit-examinations')
                                    <a href="/examinations/{{ $examination->id }}/edit" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px; padding: 6px 12px;">
                                        Edit
                                    </a>
                                    @endpermission
                                    @permission('delete-examinations')
                                    <form method="POST" action="/examinations/{{ $examination->id }}" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this examination?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ml-1" style="border-radius: 6px; padding: 6px 12px;">
                                            Delete
                                        </button>
                                    </form>
                                    @endpermission
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4" style="color: #6c757d;">
                                    @if($search)
                                        No examinations found matching "{{ $search }}"
                                    @else
                                        No examinations found. <a href="/examinations/create">Create your first examination</a>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($examinations->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $examinations->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}

.c-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
}

.c-switch-input {
    opacity: 0;
    width: 0;
    height: 0;
}

.c-switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.c-switch-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.c-switch-input:checked + .c-switch-slider {
    background-color: #20c997;
}

.c-switch-input:checked + .c-switch-slider:before {
    transform: translateX(20px);
}
</style>
@endsection
