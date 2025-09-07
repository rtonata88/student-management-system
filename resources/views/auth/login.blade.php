<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{env('APP_NAME')}} - Sign In</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('new/assets/favicon/favicon-32x32.png')}}">
    <link href="{{asset('new/css/style.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .login-container {
            display: flex;
            height: 100vh;
        }
        
        .banner-section {
            flex: 1;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 4rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .banner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="20" cy="80" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 3rem;
            z-index: 1;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: 700;
            color: #4f46e5;
            font-size: 1.5rem;
        }
        
        .brand-name {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .banner-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            z-index: 1;
        }
        
        .banner-subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            color: #fbbf24;
            margin-bottom: 2rem;
            z-index: 1;
        }
        
        .banner-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            opacity: 0.9;
            max-width: 500px;
            z-index: 1;
        }
        
        .feature-list {
            list-style: none;
            z-index: 1;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        
        .feature-icon {
            width: 24px;
            height: 24px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #1f2937;
            font-weight: 600;
            font-size: 0.8rem;
        }
        
        .trusted-badge {
            margin-top: 3rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            z-index: 1;
        }
        
        .trusted-icon {
            margin-right: 0.5rem;
        }
        
        .login-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 2rem;
        }
        
        .top-logo {
            width: 120px;
            height: 120px;
            margin-bottom: 2rem;
            display: block;
        }
        
        .login-form-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: #6b7280;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
            background: #f9fafb;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .form-input::placeholder {
            color: #9ca3af;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 0.5rem;
        }
        
        .remember-me label {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .forgot-link {
            font-size: 0.875rem;
            color: #4f46e5;
            text-decoration: none;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }
        
        .signup-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .signup-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        .copyright {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #9ca3af;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .banner-section {
                flex: none;
                height: 40vh;
                padding: 2rem;
            }
            
            .banner-title {
                font-size: 2rem;
            }
            
            .banner-subtitle {
                font-size: 1.2rem;
            }
            
            .feature-list {
                display: none;
            }
            
            .login-section {
                flex: 1;
                padding: 1rem;
            }
            
            .top-logo {
                width: 100px;
                height: 100px;
                margin-bottom: 1.5rem;
            }
            
            .login-form-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Banner Section -->
        <div class="banner-section">
            <div class="logo-container">
                <div class="logo">E</div>
                <div class="brand-name">Educims</div>
            </div>
            
            <h1 class="banner-title">Elevate Student Success</h1>
            <h2 class="banner-subtitle">Tutorial Excellence</h2>
            
            <p class="banner-description">
                Comprehensive tutorial management system designed for academic improvement centers. 
                Track progress, boost grades, and achieve educational goals.
            </p>
            
            <ul class="feature-list">
                <li class="feature-item">
                    <div class="feature-icon">📈</div>
                    Grade Improvement Tracking
                </li>
                <li class="feature-item">
                    <div class="feature-icon">🎯</div>
                    Personalized Learning Plans
                </li>
                <li class="feature-item">
                    <div class="feature-icon">📊</div>
                    Progress Analytics & Reports
                </li>
            </ul>
            
            <div class="trusted-badge">
                <span class="trusted-icon">🎓</span>
                Trusted by Tutorial Colleges
            </div>
        </div>
        
        <!-- Login Section -->
        <div class="login-section">
            @php
                $company = \App\CompanySetup::first();
            @endphp
            @if($company && $company->logo)
                <img src="{{asset('storage/'.$company->logo)}}" alt="{{$company->company_name ?? 'School'}} Logo" class="top-logo">
            @else
                <img src="{{asset('assets/Logo.png')}}" alt="School Logo" class="top-logo">
            @endif
            <div class="login-form-container">
                <div class="login-header">
                    <h1 class="login-title">Sign in</h1>
                    <p class="login-subtitle">Sign in and start using Educims</p>
                </div>
                
                <form action="{{ route('login') }}" method="post" id="loginform">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label class="form-label">Username or Email</label>
                        <input class="form-input" type="text" required="" name="username" placeholder="Enter your username or email">
                        @if ($errors->has('username'))
                        <div class="error-message">
                            <strong>{{ $errors->first('username') }}</strong>
                        </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input class="form-input" type="password" required="" name="password" placeholder="Password">
                        @if ($errors->has('password'))
                        <div class="error-message">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                    </div>
                    
                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Keep me signed in</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot your password?</a>
                    </div>
                    
                    <button class="login-button" type="submit">Sign In</button>
                </form>
                
                <div class="signup-link">
                    DON'T HAVE AN ACCOUNT? <a href="{{ route('online-application.signup') }}">SIGN UP</a>
                </div>
                
                <div class="copyright">
                    Copyright 2025, Educims All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>