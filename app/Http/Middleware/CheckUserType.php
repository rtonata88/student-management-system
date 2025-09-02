<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $userType
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Allow multiple user types separated by |
        $allowedTypes = explode('|', $userType);
        
        if (!in_array($user->user_type, $allowedTypes)) {
            // Redirect based on user type
            switch ($user->user_type) {
                case 'student':
                    return redirect()->route('student-portal.dashboard')
                        ->with('error', 'Access denied. You do not have permission to access this area.');
                case 'parent':
                    return redirect()->route('parent-portal.dashboard')
                        ->with('error', 'Access denied. You do not have permission to access this area.');
                case 'staff':
                default:
                    return redirect()->route('welcome')
                        ->with('error', 'Access denied. You do not have permission to access this area.');
            }
        }

        return $next($request);
    }
}
