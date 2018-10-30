<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Philips List - Admin Panel</title>
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
  <link href="{{asset('bower_components/summernote/dist/summernote.css')}}" rel="stylesheet" />


  <!-- Page CSS -->
  <link href="{{asset('bower_components/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css" />

  <!-- Page plugins css -->
  <link href="{{asset('bower_components/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet">
  <!-- Color picker plugins css -->
  <link href="{{asset('bower_components/clockpicker/asColorPicker.css')}}" rel="stylesheet">

  <link href="{{asset('bower_components/datatables.net/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


     <style>
        #profiles-table tbody tr {
            cursor: pointer;
        }
        table {
          font-size: 10px;
        }
    </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
    <div>
     @yield('content')
     <!-- /.container-fluid -->
     <footer class="footer text-center"> 2018 &copy; PHILIPS List</footer>
   </div>
   <!-- ============================================================== -->
   <!-- End Page Content -->
   <!-- ============================================================== -->
</body>

</html>
