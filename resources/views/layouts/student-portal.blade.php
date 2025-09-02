<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Student Portal') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('new/assets/favicon/favicon-32x32.png')}}">
    
    <!-- CoreUI CSS -->
    <link href="{{asset('new/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('new/node_modules/@coreui/chartjs/css/coreui-chartjs.css')}}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        .student-portal-sidebar {
            background: linear-gradient(180deg, #3c4b64 0%, #1e2125 100%);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        .student-portal-sidebar .c-sidebar-brand-full {
            color: white;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
        }
        
        .student-portal-sidebar .c-sidebar-nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 14px;
            padding: 12px 20px;
            border-radius: 0;
        }
        
        .student-portal-sidebar .c-sidebar-nav-link:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
            color: white !important;
            transform: translateX(5px);
        }
        
        .c-sidebar-nav-link:hover .c-sidebar-nav-icon {
            color: white !important;
        }
        
        /* Active/current page styling */
        .c-sidebar .c-sidebar-nav-link.c-active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        .c-sidebar .c-sidebar-nav-link.c-active .c-sidebar-nav-icon {
            color: #fff !important;
        }

        /* Keep dropdown open when child is active */
        .c-sidebar .c-sidebar-nav-dropdown.c-show > .c-sidebar-nav-dropdown-toggle {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%) !important;
            color: #fff !important;
        }
        
        /* Header account dropdown to match admin theme */
        .c-header-nav-link:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            border-color: #667eea !important;
            transform: translateY(-1px);
        }
        
        .student-portal-sidebar .c-sidebar-nav-link.c-active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .student-portal-sidebar .c-sidebar-nav-dropdown-items .c-sidebar-nav-link {
            padding-left: 50px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .student-portal-sidebar .c-sidebar-nav-dropdown-items .c-sidebar-nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.08);
        }
        
        .c-header {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        .page-title {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 600;
            color: #495057;
        }
        
        .card-title, .header-title {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 600;
        }
        
        .breadcrumb {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 13px;
        }
        
        .student-welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-card {
            border-left: 4px solid #667eea;
        }
    </style>
</head>

<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar" style="background: linear-gradient(180deg, #4a5568 0%, #2d3748 50%, #1a202c 100%);">
        <div class="c-sidebar-brand d-lg-down-none" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="c-sidebar-brand-full" style="color: white; font-weight: 700; font-size: 16px; letter-spacing: 2px; padding: 15px 20px; text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                MY STUDENT PORTAL
            </div>
        </div>
        
        <ul class="c-sidebar-nav" style="padding-bottom: 200px; padding-top: 20px;">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.dashboard') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                    <i class="fas fa-tachometer-alt c-sidebar-nav-icon" style="color: rgba(255,255,255,0.7);"></i> Dashboard
                </a>
            </li>
            
            <!-- Profile Section -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                    <i class="fas fa-user c-sidebar-nav-icon" style="color: rgba(255,255,255,0.7);"></i> Profile
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.my-info') }}" style="color: rgba(255,255,255,0.8); padding-left: 50px;">
                            <span class="c-sidebar-nav-icon"></span> My Info
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.my-documents') }}" style="color: rgba(255,255,255,0.8); padding-left: 50px;">
                            <span class="c-sidebar-nav-icon"></span> My Documents
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.my-applications') }}" style="color: rgba(255,255,255,0.8); padding-left: 50px;">
                            <span class="c-sidebar-nav-icon"></span> My Applications
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Academics Section -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-graduation-cap c-sidebar-nav-icon"></i> Academics
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.ca-marks') }}">
                            <span class="c-sidebar-nav-icon"></span> CA Marks
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.exam-marks') }}">
                            <span class="c-sidebar-nav-icon"></span> Exam Marks
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.class-routine') }}">
                            <span class="c-sidebar-nav-icon"></span> Class Routine
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.exam-timetable') }}">
                            <span class="c-sidebar-nav-icon"></span> Exam Time Table
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.academic-script') }}">
                            <span class="c-sidebar-nav-icon"></span> Academic Script
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.proof-of-registration') }}">
                            <span class="c-sidebar-nav-icon"></span> Proof of Registration
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Finance Section -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-money-bill-wave c-sidebar-nav-icon"></i> Finance
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.my-payments') }}">
                            <span class="c-sidebar-nav-icon"></span> My Payments
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.financial-statement') }}">
                            <span class="c-sidebar-nav-icon"></span> Financial Statement
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- My Subjects -->
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.my-subjects') }}">
                    <i class="fas fa-book c-sidebar-nav-icon"></i> My Subjects
                </a>
            </li>
            
            <!-- Online Learning -->
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.online-learning') }}">
                    <i class="fas fa-laptop c-sidebar-nav-icon"></i> Online Learning
                </a>
            </li>
            
            <!-- Library Management Section -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-book-open c-sidebar-nav-icon"></i> Library Management
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.library-books') }}">
                            <span class="c-sidebar-nav-icon"></span> Library Books
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.library-fines') }}">
                            <span class="c-sidebar-nav-icon"></span> Library Fines
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.borrow-history') }}">
                            <span class="c-sidebar-nav-icon"></span> My Borrow History
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Hostel Management Section -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-home c-sidebar-nav-icon"></i> Hostel Management
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.hostel-applications') }}">
                            <span class="c-sidebar-nav-icon"></span> Applications
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('student-portal.my-hostel-data') }}">
                            <span class="c-sidebar-nav-icon"></span> My Hostel Data
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- The Market Place -->
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.marketplace') }}">
                    <i class="fas fa-shopping-cart c-sidebar-nav-icon"></i> The Market Place
                </a>
            </li>
            
            <!-- Support Centre Section -->
            <li class="c-sidebar-nav-title" style="color: rgba(255, 255, 255, 0.6); font-size: 11px; font-weight: 600; letter-spacing: 1px; margin-top: 20px;">SUPPORT CENTRE</li>
            
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.user-manuals') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                    <i class="fas fa-book c-sidebar-nav-icon" style="color: rgba(255,255,255,0.7);"></i> User Manuals
                </a>
            </li>
            
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.video-tutorials') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                    <i class="fas fa-video c-sidebar-nav-icon" style="color: rgba(255,255,255,0.7);"></i> Video Tutorials
                </a>
            </li>
            
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.faq-help') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                    <i class="fas fa-question-circle c-sidebar-nav-icon" style="color: rgba(255,255,255,0.7);"></i> FAQ & Help
                </a>
            </li>
            
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('student-portal.quick-support') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                    <i class="fas fa-headset c-sidebar-nav-icon" style="color: rgba(255,255,255,0.7);"></i> Quick Support
                </a>
            </li>
        </ul>
        
        <!-- Support & Manuals Footer -->
        <div style="position: fixed; bottom: 0; left: 0; right: 0; width: 256px; background: linear-gradient(180deg, transparent 0%, rgba(26, 32, 44, 0.95) 30%, rgba(26, 32, 44, 1) 100%); padding: 20px; text-align: center; z-index: 1000;">
            <div style="background: rgba(0,0,0,0.3); border-radius: 10px; padding: 20px; color: white;">
                <div style="width: 50px; height: 50px; background: #4285f4; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-life-ring" style="font-size: 24px;"></i>
                </div>
                <h6 style="margin-bottom: 10px; font-weight: 600;">Support & Manuals</h6>
                <p style="font-size: 12px; margin-bottom: 10px; opacity: 0.8;">+264 81 37 0 37 26<br>info@educims.com</p>
                <a href="{{ route('student-portal.get-support') }}" class="btn btn-light btn-sm" style="border-radius: 20px; padding: 8px 20px; font-size: 12px; font-weight: 600;">
                    Get Support
                </a>
            </div>
        </div>
        
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>

    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item dropdown">
                    <a class="c-header-nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="userDropdown" style="background-color: #f8f9fa; border-radius: 25px; padding: 6px 16px; border: 1px solid #dee2e6; transition: all 0.2s ease;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 28px; height: 28px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-user" style="color: white; font-size: 14px;"></i>
                            </div>
                            <span style="color: #495057; font-weight: 500; font-size: 14px;">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 10px;"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="userDropdown" style="border: 1px solid #dee2e6; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); z-index: 1050;">
                        <div class="dropdown-header bg-primary text-white py-2"><strong>Account</strong></div>
                        <a class="dropdown-item" href="{{ route('student-portal.profile') }}" style="color: #495057;">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </header>

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/pace/pace.min.js') }}"></script>
    <script src="{{ asset('bower_components/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('bower_components/coreui/dist/js/coreui.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Function to check if current page matches route and set active states
            function setActiveMenus() {
                var currentPath = window.location.pathname;
                
                // Remove all active classes first
                $('.c-sidebar-nav-link').removeClass('c-active');
                $('.c-sidebar-nav-dropdown').removeClass('c-show');
                $('.c-sidebar-nav-dropdown-items').hide();
                
                // Check each menu item
                $('.c-sidebar-nav-link').each(function() {
                    var href = $(this).attr('href');
                    if (href && currentPath.includes(href.split('/').pop())) {
                        $(this).addClass('c-active');
                        
                        // If this is inside a dropdown, open the parent dropdown
                        var $parentDropdown = $(this).closest('.c-sidebar-nav-dropdown');
                        if ($parentDropdown.length) {
                            $parentDropdown.addClass('c-show');
                            $parentDropdown.find('.c-sidebar-nav-dropdown-items').show();
                        }
                    }
                });
            }
            
            // Set active menus on page load
            setActiveMenus();
            
            // Handle dropdown clicks
            $('.c-sidebar-nav-dropdown-toggle').click(function(e) {
                e.preventDefault();
                var $parent = $(this).parent();
                var $items = $parent.find('.c-sidebar-nav-dropdown-items');
                
                // Close other dropdowns
                $('.c-sidebar-nav-dropdown').not($parent).removeClass('c-show');
                $('.c-sidebar-nav-dropdown-items').not($items).slideUp(200);
                
                // Toggle current dropdown
                $parent.toggleClass('c-show');
                $items.slideToggle(200);
            });
            
            // Handle submenu clicks - keep parent open and highlight clicked item
            $('.c-sidebar-nav-dropdown-items .c-sidebar-nav-link').click(function() {
                // Remove active from all menu items
                $('.c-sidebar-nav-link').removeClass('c-active');
                // Add active to clicked item
                $(this).addClass('c-active');
                // Keep parent dropdown open
                $(this).closest('.c-sidebar-nav-dropdown').addClass('c-show');
            });
            
            // Ensure header dropdown works
            $('#userDropdown').on('click', function(e) {
                e.preventDefault();
                $(this).next('.dropdown-menu').toggle();
            });
            
            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').hide();
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
