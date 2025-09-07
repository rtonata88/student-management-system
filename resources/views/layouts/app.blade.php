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
          @permission('view-notice-board')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/notice-board"><span class="c-sidebar-nav-icon"></span> Notice Board</a></li>
          @endpermission
          @permission('view-exam-permits')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/exam-permits"><span class="c-sidebar-nav-icon"></span> Exam Permits</a></li>
          @endpermission
          @permission('student-cards')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/student-cards"><span class="c-sidebar-nav-icon"></span> Student Cards</a></li>
          @endpermission
          @permission('view-student-letters')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/student-letters"><span class="c-sidebar-nav-icon"></span> Student Letters</a></li>
          @endpermission
          @permission('view-academic-records')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/academic-records"><span class="c-sidebar-nav-icon"></span> Academic Record</a></li>
          @endpermission
          @permission('view-proof-of-registration')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/proof-of-registration"><span class="c-sidebar-nav-icon"></span> Proof of Registration</a></li>
          @endpermission
          @permission('manage-online-submissions')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/online-submissions"><span class="c-sidebar-nav-icon"></span> Online Submissions</a></li>
          @endpermission
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
          @permission('manual-admissions-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/manual-admissions"><span class="c-sidebar-nav-icon"></span> View Admissions</a></li>
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
          @permission('view-my-modules')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('my-modules.index') }}"><span class="c-sidebar-nav-icon"></span> My Modules</a></li>
          @endpermission
          @permission('test-marks')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/test-marks"><span class="c-sidebar-nav-icon"></span> Test Marks</a></li>
          @endpermission
          @permission('exam-marks')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/exam-marks"><span class="c-sidebar-nav-icon"></span> Exam Marks</a></li>
          @endpermission
          @permission('view-student-promotions')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/promotions"><span class="c-sidebar-nav-icon"></span> Promotions</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/class-routine"><span class="c-sidebar-nav-icon"></span> Class Routine</a></li>
          @permission('view-module-allocations')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('module-allocations.index') }}"><span class="c-sidebar-nav-icon"></span> Module Allocation</a></li>
          @endpermission
          @permission('view-marks-suppression')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/marks-suppression"><span class="c-sidebar-nav-icon"></span> Marks Suppression</a></li>
          @endpermission
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

      @can('view-class-routine')
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('class-routine.index') }}">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
            </svg>Class Routine</a>
        </li>
      @endcan

      @permission('FINANCE')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-dollar')}}"></use>
          </svg> Student Debtors</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('view-cashier')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/cashier"><span class="c-sidebar-nav-icon"></span> Cashier</a></li>
          @endpermission
          @permission('debit-memos')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/debit-memos"><span class="c-sidebar-nav-icon"></span> Debit Memos</a></li>
          @endpermission
          @permission('credit-memos')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/credit-memos"><span class="c-sidebar-nav-icon"></span> Credit Memos</a></li>
          @endpermission
          @permission('view-student-blocks')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/student-blocks"><span class="c-sidebar-nav-icon"></span> Student Block</a></li>
          @endpermission
          @permission('payments')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/payments"><span class="c-sidebar-nav-icon"></span> Manual Payments</a></li>
          @endpermission
          @permission('view-captured-payments')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/captured-payments"><span class="c-sidebar-nav-icon"></span> Captured Payments</a></li>
          @endpermission
          @permission('invoice')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/invoices"><span class="c-sidebar-nav-icon"></span> Student Statement</a></li>
          @endpermission
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

      @permission('access-student-portal')
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="/student-portal-administration">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-user')}}"></use>
          </svg> Student Portal
        </a>
      </li>
      @endpermission

      @permission('ADMINISTRATION')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-people')}}"></use>
          </svg> Human Resources</a>
        <ul class="c-sidebar-nav-dropdown-items">
          @permission('employee-bio-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/employee-bio"><span class="c-sidebar-nav-icon"></span> Employee Bio</a></li>
          @endpermission
          @permission('leave-management-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leave-management.index') }}"><span class="c-sidebar-nav-icon"></span> Leave Management</a></li>
          @endpermission
          @permission('leave-application-view')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leave-applications.index') }}"><span class="c-sidebar-nav-icon"></span> Leave Applications</a></li>
          @endpermission
          @permission('access-payroll-system')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/payroll-management"><span class="c-sidebar-nav-icon"></span> Payroll Management</a></li>
          @endpermission
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
          
          {{-- All Reports Sorted Alphabetically --}}
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.account-summary.index')}}"><span class="c-sidebar-nav-icon"></span> Account Summary</a></li>
          @endpermission
          @permission('academic-performance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'academic-performance'])}}"><span class="c-sidebar-nav-icon"></span> Academic Performance</a></li>
          @endpermission
          @permission('academic-transcript-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'academic-transcript'])}}"><span class="c-sidebar-nav-icon"></span> Academic Transcript</a></li>
          @endpermission
          @permission('asset-management-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'asset-management'])}}"><span class="c-sidebar-nav-icon"></span> Asset Management</a></li>
          @endpermission
          @permission('assessment-analysis-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'assessment-analysis'])}}"><span class="c-sidebar-nav-icon"></span> Assessment Analysis</a></li>
          @endpermission
          @permission('attendance-summary-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'attendance-summary'])}}"><span class="c-sidebar-nav-icon"></span> Attendance Summary</a></li>
          @endpermission
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.audit')}}"><span class="c-sidebar-nav-icon"></span> Audit Report</a></li>
          @endpermission
          @permission('class-schedule-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'class-schedule'])}}"><span class="c-sidebar-nav-icon"></span> Class Schedule</a></li>
          @endpermission
          @permission('curriculum-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'curriculum'])}}"><span class="c-sidebar-nav-icon"></span> Curriculum Report</a></li>
          @endpermission
          @permission('employee-attendance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'employee-attendance'])}}"><span class="c-sidebar-nav-icon"></span> Employee Attendance</a></li>
          @endpermission
          @permission('employee-performance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'employee-performance'])}}"><span class="c-sidebar-nav-icon"></span> Employee Performance</a></li>
          @endpermission
          @permission('enrollment-statistics-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'enrollment-statistics'])}}"><span class="c-sidebar-nav-icon"></span> Enrollment Statistics</a></li>
          @endpermission
          @permission('exam-results-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'exam-results'])}}"><span class="c-sidebar-nav-icon"></span> Exam Results</a></li>
          @endpermission
          @permission('exam-schedule-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'exam-schedule'])}}"><span class="c-sidebar-nav-icon"></span> Exam Schedule</a></li>
          @endpermission
          @permission('fee-collection-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'fee-collection'])}}"><span class="c-sidebar-nav-icon"></span> Fee Collection</a></li>
          @endpermission
          @permission('fee-defaulters-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'fee-defaulters'])}}"><span class="c-sidebar-nav-icon"></span> Fee Defaulters</a></li>
          @endpermission
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.finance.index')}}"><span class="c-sidebar-nav-icon"></span> Finance</a></li>
          @endpermission
          @permission('fleet-utilization-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'fleet-utilization'])}}"><span class="c-sidebar-nav-icon"></span> Fleet Utilization</a></li>
          @endpermission
          @permission('fuel-consumption-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'fuel-consumption'])}}"><span class="c-sidebar-nav-icon"></span> Fuel Consumption</a></li>
          @endpermission
          @permission('hostel-fee-collection-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'hostel-fee-collection'])}}"><span class="c-sidebar-nav-icon"></span> Hostel Fee Collection</a></li>
          @endpermission
          @permission('hostel-occupancy-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'hostel-occupancy'])}}"><span class="c-sidebar-nav-icon"></span> Hostel Occupancy</a></li>
          @endpermission
          @permission('inventory-stock-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'inventory-stock'])}}"><span class="c-sidebar-nav-icon"></span> Inventory Stock</a></li>
          @endpermission
          @permission('leave-summary-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'leave-summary'])}}"><span class="c-sidebar-nav-icon"></span> Leave Summary</a></li>
          @endpermission
          @permission('low-stock-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'low-stock'])}}"><span class="c-sidebar-nav-icon"></span> Low Stock</a></li>
          @endpermission
          @permission('maintenance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'maintenance'])}}"><span class="c-sidebar-nav-icon"></span> Maintenance Report</a></li>
          @endpermission
          @permission('outstanding-balances-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'outstanding-balances'])}}"><span class="c-sidebar-nav-icon"></span> Outstanding Balances</a></li>
          @endpermission
          @permission('finance-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.payments.index')}}"><span class="c-sidebar-nav-icon"></span> Payments</a></li>
          @endpermission
          @permission('payroll-summary-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'payroll-summary'])}}"><span class="c-sidebar-nav-icon"></span> Payroll Summary</a></li>
          @endpermission
          @permission('registration-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'registration'])}}"><span class="c-sidebar-nav-icon"></span> Registration Report</a></li>
          @endpermission
          @permission('revenue-analysis-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'revenue-analysis'])}}"><span class="c-sidebar-nav-icon"></span> Revenue Analysis</a></li>
          @endpermission
          @permission('room-utilization-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'room-utilization'])}}"><span class="c-sidebar-nav-icon"></span> Room Utilization</a></li>
          @endpermission
          @permission('student-demographics-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'student-demographics'])}}"><span class="c-sidebar-nav-icon"></span> Student Demographics</a></li>
          @endpermission
          @permission('student-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.students.index')}}"><span class="c-sidebar-nav-icon"></span> Student Registration</a></li>
          @endpermission
          @permission('system-activity-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'system-activity'])}}"><span class="c-sidebar-nav-icon"></span> System Activity</a></li>
          @endpermission
          @permission('timetable-conflicts-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'timetable-conflicts'])}}"><span class="c-sidebar-nav-icon"></span> Timetable Conflicts</a></li>
          @endpermission
          @permission('user-activity-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'user-activity'])}}"><span class="c-sidebar-nav-icon"></span> User Activity</a></li>
          @endpermission
          @permission('vehicle-service-history-report')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reports.coming-soon', ['report' => 'vehicle-service-history'])}}"><span class="c-sidebar-nav-icon"></span> Vehicle Service History</a></li>
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
          @permission('view-departments')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('departments.index') }}"><span class="c-sidebar-nav-icon"></span> Departments</a></li>
          @endpermission
          @permission('view-leave-types')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leave-types.index') }}"><span class="c-sidebar-nav-icon"></span> Leave Types</a></li>
          @endpermission
          @permission('view-designations')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('designations.index') }}"><span class="c-sidebar-nav-icon"></span> Designations</a></li>
          @endpermission
          @permission('academic-years')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('academic-year.index')}}"><span class="c-sidebar-nav-icon"></span>Academic Years</a></li>
          @endpermission
          @permission('view-asset-categories')
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('asset-categories.index') }}"><span class="c-sidebar-nav-icon"></span> Asset Categories</a></li>
          @endpermission
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/inventory-categories"><span class="c-sidebar-nav-icon"></span> Inventory Categories</a></li>
        </ul>
      </li>
      @endpermission

      @permission('SETUP')
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-education')}}"></use>
          </svg> Academic Structure</a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/assessments"><span class="c-sidebar-nav-icon"></span> Assessments</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/examinations"><span class="c-sidebar-nav-icon"></span> Examinations</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/result-codes"><span class="c-sidebar-nav-icon"></span> Result Codes</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/grading-scales"><span class="c-sidebar-nav-icon"></span> Grading Scales</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/assessment-weights"><span class="c-sidebar-nav-icon"></span> Assessment Weights</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/exam-paper-weights"><span class="c-sidebar-nav-icon"></span> Exam Paper Weights</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/promotional-statuses"><span class="c-sidebar-nav-icon"></span> Promotional Statuses</a></li>
        </ul>
      </li>
      @endpermission

      <!-- Support Centre Section -->
      <li class="c-sidebar-nav-title">SUPPORT CENTRE</li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="https://educims.com/support.html" target="_blank">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-book')}}"></use>
          </svg> User Manuals
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="https://www.youtube.com/@educims" target="_blank">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-video')}}"></use>
          </svg> Video Tutorials
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="https://educims.com/contact.html" target="_blank">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-help')}}"></use>
          </svg> FAQ & Help
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="#" onclick="showQuickSupport(); return false;">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}}"></use>
          </svg> Quick Support
        </a>
      </li>
    </ul>
    
    <!-- Support Widget Card -->
    <div class="support-widget-card">
      <div class="support-icon">
        <svg>
          <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-help')}}"></use>
        </svg>
      </div>
      <h6 class="support-title">Report System Bugs</h6>
      <p class="support-subtitle">+264 81 37 0 37 26<br>info@educims.com</p>
      <a href="https://educims.com" target="_blank" class="support-btn" style="display: inline-block; text-decoration: none; text-align: center;">Our Website</a>
    </div>
    
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
              <span style="color: #495057; font-weight: 500; font-size: 14px;">{{ explode(' ', Auth::user()->name)[0] }}</span>
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

  <!-- Quick Support Modal -->
  <div id="quickSupportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="quickSupportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="quickSupportModalLabel">
            <svg class="mr-2" style="width: 20px; height: 20px; fill: currentColor;">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}}"></use>
            </svg>
            Quick Support
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-4">
              <svg style="width: 48px; height: 48px; color: #667eea;">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-contact')}}"></use>
              </svg>
            </div>
            <h6 class="mb-3 text-primary">Contact Information</h6>
            <div class="contact-info">
              <div class="mb-3">
                <svg class="mr-2" style="width: 16px; height: 16px; color: #667eea;">
                  <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-location-pin')}}"></use>
                </svg>
                <strong>Address:</strong><br>
                <span class="ml-4">5 Handel Street, Windhoek West, Namibia</span>
              </div>
              <div class="mb-3">
                <svg class="mr-2" style="width: 16px; height: 16px; color: #667eea;">
                  <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}}"></use>
                </svg>
                <strong>Phone:</strong><br>
                <span class="ml-4">
                  <a href="tel:+264813703726" class="text-primary">+264 81 37 0 37 26</a>
                </span>
              </div>
              <div class="mb-3">
                <svg class="mr-2" style="width: 16px; height: 16px; color: #667eea;">
                  <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-envelope-closed')}}"></use>
                </svg>
                <strong>Email:</strong><br>
                <span class="ml-4">
                  <a href="mailto:info@educims.com" class="text-primary">info@educims.com</a>
                </span>
              </div>
              <div class="mb-3">
                <svg class="mr-2" style="width: 16px; height: 16px; color: #667eea;">
                  <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-globe')}}"></use>
                </svg>
                <strong>Website:</strong><br>
                <span class="ml-4">
                  <a href="https://www.educims.com" target="_blank" class="text-primary">www.educims.com</a>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <a href="mailto:info@educims.com" class="btn btn-primary">
            <svg class="mr-1" style="width: 16px; height: 16px; fill: currentColor;">
              <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-envelope-closed')}}"></use>
            </svg>
            Send Email
          </a>
        </div>
      </div>
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
  
  <!-- Quick Support Modal JavaScript -->
  <script>
    function showQuickSupport() {
      $('#quickSupportModal').modal('show');
    }
  </script>
  
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

/* Quick Support Modal Styling */
#quickSupportModal .modal-header {
  background: var(--primary-gradient) !important;
  border-bottom: none;
}

#quickSupportModal .contact-info {
  text-align: left;
  max-width: 300px;
  margin: 0 auto;
}

#quickSupportModal .contact-info div {
  display: flex;
  align-items: flex-start;
  flex-direction: column;
  padding: 10px;
  border-radius: 8px;
  background: #f8f9fa;
  margin-bottom: 10px;
}

#quickSupportModal .contact-info strong {
  color: #495057;
  margin-bottom: 5px;
}

#quickSupportModal .contact-info a {
  text-decoration: none;
  transition: color 0.2s ease;
}

#quickSupportModal .contact-info a:hover {
  color: var(--secondary-color) !important;
}

#quickSupportModal .btn-primary {
  background: var(--primary-gradient);
  border: none;
  transition: all 0.3s ease;
}

#quickSupportModal .btn-primary:hover {
  background: var(--hover-gradient);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Support Widget Card Styling */
.support-widget-card {
  margin: 20px 15px 15px 15px;
  padding: 20px;
  background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
  border-radius: 12px;
  text-align: center;
  color: white;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.support-widget-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.support-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #4285f4 0%, #667eea 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 15px auto;
  box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
}

.support-icon svg {
  width: 24px;
  height: 24px;
  color: white;
}

.support-title {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 8px;
  color: white;
}

.support-subtitle {
  font-size: 13px;
  color: #bdc3c7;
  margin-bottom: 15px;
  line-height: 1.4;
}

.support-btn {
  background: white;
  color: #2c3e50;
  border: none;
  padding: 8px 20px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 100%;
  outline: none;
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

.support-btn:hover {
  background: #f8f9fa;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
}

.support-btn:active {
  transform: translateY(0px);
  background: #e9ecef;
}

.support-btn:focus {
  outline: 2px solid #667eea;
  outline-offset: 2px;
}

/* Hide support widget when sidebar is minimized */
.c-sidebar.c-sidebar-minimized .support-widget-card {
  display: none;
}
</style>

@yield('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to find the active menu item using multiple methods
    function findActiveMenuItem() {
        // Try different selectors to find the active menu item
        let activeMenuItem = document.querySelector('.c-sidebar-nav-link.c-active');
        
        if (!activeMenuItem) {
            // Try looking for items with active class
            activeMenuItem = document.querySelector('.c-sidebar-nav-item.c-active .c-sidebar-nav-link');
        }
        
        if (!activeMenuItem) {
            // Try looking for highlighted items (different background color)
            const currentUrl = window.location.pathname;
            const menuLinks = document.querySelectorAll('.c-sidebar-nav-link');
            
            menuLinks.forEach(function(link) {
                const href = link.getAttribute('href');
                if (href && (currentUrl.includes(href) || href.includes(currentUrl.split('/')[1]))) {
                    if (href !== '/' && href.length > 1) { // Avoid matching root
                        activeMenuItem = link;
                    }
                }
            });
        }
        
        return activeMenuItem;
    }
    
    // Function to scroll to active menu item and keep it visible
    function scrollToActiveMenuItem() {
        const sidebar = document.querySelector('.c-sidebar');
        const activeMenuItem = findActiveMenuItem();
        
        console.log('Active menu item found:', activeMenuItem); // Debug log
        
        if (sidebar && activeMenuItem) {
            // Ensure parent dropdown is expanded first
            const parentDropdown = activeMenuItem.closest('.c-sidebar-nav-dropdown');
            if (parentDropdown) {
                parentDropdown.classList.add('c-show');
                const dropdownToggle = parentDropdown.querySelector('.c-sidebar-nav-dropdown-toggle');
                if (dropdownToggle) {
                    dropdownToggle.classList.add('c-active');
                }
            }
            
            // Wait a moment for dropdown to expand, then scroll
            setTimeout(function() {
                // Scroll the sidebar container to show the active item
                const sidebarNav = document.querySelector('.c-sidebar-nav');
                if (sidebarNav) {
                    const activeItemRect = activeMenuItem.getBoundingClientRect();
                    const sidebarRect = sidebarNav.getBoundingClientRect();
                    
                    // Calculate the position to scroll to
                    const itemOffsetTop = activeMenuItem.offsetTop;
                    const sidebarHeight = sidebarNav.clientHeight;
                    const itemHeight = activeMenuItem.offsetHeight;
                    
                    // Center the item in the sidebar view
                    const scrollTop = itemOffsetTop - (sidebarHeight / 2) + (itemHeight / 2);
                    
                    sidebarNav.scrollTo({
                        top: Math.max(0, scrollTop),
                        behavior: 'smooth'
                    });
                }
            }, 100);
        }
    }
    
    // Function to expand parent dropdown if active item is inside it
    function expandActiveDropdown() {
        const activeMenuItem = findActiveMenuItem();
        
        if (activeMenuItem) {
            // Find parent dropdown
            const parentDropdown = activeMenuItem.closest('.c-sidebar-nav-dropdown');
            
            if (parentDropdown) {
                // Add the show class to expand the dropdown
                parentDropdown.classList.add('c-show');
                
                // Also add active class to the dropdown toggle
                const dropdownToggle = parentDropdown.querySelector('.c-sidebar-nav-dropdown-toggle');
                if (dropdownToggle) {
                    dropdownToggle.classList.add('c-active');
                }
            }
        }
    }
    
    // Execute functions
    expandActiveDropdown();
    
    // Wait a bit for any animations to complete, then scroll
    setTimeout(function() {
        scrollToActiveMenuItem();
    }, 200);
    
    // Also handle when dropdowns are toggled
    document.querySelectorAll('.c-sidebar-nav-dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            // Small delay to allow dropdown animation to complete
            setTimeout(function() {
                scrollToActiveMenuItem();
            }, 300);
        });
    });
    
    // Store scroll position when clicking menu items
    document.querySelectorAll('.c-sidebar-nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            const sidebarNav = document.querySelector('.c-sidebar-nav');
            if (sidebarNav) {
                localStorage.setItem('sidebarScrollPosition', sidebarNav.scrollTop);
            }
        });
    });
    
    // Restore scroll position on page load
    window.addEventListener('load', function() {
        const savedScrollPosition = localStorage.getItem('sidebarScrollPosition');
        const sidebarNav = document.querySelector('.c-sidebar-nav');
        
        if (savedScrollPosition && sidebarNav) {
            setTimeout(function() {
                sidebarNav.scrollTop = parseInt(savedScrollPosition);
            }, 100);
        }
        
        // Also try the active menu item method as backup
        setTimeout(function() {
            scrollToActiveMenuItem();
        }, 500);
    });
});
</script>

</body>

</html>