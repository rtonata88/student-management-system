<!DOCTYPE html>
<html lang="en">

<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>{{env('APP_NAME')}}</title>
  <link rel="apple-touch-icon" sizes="57x57" href="{{asset('new/assets/favicon/apple-icon-57x57.png')}}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{asset('new/assets/favicon/apple-icon-60x60.png')}}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{asset('new/assets/favicon/apple-icon-72x72.png')}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('new/assets/favicon/apple-icon-76x76.png')}}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{asset('new/assets/favicon/apple-icon-114x114.png')}}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{asset('new/assets/favicon/apple-icon-120x120.png')}}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{asset('new/assets/favicon/apple-icon-144x144.png')}}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{asset('new/assets/favicon/apple-icon-152x152.png')}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('new/assets/favicon/apple-icon-180x180.png')}}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{asset('new/assets/favicon/android-icon-192x192.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('new/assets/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{asset('new/assets/favicon/favicon-96x96.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('new/assets/favicon/favicon-16x16.png')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />

  <link rel="manifest" href="{{asset('new/assets/favicon/manifest.json')}}">
  <meta name="msapplication-TileColor" content="#ffffff')}}">
  <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png')}}">
  <meta name="theme-color" content="#ffffff">
  <!-- Main styles for this application-->
  <link href="{{asset('new/css/style.css')}}" rel="stylesheet">

  <link href="{{asset('new/node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css')}}" rel="stylesheet">

  <!-- Datatables  -->
  <link href="{{asset('assets/css/datatables.css')}}" rel="stylesheet">

  <!-- summernotes CSS -->
  <link href="{{asset('bower_components/summernote/summernote.css')}}" rel="stylesheet" />

  @stack('highcharts-css')

</head>

<body class="c-app">
  <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
      <span class="text-uppercase font-weight-bold">EDUCIMS TUTORIALS SYSTEM</span>
    </div>
    <ul class="c-sidebar-nav">
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="/welcome">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-home')}}"></use>
          </svg> Welcome
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="/home">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-speedometer')}}"></use>
          </svg> Dashboard
        </a>
      </li>
      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-applications')}}"></use>
          </svg> Applications</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('students')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/students"><span class="c-sidebar-nav-icon"></span> Student Bio</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/exam-permits"><span class="c-sidebar-nav-icon"></span> Exam Permits</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/student-cards"><span class="c-sidebar-nav-icon"></span> Student Cards</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/student-letters"><span class="c-sidebar-nav-icon"></span> Student Letters</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/academic-record"><span class="c-sidebar-nav-icon"></span> Academic Record</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/notice-board"><span class="c-sidebar-nav-icon"></span> Notice Board</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/proof-of-registration"><span class="c-sidebar-nav-icon"></span> Proof of Registration</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/statement-of-results"><span class="c-sidebar-nav-icon"></span> Statement of Results</a></li>
        </ul>
      </li>
      @endpermission

      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-user-follow')}}"></use>
          </svg> Admissions</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('manual-admissions')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/manual-admissions"><span class="c-sidebar-nav-icon"></span> Manual Admissions</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission

      @permission('REGISTRATION_MANAGEMENT')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clipboard')}}"></use>
          </svg> Registrations</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('enrolment')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/enrolment"><span class="c-sidebar-nav-icon"></span> Register</a></li>
          @endpermission
          @permission('enrolment')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/enrolment-adjustment"><span class="c-sidebar-nav-icon"></span> Modify Registration</a></li>
          @endpermission
          @permission('cancel-enrolment')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/cancel-registration"><span class="c-sidebar-nav-icon"></span> Cancel Registration</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission

      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-task')}}"></use>
          </svg> Assessments</a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/my-modules"><span class="c-sidebar-nav-icon"></span> My Modules</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/test-marks"><span class="c-sidebar-nav-icon"></span> Test Marks</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/exam-marks"><span class="c-sidebar-nav-icon"></span> Exam Marks</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/promotions"><span class="c-sidebar-nav-icon"></span> Promotions</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/class-routine"><span class="c-sidebar-nav-icon"></span> Class Routine</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/module-allocation"><span class="c-sidebar-nav-icon"></span> Module Allocation</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/marks-suppression"><span class="c-sidebar-nav-icon"></span> Marks Suppression</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/examination-schedule"><span class="c-sidebar-nav-icon"></span> Examination Schedule</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/process-final-marks"><span class="c-sidebar-nav-icon"></span> Process Final Marks</a></li>
        </ul>
      </li>
      @endpermission

      @permission('ASSESSMENT_MANAGEMENT')
      <li class="c-sidebar-nav-title">ASSESSMENT MANAGEMENT</li>
        
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/class-lists">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
            </svg>Class List</a>
        </li>

        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/assessment-marks">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
            </svg>Enter Marks</a>
        </li>

        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/assessments">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
            </svg>Assessments</a>
        </li>

        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/assessment-types">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
            </svg>Assessment Types</a>
        </li>

        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/subject-allocations">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
            </svg>Subject Allocations</a>
        </li>

      @endpermission

      @permission('FINANCE')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-dollar')}}"></use>
          </svg> Student Debtors</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('payments')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/payments"><span class="c-sidebar-nav-icon"></span> Payments</a></li>
          @endpermission
          @permission('debit-memos')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/debit-memos"><span class="c-sidebar-nav-icon"></span> Debit Memos</a></li>
          @endpermission
          @permission('credit-memos')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/credit-memos"><span class="c-sidebar-nav-icon"></span> Credit Memos</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/student-blocks"><span class="c-sidebar-nav-icon"></span> Student Blocks</a></li>
          @permission('invoice')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/invoices"><span class="c-sidebar-nav-icon"></span> Student Statement</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/block-exceptions"><span class="c-sidebar-nav-icon"></span> Block Exceptions</a></li>
        </ul>
      </li>
      @endpermission

      @permission('fleet-management')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-truck')}}"></use>
          </svg> Fleet Management</a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.dashboard') }}"><span class="c-sidebar-nav-icon"></span> Dashboard</a></li>
          @permission('fleet-vehicles-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.vehicles') }}"><span class="c-sidebar-nav-icon"></span> Vehicles</a></li>
          @endpermission
          @permission('fleet-drivers-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.drivers') }}"><span class="c-sidebar-nav-icon"></span> Drivers</a></li>
          @endpermission
          @permission('fleet-trips-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.trips') }}"><span class="c-sidebar-nav-icon"></span> Trip Logs</a></li>
          @endpermission
          @permission('fleet-fuel-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.fuel') }}"><span class="c-sidebar-nav-icon"></span> Fuel Records</a></li>
          @endpermission
          @permission('fleet-services-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.services') }}"><span class="c-sidebar-nav-icon"></span> Vehicle Services</a></li>
          @endpermission
          @permission('fleet-assignments-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.assignments') }}"><span class="c-sidebar-nav-icon"></span> Vehicle Assignments</a></li>
          @endpermission
          @permission('fleet-reports-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('fleet.reports') }}"><span class="c-sidebar-nav-icon"></span> Reports</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission

      @permission('HOSTEL_MANAGEMENT')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-home')}}"></use>
          </svg> Hostel Management</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('hostel-administration')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/hostel-administration"><span class="c-sidebar-nav-icon"></span> Administration</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission

      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-people')}}"></use>
          </svg> Human Resources</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('employee-bio')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/employee-bio"><span class="c-sidebar-nav-icon"></span> Employee Bio</a></li>
          @endpermission
          @permission('leave-management')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leave-management.index') }}"><span class="c-sidebar-nav-icon"></span> Leave Management</a></li>
          @endpermission
          @permission('leave-applications')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leave-applications.index') }}"><span class="c-sidebar-nav-icon"></span> Leave Applications</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/payroll-management"><span class="c-sidebar-nav-icon"></span> Payroll Management</a></li>
        </ul>
      </li>
      @endpermission

      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-briefcase')}}"></use>
          </svg> Asset Management</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('inventory-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/inventories"><span class="c-sidebar-nav-icon"></span> Inventories</a></li>
          @endpermission
          @permission('fixed-assets-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/fixed-assets"><span class="c-sidebar-nav-icon"></span> Fixed Assets</a></li>
          @endpermission
          @permission('maintenance-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/maintenance"><span class="c-sidebar-nav-icon"></span> Maintenance</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/fleet-management"><span class="c-sidebar-nav-icon"></span> Fleet Management</a></li>
        </ul>
      </li>
      @endpermission

      @permission('REPORTS')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
          </svg> System Reports</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.account-summary.index')}}"><span class="c-sidebar-nav-icon"></span> Account Summary</a></li>
          @endpermission
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.audit')}}"><span class="c-sidebar-nav-icon"></span> Audit Report</a></li>
          @endpermission
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.finance.index')}}"><span class="c-sidebar-nav-icon"></span> Finance</a></li>
          @endpermission
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.payments.index')}}"><span class="c-sidebar-nav-icon"></span> Payments</a></li>
          @endpermission
          @permission('student-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.students.index')}}"><span class="c-sidebar-nav-icon"></span> Student Registration</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission

      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-title">SETUPS MANAGEMENT</li>
      @permission('access-management-menu')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked')}}"></use>
          </svg> Access Control</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('users')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/users"><span class="c-sidebar-nav-icon"></span> Users</a></li>
          @endpermission
          @permission('roles')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/roles"><span class="c-sidebar-nav-icon"></span>Roles</a></li>
          @endpermission
          @permission('permissions')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/permissions"><span class="c-sidebar-nav-icon"></span>Permissions</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      @endpermission

      @permission('SETUP')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cog')}}"></use>
          </svg> System Setups</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('fees')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/fees"><span class="c-sidebar-nav-icon"></span>Fees</a></li>
          @endpermission
          @permission('company')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('company.show', 1)}}"><span class="c-sidebar-nav-icon"></span> Company</a></li>
          @endpermission
          @permission('centers')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('centers.index')}}"><span class="c-sidebar-nav-icon"></span> Centers</a></li>
          @endpermission
          @permission('subjects')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/subjects"><span class="c-sidebar-nav-icon"></span>Subjects</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/departments"><span class="c-sidebar-nav-icon"></span> Departments</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/designations"><span class="c-sidebar-nav-icon"></span> Designations</a></li>
          @permission('academic-years')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('academic-year.index')}}"><span class="c-sidebar-nav-icon"></span>Academic Years</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/asset-categories"><span class="c-sidebar-nav-icon"></span> Asset Categories</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/inventory-categories"><span class="c-sidebar-nav-icon"></span> Inventory Categories</a></li>
        </ul>
      </li>
      @endpermission
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
  </div>
  <div class="c-wrapper c-fixed-components">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
      <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <svg class="c-icon c-icon-lg">
          <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}}"></use>
        </svg>
      </button><a class="c-header-brand d-lg-none" href="#">
        SMS </a>
      <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
          <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}}"></use>
        </svg>
      </button>
      <ul class="c-header-nav ml-auto mr-4">

        <li class="c-header-nav-item dropdown">
          <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="background-color: #f8f9fa; border-radius: 25px; padding: 6px 16px; border: 1px solid #dee2e6; transition: all 0.2s ease;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 28px; height: 28px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="color: white; width: 14px; height: 14px;">
                  <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-user')}}"></use>
                </svg>
              </div>
              <span style="color: #495057; font-weight: 500; font-size: 14px;">Account</span>
              <svg style="color: #6c757d; width: 10px; height: 10px;">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chevron-bottom')}}"></use>
              </svg>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right pt-0" style="border: 1px solid #dee2e6; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
            <div class="dropdown-header bg-primary text-white py-2"><strong>Account</strong></div>
            <a class="dropdown-item text-dark" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #495057 !important;">
              <svg class="c-icon mr-2">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout')}}"></use>
              </svg> Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      </ul>
      @yield('breadcrumb')
    </header>
    <div class="c-body">
      <main class="c-main">
        <div class="container-fluid">
          <div class="fade-in">

            @yield('content')

          </div>
        </div>
      </main>
      <footer class="c-footer">
        <div class="text-uppercase"> &copy; {{date('Y')}} EDUCIMS - a SCHOOL MANAGEMENT SYSTEM
        </div>
      </footer>
    </div>
  </div>
  <!-- CoreUI and necessary plugins-->
  <script src="{{asset('new/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js')}}"></script>

  <!-- jQuery -->
  <script src="{{asset('assets/plugins/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="{{asset('assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- Menu Plugin JavaScript -->
  <script src="{{asset('assets/plugins/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
  <!--slimscroll JavaScript -->
  <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
  <!--Wave Effects -->
  <script src="{{asset('assets/js/waves.js')}}"></script>
  <!--Counter js -->
  <script src="{{asset('assets/plugins/waypoints/lib/jquery.waypoints.js')}}"></script>
  <script src="{{asset('assets/plugins/counterup/jquery.counterup.min.js')}}"></script>


  <!-- Date Picker Plugin JavaScript -->
  <script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

  <!-- Sparkline chart JavaScript -->
  <script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

  <!-- multi-select -->
  <script src="{{asset('bower_components/multi-select/multi-select.js')}}"></script>

  <!-- Select 2 -->
  <script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
  <!-- Gallery -->
  <script type="text/javascript" src="{{asset('bower_components/gallery/js/animated-masonry-gallery.js')}}"></script>
  <script type="text/javascript" src="{{asset('bower_components/gallery/js/jquery.isotope.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('bower_components/fancybox/ekko-lightbox.min.js')}}"></script>

  <!-- Custom Theme JavaScript -->
  <script src="{{asset('assets/js/custom.min.js')}}"></script>
  <!-- <script src="{{asset('assets/js/dashboard1.js')}}"></script> -->
  <script src="{{asset('assets/plugins/toast-master/js/jquery.toast.js')}}"></script>

  <!-- Form Wizard -->
  <script src="{{asset('bower_components/moment/moment.js')}}"></script>
  <script src="{{asset('bower_components/jquery-wizard-master/jquery.steps.min.js')}}"></script>
  <script src="{{asset('bower_components/jquery-wizard-master/jquery.validate.min.js')}}"></script>
  <script src="{{asset('bower_components/summernote/summernote.min.js')}}"></script>
  <script src="{{asset('bower_components/clockpicker/jquery-clockpicker.min.js')}}"></script>
  <script src="{{asset('bower_components/typeahead/typeahead.bundle.js')}}"></script>
  <script src="{{asset('bower_components/morris.js/morris.js')}}"></script>
  <script src="{{asset('bower_components/raphael/raphael.js')}}"></script>
  <!-- <script src="http://malsup.github.com/jquery.form.js"></script> -->
  <!--  Data Tables -->
  <script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.js')}}"></script>

  <!-- end - This is for export functionality only -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{asset('js/peaceapp.js')}}"></script>
  <script src="{{asset('js/charts.js')}}"></script>

  <!--[if IE]><!-->
  <script src="{{asset('new/node_modules/@coreui/icons/js/svgxuse.min.js')}}"></script>


  <!--<![endif]-->
  <!-- Plugins and scripts required by this view-->
  <script src="{{asset('new/node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js')}}"></script>
  <script src="{{asset('new/node_modules/@coreui/utils/dist/coreui-utils.js')}}"></script>
  <script src="{{asset('assets/js/datatables.js')}}"></script>
  <script src="{{asset('new/js/main.js')}}"></script>
  @stack('dataTableScript')
  @stack('profiles')
  @stack('contactsJS')
  @stack('googleCharts')
  @stack('highcharts')
  @stack('payments')

<style>
/* System gradient color palette theme for sidebar */
:root {
  --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  --primary-color: #667eea;
  --secondary-color: #764ba2;
  --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

/* Override sidebar hover colors to match system gradient theme */
@media (hover: hover), (-ms-high-contrast: none) {
  .c-sidebar .c-sidebar-nav-link:hover, 
  .c-sidebar .c-sidebar-nav-dropdown-toggle:hover {
    color: #fff !important;
    background: var(--primary-gradient) !important;
    transition: all 0.3s ease;
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
  }
  
  .c-sidebar .c-sidebar-nav-link:hover .c-sidebar-nav-icon, 
  .c-sidebar .c-sidebar-nav-dropdown-toggle:hover .c-sidebar-nav-icon {
    color: #fff !important;
  }
}

/* Minimized sidebar hover */
.c-sidebar.c-sidebar-minimized .c-sidebar-nav-item:hover > .c-sidebar-nav-link, 
.c-sidebar.c-sidebar-minimized .c-sidebar-nav-item:hover > .c-sidebar-nav-dropdown-toggle {
  background: var(--primary-gradient) !important;
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.c-sidebar.c-sidebar-minimized .c-sidebar-nav-item:hover > .c-sidebar-nav-link .c-sidebar-nav-icon, 
.c-sidebar.c-sidebar-minimized .c-sidebar-nav-item:hover > .c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
  color: #fff !important;
}

/* Active/current page styling */
.c-sidebar .c-sidebar-nav-link.c-active {
  background: var(--hover-gradient) !important;
  color: #fff !important;
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
}

.c-sidebar .c-sidebar-nav-link.c-active .c-sidebar-nav-icon {
  color: #fff !important;
}

/* Main menu section titles - slightly bolder */
.c-sidebar .c-sidebar-nav-dropdown-toggle {
  font-weight: 500 !important;
}

/* Keep submenu items with normal font weight */
.c-sidebar .c-sidebar-nav-dropdown-items .c-sidebar-nav-link {
  font-weight: 400 !important;
}

/* Dropdown items hover */
.c-sidebar .c-sidebar-nav-dropdown-items .c-sidebar-nav-link:hover {
  background: var(--primary-gradient) !important;
  color: #fff !important;
  transform: translateX(4px);
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
}

/* Header account dropdown to match theme */
.c-header-nav-link:hover {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
  border-color: var(--primary-color) !important;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.dropdown-header.bg-primary {
  background: var(--primary-gradient) !important;
}
</style>
</body>

</html>