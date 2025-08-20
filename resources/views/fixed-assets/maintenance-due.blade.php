@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Maintenance Due</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Assets Requiring Maintenance</h5>
                    <small class="text-muted">Assets with overdue or upcoming maintenance schedules</small>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('fixed-assets.index') }}" class="btn btn-outline-secondary">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                        </svg>
                        Back to Assets
                    </a>
                    <a href="{{ route('fixed-assets.warranty-expired') }}" class="btn btn-outline-secondary">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}}"></use>
                        </svg>
                        Warranty Expired
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($assets->count() > 0)
                <!-- Summary Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->count() }}</div>
                                <small>Assets Need Maintenance</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->where('is_maintenance_overdue', true)->count() }}</div>
                                <small>Overdue Maintenance</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->whereIn('category.name', ['Computer Equipment', 'Audio Visual Equipment'])->count() }}</div>
                                <small>Tech Equipment</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->where('category.name', 'Vehicles')->count() }}</div>
                                <small>Vehicles</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Asset</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Last Maintenance</th>
                                <th>Next Due</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets->sortBy('next_maintenance_date') as $asset)
                            <tr class="{{ $asset->is_maintenance_overdue ? 'table-danger' : ($asset->is_maintenance_due_soon ? 'table-warning' : '') }}">
                                <td>
                                    <div>
                                        <strong>{{ $asset->name }}</strong>
                                        <br><small class="text-muted">{{ $asset->asset_tag }}</small>
                                        @if($asset->brand || $asset->model)
                                        <br><small class="text-muted">{{ $asset->brand }} {{ $asset->model }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light" style="background-color: {{ $asset->category->color }}20; color: {{ $asset->category->color }};">
                                        {{ $asset->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $asset->location }}</strong>
                                        @if($asset->department)
                                        <br><small class="text-muted">{{ $asset->department }}</small>
                                        @endif
                                        @if($asset->assigned_to)
                                        <br><small class="text-muted">Assigned: {{ $asset->assigned_to }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($asset->last_maintenance_date)
                                        {{ \Carbon\Carbon::parse($asset->last_maintenance_date)->format('M d, Y') }}
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($asset->last_maintenance_date)->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asset->next_maintenance_date)
                                        {{ \Carbon\Carbon::parse($asset->next_maintenance_date)->format('M d, Y') }}
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($asset->next_maintenance_date)->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Not scheduled</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $asset->status_badge_color }}">
                                        {{ ucfirst($asset->status) }}
                                    </span>
                                    <br><span class="badge badge-{{ $asset->condition_badge_color }}">
                                        {{ ucfirst($asset->condition) }}
                                    </span>
                                </td>
                                <td>
                                    @if($asset->is_maintenance_overdue)
                                        <span class="badge badge-danger">Overdue</span>
                                    @elseif($asset->is_maintenance_due_soon)
                                        <span class="badge badge-warning">Due Soon</span>
                                    @else
                                        <span class="badge badge-info">Scheduled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('fixed-assets.show', $asset) }}" class="btn btn-sm btn-outline-secondary" title="View Details">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
                                            </svg>
                                        </a>
                                        @permission('fixed-assets-maintenance')
                                        <a href="{{ route('fixed-assets.schedule-maintenance', $asset) }}" class="btn btn-sm btn-primary" title="Schedule Maintenance">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                                            </svg>
                                        </a>
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Export Options -->
                <div class="mt-4">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-print')}}"></use>
                            </svg>
                            Print Report
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="exportToCSV()">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
                            </svg>
                            Export CSV
                        </button>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <svg class="c-icon c-icon-4xl text-success mb-3">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                    </svg>
                    <h5 class="text-success">All Assets Up to Date</h5>
                    <p class="text-muted">No assets currently require maintenance. Great job keeping everything maintained!</p>
                    <a href="{{ route('fixed-assets.index') }}" class="btn btn-primary">
                        Back to Assets
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.querySelector('table');
    const rows = Array.from(table.querySelectorAll('tr'));
    
    const csvContent = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('th, td'));
        return cells.map(cell => {
            const text = cell.textContent.trim().replace(/\s+/g, ' ');
            return `"${text.replace(/"/g, '""')}"`;
        }).join(',');
    }).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'maintenance-due-report.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>
@endsection
