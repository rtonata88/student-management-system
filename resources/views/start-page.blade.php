@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Main Menu</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="bg-white">

    @permission('MANAGEMENT')
    <div class="p-3">
        <div class="col-12 row">
            <h6 class="text-dark">Management</h6>
            <hr>
        </div>

        <div class="row">
            @permission('students')
            <a href="/students">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-education')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/students">
                                <div class="text-value text-primary">Students</div>
                            </a>
                            <div class="text-muted small">Create student biographical information</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('fees')
            <a href="/fees">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-money')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/fees">
                                <div class="text-value text-primary">Fees</div>
                            </a>
                            <div class="text-muted small">Setup extra fees to be charged against student accounts.</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('subjects')
            <a href="/subjects">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-education')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/subjects">
                                <div class="text-value text-primary">Subjects</div>
                            </a>
                            <div class="text-muted small">Create subjects and link subjects to extra fees</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
        </div>
    </div>
    @endpermission
    @permission('REGISTRATION_MANAGEMENT')
    <div class="p-3">
        <div class="col-12 row">
            <h6 class="text-dark">Registration Management</h6>
            <hr>
        </div>

        <div class="row">
            @permission('enrolment')
            <a href="/enrolment">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/enrolment">
                                <div class="text-value text-primary">Enrolment</div>
                            </a>
                            <div class="text-muted small">Student subject registration and fee charges</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('enrolment')
            <a href="/enrolment-adjustment">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/enrolment-adjustment">
                                <div class="text-value text-primary">Enrolment Adjustments</div>
                            </a>
                            <div class="text-muted small">Make changes to learner enrolments.</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('cancel-enrolment')
            <a href="/cancel-registration">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-ban')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/cancel-registration">
                                <div class="text-value text-primary">Cancel Enrolments</div>
                            </a>
                            <div class="text-muted small">Manage subject cancellations.</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
        </div>

    </div>
    @endpermission
    @permission('FINANCE')
    <div class="p-3">
        <div class="col-12 row">
            <h6 class="text-dark">Finance</h6>
            <hr>
        </div>

        <div class="row">
            @permission('invoice')
            <a href="/invoices">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-wallet')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/invoices">
                                <div class="text-value text-primary">Student Statements</div>
                            </a>
                            <div class="text-muted small">View student invoices, payments, debit memos, and credit memos</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('payments')
            <a href="/payments">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-bank')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/payments">
                                <div class="text-value text-primary">Payments</div>
                            </a>
                            <div class="text-muted small">Record student payments </div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('credit-memos')
            <a href="/credit-memos">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-bank')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/credit-memos">
                                <div class="text-value text-primary">Credit Memos</div>
                            </a>
                            <div class="text-muted small">Manage credit memos for learners</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('debit-memos')
            <a href="/debit-memos">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-bank')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/debit-memos">
                                <div class="text-value text-primary">Debit Memos</div>
                            </a>
                            <div class="text-muted small">Manage debit memos for learners</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
        </div>
    </div>
    @endpermission
    @permission('REPORTS')
    <div class="p-3">
        <div class="col-12 row">
            <h6 class="text-dark">Reports</h6>
            <hr>
        </div>

        <div class="row">
            @permission('student-report')
            <a href="/student/reports">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/student/reports">
                                <div class="text-value text-primary">Student Registration</div>
                            </a>
                            <div class="text-muted small">View student registrations per module and per center</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('finance-report')
            <a href="/account-summary/reports">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/account-summary/reports">
                                <div class="text-value text-primary">Account Summary</div>
                            </a>
                            <div class="text-muted small">See a summary of monthly payables and total outstanding course fees</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/payment/reports">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/payment/reports">
                                <div class="text-value text-primary">Payments</div>
                            </a>
                            <div class="text-muted small">View a list of all payments in a date range</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/audit/reports">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/audit/reports">
                                <div class="text-value text-primary">Audit Report</div>
                            </a>
                            <div class="text-muted small">See who changed what on the system</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
        </div>
    </div>
    @endpermission
    @permission('ADMINISTRATION')
    <div class="p-3">
        <div class="col-12 row">
            <h6 class="text-dark">Setup & Administration</h6>
            <hr>
        </div>

        <div class="row">
            @permission('access-management-menu')
            @permission('users')
            <a href="/users">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-user')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/users">
                                <div class="text-value text-primary">Users & Roles</div>
                            </a>
                            <div class="text-muted small">Manage system users, user access, and roles </div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @endpermission
            @permission('SETUP')
            @permission('academic-years')
            <a href="/academic-year">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/academic-year">
                                <div class="text-value text-primary">Academic Years</div>
                            </a>
                            <div class="text-muted small">Control academic year cycles</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('centers')
            <a href="/centers">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-building')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/centers">
                                <div class="text-value text-primary">Centers</div>
                            </a>
                            <div class="text-muted small">Manage and setup different centers</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @permission('company')
            <a href="/company/1">
                <div class="col-md-4 col-sm-12 main-menu-item">
                    <div class="p-3 d-flex align-items-center">
                        <div class="p-3 mfe-3">
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-building')}}"></use>
                            </svg>
                        </div>
                        <div>
                            <a href="/company/1">
                                <div class="text-value text-primary">Company</div>
                            </a>
                            <div class="text-muted small">Modify company details</div>
                        </div>
                    </div>
                </div>
            </a>
            @endpermission
            @endpermission
        </div>
    </div>
    @endpermission
</div>
@endsection