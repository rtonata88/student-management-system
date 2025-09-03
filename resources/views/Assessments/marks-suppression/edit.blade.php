@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('marks-suppression.index') }}">Marks Suppression</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Marks Suppression</h5>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('marks-suppression.update', $marksSuppression) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="academic_year_id">Academic Year <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" id="academic_year_id" class="form-control" required>
                                        <option value="">Select Academic Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ old('academic_year_id', $marksSuppression->academic_year_id) == $year->id ? 'selected' : '' }}>
                                                {{ $year->academic_year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="campus">Centre <span class="text-danger">*</span></label>
                                    <select name="campus" id="campus" class="form-control" required>
                                        <option value="">Select Centre</option>
                                        @foreach($campuses as $campus)
                                            <option value="{{ $campus }}" {{ old('campus', $marksSuppression->campus) == $campus ? 'selected' : '' }}>
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
                                    <label for="mark_type">Mark Type <span class="text-danger">*</span></label>
                                    <select name="mark_type" id="mark_type" class="form-control" required>
                                        <option value="">Select Mark Type</option>
                                        @foreach($markTypes as $type)
                                            <option value="{{ $type }}" {{ old('mark_type', $marksSuppression->mark_type) == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="is_suppressed">Suppression Status <span class="text-danger">*</span></label>
                                    <select name="is_suppressed" id="is_suppressed" class="form-control" required>
                                        <option value="1" {{ old('is_suppressed', $marksSuppression->is_suppressed) == '1' ? 'selected' : '' }}>Suppressed</option>
                                        <option value="0" {{ old('is_suppressed', $marksSuppression->is_suppressed) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reason">Reason for Suppression</label>
                                    <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Enter reason for suppressing marks (optional)">{{ old('reason', $marksSuppression->reason) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-lg mr-3" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                <i class="fas fa-save"></i> Update Suppression
                            </button>
                            <a href="{{ route('marks-suppression.index') }}" class="btn btn-lg btn-secondary" style="border-radius: 6px; padding: 0.75rem 2rem;">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
