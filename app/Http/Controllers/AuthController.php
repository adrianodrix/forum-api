<?php

namespace Forum\Http\Controllers;

use Carbon\Carbon;
use Forum\Http\Requests;
use Forum\Http\Requests\Auth\RegisterFormRequest;
use Forum\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use ThrottlesLogins;

    public function signUp(RegisterFormRequest $request)
    {
        return User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
    }

    /**
     * Issue a JWT token when valid login credentials are presented.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = app('tymon.jwt.auth')->attempt($credentials, [
                'exp' => Carbon::now()->addWeek()->timestamp,
            ])) {
                // Increments login attempts
                $this->incrementLoginAttempts($request);
                return response()->json(['error' => app('translator')->get('auth.failed')], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            // Increments login attempts
            $this->incrementLoginAttempts($request);
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => app('translator')->get('auth.could_not_create_token')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // all good so return the token
        return response()->json(compact('token'), Response::HTTP_OK);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        $message = app('translator')->get('auth.throttle', ['seconds' => $seconds]);
        return response()->json(['error' => $message], Response::HTTP_TOO_MANY_REQUESTS);
    }
}
