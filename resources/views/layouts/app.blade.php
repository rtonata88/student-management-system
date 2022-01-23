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

</head>

<body class="c-app">
  <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
      <span class="text-uppercase font-weight-bold">STUDENT MANAGEMENT SYSTEM</span>
    </div>
    <ul class="c-sidebar-nav">
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="/home">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-speedometer')}}"></use>
          </svg> Dashboard
        </a>
      </li>
      <li class="c-sidebar-nav-title">MANAGEMENT</li>
      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/therapists">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-group')}}"></use>
          </svg> Students</a>
      </li>

      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/appointments">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
          </svg> Enrollment</a>
      </li>
      <li class="c-sidebar-nav-title">FINANCE</li>
      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/therapists">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-group')}}"></use>
          </svg> Invoices</a>
      </li>
      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/appointments">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
          </svg> Payments</a>
      </li>

      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/appointments">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
          </svg> Student Statements</a>
      </li>
      <li class="c-sidebar-nav-title">REPORTS</li>
      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/therapists">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-group')}}"></use>
          </svg> Students</a>
      </li>

      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/appointments">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
          </svg> Invoices</a>
      </li>

      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/appointments">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}}"></use>
          </svg> Payments</a>
      </li>

      
      <li class="c-sidebar-nav-title">Administration</li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked')}}"></use>
          </svg> Access management</a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin-clerks"><span class="c-sidebar-nav-icon"></span> Admin Clerks</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/users"><span class="c-sidebar-nav-icon"></span> Users</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/roles"><span class="c-sidebar-nav-icon"></span> Roles</a></li>
        </ul>
      </li>

      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cog')}}"></use>
          </svg> Setups</a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('registration-boards.index')}}"><span class="c-sidebar-nav-icon"></span> Subjects</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('countries.index')}}"><span class="c-sidebar-nav-icon"></span> Other fees</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('license-types.index')}}"><span class="c-sidebar-nav-icon"></span> Centers</a></li>
        </ul>
      </li>
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
        LOTUS </a>
      <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
          <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}}"></use>
        </svg>
      </button>
      <ul class="c-header-nav ml-auto mr-4">

        <li class="c-header-nav-item dropdown">
          <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="c-avatar">
              <svg class="c-icon mr-2">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-smile ')}}"></use>
              </svg>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right pt-0">
            <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        <div class="text-uppercase"> &copy; {{date('Y')}} STUDENT MANAGEMENT SYSTEM.
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

  <!-- start - This is for export functionality only -->
  <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
 <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
 <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script> -->




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
</body>

</html>