@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Service Details</h4>
                    <a href="{{ route('fleet.services') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Services
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Service Date:</strong>
                                <p>{{ $service->service_date->format('M d, Y') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Vehicle:</strong>
                                <p>{{ $service->vehicle->registration_number }} - {{ $service->vehicle->make }} {{ $service->vehicle->model }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Service Type:</strong>
                                <p><span class="badge badge-primary">{{ ucfirst($service->service_type) }}</span></p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Cost:</strong>
                                <p>${{ number_format($service->cost, 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Odometer Reading:</strong>
                                <p>{{ number_format($service->odometer_reading) }} km</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Status:</strong>
                                <p>
                                    <span class="badge badge-{{ $service->status === 'completed' ? 'success' : ($service->status === 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Service Provider:</strong>
                                <p>{{ $service->service_provider ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Next Service Due:</strong>
                                <p>{{ $service->next_service_date ? $service->next_service_date->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <strong>Description:</strong>
                                <div class="p-3 mt-2" style="background-color: #f8f9fa; border-radius: 6px; border-left: 4px solid #6f42c1;">
                                    {{ $service->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($service->notes)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <strong>Notes:</strong>
                                <div class="p-3 mt-2" style="background-color: #f8f9fa; border-radius: 6px; border-left: 4px solid #007bff;">
                                    {{ $service->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Created: {{ $service->created_at->format('M d, Y H:i') }}
                            </small>
                        </div>
                        <div>
                            <small class="text-muted">
                                Last Updated: {{ $service->updated_at->format('M d, Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
