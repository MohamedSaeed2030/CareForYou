<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        try {
            $rule = [

                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
                'password' => 'required|string|min:6',
            ];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);

                return $this->returnValidationError($code, $validator);
            }
            if (! $token = auth()->attempt($validator->validated())) {
                return $this->returnError('401', 'Unauthorized');
            }

            // return $this->createNewToken($token);
            $user = auth()->user();

            $user->expires_in = auth()->factory()->getTTL() * 60;
            $user->api_token = $token;

            return $this->returnData('user', $user);
        } catch(Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);

            return $this->returnValidationError($code, $validator);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return $this->returnData('user', $user, 'User successfully registered', 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->returnSuccessMessage('User successfully signed out', $errNum = 'S000');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return $this->returnData('user', auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];

        return $this->returnDate('data', $data, 'The Token Refreshed successfully');
    }
}
