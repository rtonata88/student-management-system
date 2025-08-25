@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.18);">
                <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-certificate"></i> Proof of Registration Search
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="POST" action="{{ route('proof-of-registration.filter') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_number" class="font-weight-bold">Student Number</label>
                                    <input type="text" class="form-control" id="student_number" name="student_number" 
                                           placeholder="Enter student number..." value="{{ old('student_number') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="names" class="font-weight-bold">Student Names</label>
                                    <input type="text" class="form-control" id="names" name="names" 
                                           placeholder="Enter student names..." value="{{ old('names') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; border-radius: 25px; padding: 12px 30px; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);">
                                    <i class="fa fa-search"></i> Search Registered Students
                                </button>
                                <a href="{{ route('proof-of-registration.index') }}" class="btn btn-lg btn-secondary ml-2" style="border-radius: 25px; padding: 12px 30px;">
                                    <i class="fa fa-refresh"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>

                    @if(session('message'))
                        <div class="alert alert-info mt-4">
                            <i class="fa fa-info-circle"></i> {{ session('message') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger mt-4">
                            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <!-- Search Results -->
                    @if(isset($students) && $students->count() > 0)
                        <div class="mt-4">
                            <h5 class="font-weight-bold mb-3">
                                <i class="fa fa-users"></i> Registered Students ({{ $students->count() }} student{{ $students->count() > 1 ? 's' : '' }} found)
                            </h5>
                            <div class="row">
                                @foreach($students as $student)
                                    @php
                                        $currentYear = \App\AcademicYear::where('status', 1)->first();
                                        $registration = $student->registration->where('academic_year', $currentYear->academic_year)->first();
                                        $registeredModules = \App\ModuleRegistration::where('student_id', $student->id)
                                            ->where('academic_year', $currentYear->academic_year)
                                            ->count();
                                    @endphp
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7)); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.3); border-radius: 15px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        @if($student->photo)
                                                            <img src="{{ asset('storage/' . $student->photo) }}" 
                                                                 alt="Student Photo" 
                                                                 class="img-fluid rounded-circle" 
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fa fa-user text-white"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-8">
                                                        <h6 class="font-weight-bold mb-1" style="color: #333;">
                                                            {{ $student->student_names }} {{ $student->surname }}
                                                        </h6>
                                                        <p class="text-muted mb-1 small">
                                                            <strong>Number:</strong> {{ $student->student_number }}
                                                        </p>
                                                        <p class="text-muted mb-1 small">
                                                            <strong>Center:</strong> {{ $student->center->center_name ?? 'N/A' }}
                                                        </p>
                                                        <p class="text-muted mb-1 small">
                                                            <strong>Modules:</strong> {{ $registeredModules }}
                                                        </p>
                                                        <p class="text-muted mb-2 small">
                                                            <strong>Registered:</strong> {{ $registration ? \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') : 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <span class="badge badge-success mb-2">
                                                        <i class="fa fa-check-circle"></i> Registered for {{ $currentYear->academic_year }}
                                                    </span>
                                                    
                                                    @can('generate-proof-of-registration')
                                                        <a href="{{ route('proof-of-registration.generate', $student->id) }}" 
                                                           class="btn btn-sm btn-block" 
                                                           style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; border-radius: 20px; padding: 8px 16px; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);">
                                                            <i class="fa fa-certificate"></i> View Proof of Registration
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('download-proof-of-registration')
                                                        <a href="{{ route('proof-of-registration.download', $student->id) }}" 
                                                           class="btn btn-sm btn-block mt-2" 
                                                           style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 20px; padding: 8px 16px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                                            <i class="fa fa-download"></i> Download PDF
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2) !important;
    }
</style>
@endsection
