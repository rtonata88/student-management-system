<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PEACEBase</title>
  <!-- Bootstrap Core CSS -->
  <link href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/typeahead.css')}}" rel="stylesheet">
  <!-- Menu CSS -->
  <link href="{{asset('assets/plugins/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">
  <!-- animation CSS -->
  <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <!-- Date picker plugins css -->
  <link href="{{asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- color CSS -->
  <link href="{{asset('assets/css/colors/default.css')}}" id="theme" rel="stylesheet">

  <!-- Page CSS -->
  <link href="{{asset('bower_components/multi-select/multi-select.css')}}" rel="stylesheet" type="text/css" />

  <!-- Gallery -->
  <link rel="stylesheet" type="text/css" href="{{asset('bower_components/gallery/css/animated-masonry-gallery.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('bower_components/fancybox/ekko-lightbox.min.css')}}" />

  <!-- Wizard CSS -->
  <link href="{{asset('bower_components/jquery-wizard-master/steps.css')}}" rel="stylesheet">

  <!-- summernotes CSS -->
  <link href="{{asset('bower_components/summernote/summernote.css')}}" rel="stylesheet" />


  <!-- Page CSS -->
  <link href="{{asset('bower_components/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css" />

  <!-- Page plugins css -->
  <link href="{{asset('bower_components/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet">
  <!-- Color picker plugins css -->
  <link href="{{asset('bower_components/clockpicker/asColorPicker.css')}}" rel="stylesheet">

  <link href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('bower_components/datatables.net/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('bower_components/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />



  <style>
  #profiles-table tbody tr {
    cursor: pointer;
  }
</style>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="fix-header">
  <!-- ============================================================== -->
  <!-- Preloader -->
  <!-- ============================================================== -->
  <div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
  </div>
  <!-- ============================================================== -->
  <!-- Wrapper -->
  <!-- ============================================================== -->
  <div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
      <div class="navbar-header">
        <div class="top-left-part">
          <!-- Logo -->
          <a class="logo" href="/home">
            <!-- Logo icon image, you can use font-icon also --><b>
            </b>
            <!-- Logo text image you can use text also --><span class="hidden-xs">
              <!--This is dark logo text--><img src="{{asset('assets/plugins/images/admin-text.png')}}" alt="home" class="dark-logo" /><!--This is light logo text--><img src="{{asset('assets/plugins/images/admin-text-dark.png')}}" alt="home" class="light-logo" />
            </span> </a>
          </div>
          <!-- /Logo -->
          <ul class="nav navbar-top-links navbar-right pull-right">
            <li>
              <a class="profile-pic" href="#"> <img src="{{asset('assets/plugins/images/users/varun.png')}}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{Auth::user()->name}}</b></a>
            </li>
          </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
      </nav>
      <!-- End Top Navigation -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
          <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
          </div>
          <ul class="nav" id="side-menu">
            <li style="padding: 70px 0 0;">
              <a href="/home" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
            </li>
            @if(Auth::user()->hasRole('Profiles'))
             <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-users fa-fw" aria-hidden="true"></i> <span class="hide-menu">Profiles<span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                @if(Auth::user()->hasRole('Fruit Profiles'))
                <li> <a href="/profiles"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Profiles</span></a> </li>
                @endif
                @if(Auth::user()->hasRole('WARP Office Attendees'))
                <li> <a href="/warp-attendees"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">WARP Attendees</span></a> </li>
                @endif

                @if(Auth::user()->hasRole('Maintainer Assignment'))
                <li> <a href="/maintainer-assignment"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Staff Assignment</span></a> </li>
                @endif
              </ul>
            </li>
            @endif

<!--             <li>
              <a href="/communication" class="waves-effect"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>COMMUNICATION</a>
            </li> -->
            @if(Auth::user()->hasRole('Documentation'))
            <li>
              <a href="/documentation" class="waves-effect"><i class="fa fa-files-o fa-fw" aria-hidden="true"></i>Documentation</a>
            </li>
            @endif
            @if(Auth::user()->hasRole('Campaign'))
             <li>
              <a href="/campaigns" class="waves-effect"><i class="fa fa-bullhorn fa-fw" aria-hidden="true"></i>Campaigns</a>
            </li>
            @endif
            @if(Auth::user()->hasRole('Events'))
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-map-marker fa-fw" aria-hidden="true"></i> <span class="hide-menu">Events<span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                @if(Auth::user()->hasRole('Internal Events'))
                <li> <a href="/events"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Internal Events</span></a> </li>
                @endif
                @if(Auth::user()->hasRole('External Events'))
                <li> <a href="/external-events"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">External Events</span></a> </li>
                @endif
                @if(Auth::user()->hasRole('Event Guest Check In'))
                <li> <a href="/event-check-in"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Guest Check In</span></a> </li>
                @endif
              </ul>
            </li>
            @endif
            @if(Auth::user()->hasRole('Reports'))
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-bar-chart fa-fw"></i> <span class="hide-menu">Reports<span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li> <a href="/reports/profiles"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Profiles</span></a> </li>
                <li> <a href="/reports/warp-attendees"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">WARP Attendees</span></a> </li>
                <li> <a href="/reports/documentation"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Documentation</span></a> </li>
                <li> <a href="/reports/periodic"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Periodic Reports</span></a> </li>
                <li> <a href="/report/internal/events"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Internal Event Reports</span></a> </li>

                <li> <a href="/report/external/events"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">External Event Reports</span></a> </li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->hasRole('Access Management'))
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-lock fa-fw" aria-hidden="true"></i> <span class="hide-menu">Access<span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li> <a href="/users"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Users</span></a> </li>
                <li> <a href="/roles"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Roles</span></a> </li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->hasRole('Setup'))
            <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span class="hide-menu">Setup<span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li> <a href="/cities"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Cities</span></a> </li>
                <li> <a href="/countries"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Countries</span></a> </li>
                <li> <a href="/departments"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Departments</span></a> </li>
                <li> <a href="/document-types"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Document Types</span></a> </li>
                <li> <a href="/duties"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Duties</span></a> </li>
                <li> <a href="/event-types"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Event Types</span></a> </li>
                <li> <a href="/activity-types"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Fruit Activity Types</span></a> </li>
                <li> <a href="/fruit-levels"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Fruit Levels</span></a> </li>
                <li> <a href="/fruit-roles"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Fruit Roles</span></a> </li>
                <li> <a href="/fruit-stages"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Fruit Stages</span></a> </li>
                <li> <a href="/titles"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Titles</span></a> </li>
                <li> <a href="/industries"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Industries</span></a> </li>
                <li> <a href="/languages"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Languages</span></a> </li>
                <li> <a href="/maintainers"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Staff</span></a> </li>
                <li> <a href="/meeting-types"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Meeting Types</span></a> </li>
                <li> <a href="/organizations"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Organisations</span></a> </li>
                <li> <a href="/religions"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Religions</span></a> </li>
                <li> <a href="/report-types"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Report Types</span></a> </li>
                <li> <a href="/teams"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Teams</span></a> </li>
                <li> <a href="/titles"><i data-icon="7" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Titles</span></a> </li>
              </ul>
            </li>
            @endif
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out fa-fw" aria-hidden="true"> </i> {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>

      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->

    <div id="page-wrapper">
     @yield('content')
     <!-- /.container-fluid -->
     <footer class="footer text-center"> {{date('Y')}} &copy; PEACE<i>Base</i></footer>
   </div>
   <!-- ============================================================== -->
   <!-- End Page Content -->
   <!-- ============================================================== -->
 </div>
 <!-- /#wrapper -->
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
 <script src="{{asset('assets/js/dashboard1.js')}}"></script>
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
 <!--  Data Tables -->
 <script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
 <script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.js')}}"></script>

 <!-- start - This is for export functionality only -->
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
 <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
 <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
 <!-- end - This is for export functionality only -->

 <script src="{{asset('js/peaceapp.js')}}"></script>
 <script src="{{asset('js/charts.js')}}"></script>

 <script>
    // Date Picker
    $('body').on('focus',".mydatepicker", function(){
      $(this).datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
      });
    })

    // Clock pickers
    $('body').on('focus',".timepicker", function(){
      $(this).clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
      });
    });


    jQuery(".select2").select2();
    jQuery(".select2").on('select2:select', function(e){
      var id = e.params.data.id;
      var option = $(e.target).children('[value="'+id+'"]');
      option.detach();
      $(e.target).append(option).change();
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function($) {
        // delegate calls to data-toggle="lightbox"
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
          event.preventDefault();
          return $(this).ekkoLightbox({
            onShown: function() {
              if (window.console) {
                return console.log('Checking our the events huh?');
              }
            },
            onNavigate: function(direction, itemIndex) {
              if (window.console) {
                return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
              }
            }
          });
        });
        //Programatically call
        $('#open-image').click(function(e) {
          e.preventDefault();
          $(this).ekkoLightbox();
        });
        $('#open-youtube').click(function(e) {
          e.preventDefault();
          $(this).ekkoLightbox();
        });
        // navigateTo
        $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
          event.preventDefault();
          var lb;
          return $(this).ekkoLightbox({
            onShown: function() {
              lb = this;
              $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                e.preventDefault();
                lb.navigateTo(2);
              });
            }
          });
        });
      });
    </script>
    <script type="text/javascript">
      $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
          finish: "Submit"
        },
        onFinished: function (event, currentIndex) {
          swal("Form Submitted!", "The event has been created, if you were not setting it up, you can still edit it");

        }
      });


      var form = $(".validation-wizard").show();

      $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
          finish: "Submit"
        },
        onStepChanging: function (event, currentIndex, newIndex) {
          return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        },
        onFinishing: function (event, currentIndex) {

          return form.validate().settings.ignore = ":disabled", form.valid()
        },
        onFinished: function (event, currentIndex) {
          $("#events-form").submit();
        }
      }), $(".validation-wizard").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
          $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
          $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
          error.insertAfter(element)
        },
        rules: {
          email: {
            email: !0
          }
        }
      })
    </script>
    <script>


      $(function() {
        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
          });
        $('.inline-editor').summernote({
          airMode: true
        });
      });
      window.edit = function() {
        $(".click2edit").summernote()
      }, window.save = function() {
        $(".click2edit").summernote('destroy');
      }

      $('#dataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

      $('#dataTable2').DataTable({
        dom: 'Bfrtip'
      });
      $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary m-r-10');


      $('#events-tabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
      var id = $(e.target).attr("href").substr(1);
      window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#events-tabs a[href="' + hash + '"]').tab('show');

  </script>

  @stack('dataTableScript')
  @stack('profiles')
  @stack('googleCharts')

</body>

</html>
