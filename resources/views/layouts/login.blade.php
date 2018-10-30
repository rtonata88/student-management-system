
<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
<title>PHILIPS List - Login</title>
<!-- Bootstrap Core CSS -->
<link href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- animation CSS -->
<link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
<!-- color CSS -->
<link href="{{asset('assets/css/colors/default.css')}}" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="new-login-register">
      <div class="lg-info-panel">
              <div class="inner-panel">
                  <a href="javascript:void(0)" class="p-20 di"></a>
                  <div class="lg-content">
                      <h2><strong>PHILIPS</strong>List</h2>
                      <p class="text-muted">Enlightening to Cultivate Talented Individuals with the Values and Spirit of Peace</p>
                  </div>
              </div>
      </div>
      @yield('content')
  
</section>
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
<!-- Custom Theme JavaScript -->
<script src="{{asset('assets/js/custom.min.js')}}"></script>
</body>
</html>
