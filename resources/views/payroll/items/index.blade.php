@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item active">Payroll Items</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Payroll Items</h5>
                    <small class="text-muted">Manage earnings and deduction items for payroll processing</small>
                </div>
                @permission('create-payroll-items')
                <a href="{{route('payroll.items.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                    <i class="fas fa-plus"></i> Add Item
                </a>
                @endpermission
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Calculation Method</th>
                                <th>Amount/Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <strong>{{$item->item_name}}</strong>
                                    @if($item->description)
                                        <br><small class="text-muted">{{$item->description}}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{$item->item_type == 'earning' ? 'success' : 'warning'}}">
                                        {{ucfirst($item->item_type)}}
                                    </span>
                                </td>
                                <td>{{ucwords(str_replace('_', ' ', $item->calculation_method))}}</td>
                                <td>
                                    @if($item->calculation_method == 'percentage')
                                        {{$item->amount}}%
                                    @else
                                        N$ {{number_format($item->amount, 2)}}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{$item->is_active ? 'success' : 'secondary'}}">
                                        {{$item->is_active ? 'Active' : 'Inactive'}}
                                    </span>
                                </td>
                                <td>
                                    @permission('edit-payroll-items')
                                    <a href="{{route('payroll.items.edit', $item)}}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endpermission
                                    
                                    @permission('delete-payroll-items')
                                    <form method="POST" action="{{route('payroll.items.destroy', $item)}}" style="display: inline;" onsubmit="return confirm('Delete this payroll item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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
                
                <div class="d-flex justify-content-center">
                    {{$items->links()}}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-list-alt fa-3x text-muted mb-3"></i>
                    <h5>No Payroll Items Found</h5>
                    <p class="text-muted">Create payroll items to define earnings and deductions for employees.</p>
                    
                    @permission('create-payroll-items')
                    <a href="{{route('payroll.items.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Create First Item
                    </a>
                    @endpermission
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
