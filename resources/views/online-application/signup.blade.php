<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{env('APP_NAME')}} - Create Student Account</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .signup-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
        }
        
        .signup-header {
            background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .signup-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .signup-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .signup-form {
            padding: 2rem;
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
        
        .required {
            color: #ef4444;
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
        
        .password-info {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .password-info-text {
            color: #6366f1;
            font-size: 0.875rem;
            line-height: 1.4;
        }
        
        .signup-button {
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
        
        .signup-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .login-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .row {
            display: flex;
            gap: 1rem;
        }
        
        .col {
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                gap: 0;
            }
            
            .signup-container {
                margin: 1rem;
            }
            
            .signup-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <h1 class="signup-title">Create Student Account</h1>
            <p class="signup-subtitle">Join our educational community</p>
            <div style="margin-top: 1rem;">
                <a href="{{ route('online-application.manual') }}" target="_blank" 
                   style="display: inline-block; background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.3); transition: all 0.2s;"
                   onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    <i class="fas fa-download"></i> How to apply manual
                </a>
            </div>
        </div>
        
        <form class="signup-form" action="{{ route('online-application.create-account') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">First Names <span class="required">*</span></label>
                        <input type="text" name="first_names" class="form-input" placeholder="Enter first names here..." value="{{ old('first_names') }}" required>
                        @if ($errors->has('first_names'))
                            <div class="error-message">{{ $errors->first('first_names') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Surname <span class="required">*</span></label>
                        <input type="text" name="surname" class="form-input" placeholder="Enter surname here..." value="{{ old('surname') }}" required>
                        @if ($errors->has('surname'))
                            <div class="error-message">{{ $errors->first('surname') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" name="email" class="form-input" placeholder="Enter email here..." value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label class="form-label">Password <span class="required">*</span></label>
                <input type="password" name="password" class="form-input" placeholder="Students@321" required>
                @if ($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label class="form-label">Confirm Password <span class="required">*</span></label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm your password" required>
            </div>
            
            <div class="password-info">
                <p class="password-info-text">
                    Please ensure that you provide an active email address to which you have regular access, as your admission letter and all official communications will be sent to that address.
                </p>
            </div>
            
            <button type="submit" class="signup-button">Create Account</button>
            
            <div class="login-link" style="margin-top: 1rem;">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </form>
    </div>
</body>
</html>
