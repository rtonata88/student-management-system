@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-history"></i> Promotion History - {{ $student->surname }}, {{ $student->student_names }}
                        </h4>
                        <a href="{{ route('promotions.search') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Students
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Student Information</h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>Student Number:</strong> {{ $student->student_number }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Name:</strong> {{ $student->surname }}, {{ $student->student_names }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Centre:</strong> {{ $student->center->center_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Contact:</strong> {{ $student->contact_email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Promotion History Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <tr>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Academic Year</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Year Level</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Promotion Status</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Remarks</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Promoted By</th>
                                    <th style="border: none; padding: 16px 12px; font-weight: 600;">Promoted On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promotions as $promotion)
                                <tr>
                                    <td style="padding: 16px 12px; font-weight: 500;">
                                        {{ $promotion->academicYear->academic_year ?? 'N/A' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $promotion->year_level }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        <span class="badge {{ $promotion->promotionalStatus->promoted === 'Yes' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $promotion->promotionalStatus->description }}
                                        </span>
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $promotion->remarks ?? 'No remarks' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $promotion->promotedBy->name ?? 'N/A' }}
                                    </td>
                                    <td style="padding: 16px 12px;">
                                        {{ $promotion->promoted_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center" style="padding: 40px; color: #6c757d;">
                                        <i class="fas fa-history fa-3x mb-3" style="opacity: 0.3;"></i>
                                        <p class="mb-0">No promotion history found for this student.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
