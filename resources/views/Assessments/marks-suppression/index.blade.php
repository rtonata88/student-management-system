@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item active">Marks Suppression</li>
    </ol>
</div>
@endsection

@section('content')
<style>
    .search-container {
        max-width: 1200px;
        margin: 0 auto 2rem;
    }
    
    .search-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .search-header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 1.5rem 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .search-header h4 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    .search-form {
        padding: 2rem;
    }
    
    .form-group label {
        color: white;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-control:focus {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        color: #333;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        background: rgba(255, 255, 255, 1);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-search {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }
    
    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
        color: white;
    }
    
    .btn-reset {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-reset:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }
    
    .results-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .table th {
        background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .badge-suppressed {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-active {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <!-- Search Form -->
    <div class="search-container">
        <div class="search-card">
            <div class="search-header">
                <h4><i class="fas fa-filter"></i> Filter Suppressions</h4>
            </div>
            <div class="search-form">
                <form method="GET" action="{{ route('marks-suppression.index') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_year">Academic Year</label>
                                <select name="academic_year" id="academic_year" class="form-control">
                                    <option value="">Select academic year...</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year->id }}" {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                            {{ $year->academic_year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="campus">Centre</label>
                                <select name="campus" id="campus" class="form-control">
                                    <option value="">Select Centre</option>
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus }}" {{ request('campus') == $campus ? 'selected' : '' }}>
                                            {{ $campus }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mark_type">Suppression Mark Type</label>
                                <select name="mark_type" id="mark_type" class="form-control">
                                    <option value="">Select Suppression Mark Type</option>
                                    @foreach($markTypes as $type)
                                        <option value="{{ $type }}" {{ request('mark_type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-reset mr-3" onclick="window.location.href='{{ route('marks-suppression.index') }}'">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-search">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="results-card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
            <h5 class="mb-0"><i class="fas fa-ban"></i> Marks Suppression</h5>
            @permission('create-marks-suppression')
                <a href="{{ route('marks-suppression.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Add New
                </a>
            @endpermission
        </div>
        
        <div class="card-body p-0">
            @if($suppressions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ACADEMIC YEAR</th>
                                <th>CENTRE</th>
                                <th>MARK TYPE</th>
                                <th>SUPPRESS</th>
                                <th>REASON</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppressions as $suppression)
                                <tr>
                                    <td>{{ $suppression->academicYear->academic_year ?? 'N/A' }}</td>
                                    <td>{{ $suppression->campus }}</td>
                                    <td>{{ $suppression->mark_type }}</td>
                                    <td>
                                        @if($suppression->is_suppressed)
                                            <span class="badge badge-suppressed">
                                                <i class="fas fa-ban"></i> Suppressed
                                            </span>
                                        @else
                                            <span class="badge badge-active">
                                                <i class="fas fa-check"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($suppression->reason)
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reasonModal{{ $suppression->id }}">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        @else
                                            <span class="text-muted">No reason</span>
                                        @endif
                                    </td>
                                    <td>
                                        @permission('edit-marks-suppression')
                                            <form method="POST" action="{{ route('marks-suppression.toggle', $suppression) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm" 
                                                        style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"
                                                        onclick="return confirm('Are you sure you want to {{ $suppression->is_suppressed ? 'deactivate' : 'activate' }} this suppression?')">
                                                    {{ $suppression->is_suppressed ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('marks-suppression.edit', $suppression) }}" class="btn btn-sm btn-warning ml-1">
                                                <i class="fas fa-edit"></i> Update
                                            </a>
                                        @endpermission
                                        
                                        @permission('delete-marks-suppression')
                                            <form method="POST" action="{{ route('marks-suppression.destroy', $suppression) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ml-1" 
                                                        onclick="return confirm('Are you sure you want to delete this suppression?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endpermission
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Reason Modals -->
                @foreach($suppressions as $suppression)
                    @if($suppression->reason)
                        <div class="modal fade" id="reasonModal{{ $suppression->id }}" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel{{ $suppression->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                                        <h5 class="modal-title" id="reasonModalLabel{{ $suppression->id }}">
                                            <i class="fas fa-info-circle"></i> Reason for Suppression
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Academic Year:</strong></div>
                                            <div class="col-md-8">{{ $suppression->academicYear->academic_year ?? 'N/A' }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Centre:</strong></div>
                                            <div class="col-md-8">{{ $suppression->campus }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Mark Type:</strong></div>
                                            <div class="col-md-8">{{ $suppression->mark_type }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4"><strong>Status:</strong></div>
                                            <div class="col-md-8">
                                                @if($suppression->is_suppressed)
                                                    <span class="badge badge-suppressed">
                                                        <i class="fas fa-ban"></i> Suppressed
                                                    </span>
                                                @else
                                                    <span class="badge badge-active">
                                                        <i class="fas fa-check"></i> Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>Reason for Suppression:</strong>
                                                <div class="mt-2 p-3" style="background-color: #f8f9fa; border-left: 4px solid #6f42c1; border-radius: 4px;">
                                                    {{ $suppression->reason }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                
                <div class="card-footer">
                    {{ $suppressions->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-ban fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No marks suppressions found</h5>
                    <p class="text-muted">Try adjusting your search criteria or create a new suppression.</p>
                    @permission('create-marks-suppression')
                        <a href="{{ route('marks-suppression.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Create First Suppression
                        </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error('{{ session('error') }}');
    </script>
@endif
@endsection
