@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-clock"></i> Class Duration Setting
                            </h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('class-routine.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-arrow-left"></i> Back to Class Routine
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">
                                        <i class="fa fa-clock text-primary"></i> Current Class Duration
                                    </h5>
                                    <h2 class="text-primary mb-4">{{ $currentDuration }} minutes</h2>
                                    
                                    <form method="POST" action="{{ route('class-durations.update') }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form-group">
                                            <label for="duration_minutes" class="font-weight-bold">Set Class Duration (Minutes)</label>
                                            <input type="number" 
                                                   name="duration_minutes" 
                                                   id="duration_minutes" 
                                                   class="form-control form-control-lg text-center" 
                                                   value="{{ old('duration_minutes', $currentDuration) }}" 
                                                   min="5" 
                                                   max="480" 
                                                   placeholder="60" 
                                                   required>
                                            <small class="form-text text-muted">
                                                Enter duration between 5-480 minutes<br>
                                                <strong>Examples:</strong> 30 minutes, 45 minutes, 60 minutes, 90 minutes
                                            </small>
                                            @error('duration_minutes')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if(Auth::user()->hasPermission('edit-class-duration'))
                                        <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                            <i class="fa fa-save"></i> Update Duration
                                        </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6><i class="fa fa-info-circle"></i> About Class Duration</h6>
                                <p class="mb-0">
                                    This setting defines how long each class session lasts in your institution. 
                                    This is different from exam time slots which can be much longer (e.g., 3 hours for exams vs 30-60 minutes for regular classes).
                                    All class schedules will use this duration setting.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
