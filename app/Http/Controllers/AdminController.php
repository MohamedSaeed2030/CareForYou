<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        return 'Hello Wold';
    }

    public function login(Request $request)
    {
        //VALIDATION
        try {
            $rules = [
                'email' => 'required|exists:admins,email',
                'password' => 'required',
            ];

            $validator = Validator::make($request->header(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);

                return $this->returnValidationError($code, $validator);
            }

            //LOGIN
            $credentials = $validator->validated();
            // $request->only(['email', 'password']);
            $token = Auth::guard('admin-api')->attempt($credentials);

            if (! $token) {
                return $this->returnError('E001', 'Invalid Data');
            }
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;

            return $this->returnData('admin', $admin);
        } catch(\Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
