<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;

class RegisterApiController extends ApiController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->respondWithErrors('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // $success['token'] =  $user->createToken('testing')->plainTextToken; // Sanctum
        // $success['token'] =  $user->createToken('testing')->accessToken; // Passport
        $success['name'] =  $user->name;

        return $this->respondWithSuccess($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // $success['token'] =  $user->createToken('testing')->plainTextToken; // Sanctum
            // $success['token'] =  $user->createToken('testing')->accessToken; // Passport
            $success['name'] =  $user->name;

            return $this->respondWithSuccess($success, 'User login successfully.');
        } else {
            return $this->respondWithErrors('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
