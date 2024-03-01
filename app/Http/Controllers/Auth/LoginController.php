<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) 
    {
        $this->validateLogin($request);
        
        //login credentails
        $username = $request->username; //.'nnn';
        $password = $request->password;

        // dd(env('APP_ENV'));
        
        //FOR LOCAL TESTING PURPOSES ONLY
        //login in with username and username as password
        if(env('APP_ENV') == 'local')
        {   
            if($user = User::where('username', $username)->first())
            {
                $user->password = bcrypt('Ndeya@321');
                $user->save();
            }
            if(Auth::attempt(['username' => $username, 'password' => 'Ndeya@321' ]))
            {   
                // staff Authentication passed...
                return redirect('/home');
            }
        }
        //FOR LOCAL TESTING PURPOSES ONLY

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            
        // This section is the only change
            if ($this->guard()->validate($this->credentials($request))) {
                
                $user = $this->guard()->getLastAttempted();
                
            // Make sure the user is active
                if ($this->attemptLogin($request)) {
                // Send the normal successful login response
                    return $this->sendLoginResponse($request);
                } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                    $this->incrementLoginAttempts($request);
                    return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'You must be active to login.']);
                }
            }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        
        // Customization: validate if user status is active (1)
        return $credentials;
    }
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request, $trans = 'auth.failed')
    {
        $errors = [$this->username() => trans($trans)];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
        ->withInput($request->only($this->username(), 'remember'))
        ->withErrors($errors);
    }
}
