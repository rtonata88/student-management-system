@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Add New Student Block</h4>
                    <a href="{{ route('student-blocks.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Student Blocks
                    </a>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <!-- Info Alert -->
                            <div class="alert alert-info mb-4" style="border: 2px solid #6f42c1; background: linear-gradient(135deg, rgba(111, 66, 193, 0.1) 0%, rgba(0, 123, 255, 0.1) 100%);">
                                <h6 class="text-primary"><i class="fa fa-info-circle"></i> Multiple Student Numbers</h6>
                                <p class="mb-0 text-muted">You can provide more than one student number separated by a comma (with or without space between student numbers). Example: 202381892,202987182.</p>
                            </div>

                            <form action="{{ route('student-blocks.store') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="student_numbers">Student Number <span class="text-danger">*</span></label>
                                    <textarea name="student_numbers" id="student_numbers" class="form-control @error('student_numbers') is-invalid @enderror" 
                                              rows="4" placeholder="Example: 202381892,202987182" required>{{ old('student_numbers') }}</textarea>
                                    @error('student_numbers')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="block_amount">Block Amount</label>
                                    <input type="number" name="block_amount" id="block_amount" class="form-control @error('block_amount') is-invalid @enderror" 
                                           step="0.01" min="0" placeholder="0.00" value="{{ old('block_amount') }}">
                                    @error('block_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="reason">Reason <span class="text-danger">*</span></label>
                                    <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" 
                                              rows="4" placeholder="Enter reason here..." required>{{ old('reason') }}</textarea>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn mr-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.5rem 2rem;">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                    
                                    @can('bulk-block-students')
                                        <button type="button" class="btn mr-3" data-toggle="modal" data-target="#bulkBlockModal" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.5rem 2rem;">
                                            <i class="fa fa-users"></i> Bulk Block
                                        </button>
                                    @endcan
                                    
                                    <a href="{{ route('student-blocks.index') }}" class="btn btn-secondary" style="padding: 0.5rem 2rem;">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Block Modal -->
@can('bulk-block-students')
<div class="modal fade" id="bulkBlockModal" tabindex="-1" role="dialog" aria-labelledby="bulkBlockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkBlockModalLabel">Bulk Block Students</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('student-blocks.bulk-block.process') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulk_center_id">Center *</label>
                                <select name="center_id" id="bulk_center_id" class="form-control" required>
                                    <option value="">Select Center</option>
                                    @foreach(App\Center::all() as $center)
                                        <option value="{{ $center->id }}">{{ $center->center_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulk_gender">Gender</label>
                                <select name="gender" id="bulk_gender" class="form-control">
                                    <option value="">All Genders</option>
                                    @foreach(App\Student::distinct()->pluck('gender')->filter() as $gender)
                                        <option value="{{ $gender }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulk_block_amount">Amount *</label>
                                <input type="number" name="block_amount" id="bulk_block_amount" class="form-control" step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="exclude_bursary" id="exclude_bursary" class="form-check-input">
                                    <label class="form-check-label" for="exclude_bursary">
                                        Do not block bursary-linked students
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bulk_reason">Reason *</label>
                        <textarea name="reason" id="bulk_reason" class="form-control" rows="3" placeholder="Enter reason here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fa fa-users"></i> Bulk Block Students
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

@endsection
