@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Warranty Expired</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Assets with Expired Warranties</h5>
                    <small class="text-muted">Assets with expired or expiring warranties requiring attention</small>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('fixed-assets.index') }}" class="btn btn-outline-secondary">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                        </svg>
                        Back to Assets
                    </a>
                    <a href="{{ route('fixed-assets.maintenance-due') }}" class="btn btn-outline-secondary">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                        </svg>
                        Maintenance Due
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($assets->count() > 0)
                <!-- Summary Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->where('is_warranty_expired', true)->count() }}</div>
                                <small>Expired Warranties</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->where('is_warranty_expiring_soon', true)->count() }}</div>
                                <small>Expiring Soon</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">${{ number_format($assets->sum('purchase_cost'), 0) }}</div>
                                <small>Total Asset Value</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <div class="h3 mb-0">{{ $assets->groupBy('category.name')->count() }}</div>
                                <small>Categories Affected</small>
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
                                <th>Purchase Info</th>
                                <th>Warranty Period</th>
                                <th>Status</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets->sortBy('warranty_end_date') as $asset)
                            <tr class="{{ $asset->is_warranty_expired ? 'table-danger' : 'table-warning' }}">
                                <td>
                                    <div>
                                        <strong>{{ $asset->name }}</strong>
                                        <br><small class="text-muted">{{ $asset->asset_tag }}</small>
                                        @if($asset->brand || $asset->model)
                                        <br><small class="text-muted">{{ $asset->brand }} {{ $asset->model }}</small>
                                        @endif
                                        @if($asset->serial_number)
                                        <br><small class="text-muted">S/N: {{ $asset->serial_number }}</small>
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
                                        <strong>${{ number_format($asset->purchase_cost, 2) }}</strong>
                                        @if($asset->purchase_date)
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($asset->purchase_date)->format('M d, Y') }}</small>
                                        @endif
                                        @if($asset->supplier)
                                        <br><small class="text-muted">{{ $asset->supplier }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($asset->warranty_start_date && $asset->warranty_end_date)
                                        <strong>{{ \Carbon\Carbon::parse($asset->warranty_start_date)->format('M d, Y') }}</strong>
                                        <br><small class="text-muted">to</small>
                                        <br><strong>{{ \Carbon\Carbon::parse($asset->warranty_end_date)->format('M d, Y') }}</strong>
                                        @elseif($asset->warranty_end_date)
                                        <strong>Expires: {{ \Carbon\Carbon::parse($asset->warranty_end_date)->format('M d, Y') }}</strong>
                                        @else
                                        <span class="text-muted">Not specified</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($asset->is_warranty_expired)
                                        <span class="badge badge-danger">Expired</span>
                                        @if($asset->warranty_end_date)
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($asset->warranty_end_date)->diffForHumans() }}</small>
                                        @endif
                                    @elseif($asset->is_warranty_expiring_soon)
                                        <span class="badge badge-warning">Expiring Soon</span>
                                        @if($asset->warranty_end_date)
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($asset->warranty_end_date)->diffForHumans() }}</small>
                                        @endif
                                    @endif
                                    
                                    @if($asset->warranty_details)
                                    <br><small class="text-muted">{{ Str::limit($asset->warranty_details, 30) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $asset->location }}</strong>
                                        @if($asset->department)
                                        <br><small class="text-muted">{{ $asset->department }}</small>
                                        @endif
                                        @if($asset->assigned_to)
                                        <br><small class="text-muted">{{ $asset->assigned_to }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('fixed-assets.show', $asset) }}" class="btn btn-sm btn-outline-secondary" title="View Details">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
                                            </svg>
                                        </a>
                                        @permission('fixed-assets-edit')
                                        <a href="{{ route('fixed-assets.edit', $asset) }}" class="btn btn-sm btn-outline-primary" title="Update Warranty">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
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

                <!-- Recommendations -->
                <div class="alert alert-info mt-4">
                    <h6 class="alert-heading">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-lightbulb')}}"></use>
                        </svg>
                        Recommendations
                    </h6>
                    <ul class="mb-0">
                        <li><strong>Expired Warranties:</strong> Consider extended warranty options or budget for potential repair costs</li>
                        <li><strong>Expiring Soon:</strong> Contact suppliers to renew warranties before expiration</li>
                        <li><strong>High-Value Assets:</strong> Prioritize warranty renewals for expensive equipment</li>
                        <li><strong>Critical Equipment:</strong> Ensure backup plans for assets without warranty coverage</li>
                    </ul>
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
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-shield-alt')}}"></use>
                    </svg>
                    <h5 class="text-success">All Warranties Current</h5>
                    <p class="text-muted">No assets have expired or expiring warranties. All equipment is properly covered!</p>
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
    a.download = 'warranty-expired-report.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>
@endsection
