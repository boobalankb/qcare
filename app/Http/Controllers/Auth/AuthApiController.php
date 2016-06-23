<?php namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;

class AuthApiController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	protected $guard = 'api';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct()
	{

		$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6',
			'phoneno' => 'required|max:255',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'phoneno' => $data['phoneno'],
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function register(Request $request) {
		$validator = $this->validator($request->all());

	    if ($validator->fails()) {
	        $errors = $validator->errors();
			return $errors->toJson();
	    }
	    
	    $this->create($request->all());

	    $credentials = [
	        'email' => $request['email'],
	        'password' => $request['password'],
	    ];

	    $token = Auth::guard($this->getGuard())->attempt($credentials);

	    // update the user role
	    $user = User::where('email', $credentials['email'])->first();
	    $user->assignRole(2);	// 2 is donor br default. TODO: Make it dynamic from request

	    return response()->json(['token' => $token]);
	}

	/**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        
        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->handleUserWasAuthenticated($request, $throttles, $token);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
	        'message'  => 'Logged Out'
	    ]);
    }

    protected function handleUserWasAuthenticated(Request $request, $throttles, $token)
	{
	    if ($throttles) {
	        $this->clearLoginAttempts($request);
	    }

	    if (method_exists($this, 'authenticated')) {
	        return $this->authenticated($request, Auth::guard($this->getGuard())->user(), $token);
	    }

	    return redirect()->intended($this->redirectPath());
	}

	protected function authenticated($request, $user, $token)
	{
	    return response()->json([
	        'user'    => $user,
	        'request' => $request->all(),
	        'token'   => $token
	    ]);
	}

	protected function sendFailedLoginResponse(Request $request)
	{
	    return response()->json([
	        'message'  => $this->getFailedLoginMessage(),
	        'username' => $this->loginUsername(),
	        'request'  => $request,
	    ]);
	}

}
