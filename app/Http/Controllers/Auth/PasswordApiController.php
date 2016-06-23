<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Encryption\DecryptException;
use Validator;
use DB;
use Crypt;

class PasswordApiController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	protected $redirectTo = '/admin/login';
	protected $guard = 'api';

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
	}

	/**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getResetValidationRules(),
            $this->getResetValidationMessages(),
            $this->getResetValidationCustomAttributes()
        );
        
        if($validator->fails()) {
        	$errors = $validator->errors();
			return $errors->toJson();
        }

        $credentials = $this->getResetCredentials($request);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return $this->getResetSuccessResponse($response);
            default:
                return $this->getResetFailureResponse($request, $response);
        }
    }

	/**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        //Auth::guard($this->getGuard())->login($user);
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetSuccessResponse($response)
    {
        //return redirect($this->redirectPath())->with('status', trans($response));
        return response()->json(['message' => trans($response)]);
    }

    /**
     * Get the response for after a failing password reset.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetFailureResponse(Request $request, $response)
    {
    	return response()->json(['error' => ['email' => trans($response)]]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateSendResetLinkEmail($request);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $this->getSendResetLinkEmailCredentials($request),
            $this->resetEmailBuilder()
        );

        //Crypt::setKey(Config::get('app.key'));
        //print_r($request->email);
        $mail = $request->email;

        $users = DB::table('users')
                    ->where('email', $mail)
                    ->get([Crypt::decrypt('password')]);

        //$new_password = Crypt::decrypt($users);

        return response()->json(['items' => $users]);

        //print_r($results);

        // switch ($response) {
        //     case Password::RESET_LINK_SENT:
        //         return $this->getSendResetLinkEmailSuccessResponse($response);
        //     case Password::INVALID_USER:
        //     default:
        //         return $this->getSendResetLinkEmailFailureResponse($response);
        // }
    }

    /**
     * Get the response for after the reset link could not be sent.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return response()->json(['errors' => ['email' => trans($response)]]);
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        //return redirect()->back()->with('status', trans($response));
        return response()->json(['status' => trans($response)]);

        /* for the password sending*/

        // $mail = $request->email;
        // $users = DB::table('users')
        //             ->where('email', $mail)
        //             ->get(['password']);
        // return response()->json(['items' => $users])

        
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        return response()->json(compact('token', 'email'));
    }

}
