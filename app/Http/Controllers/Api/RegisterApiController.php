<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\RefreshTokenRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;

class RegisterApiController extends ApiController
{
    /**
     * Register
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'confirmed' => 'required|string|min:8|same:password',
        ]);

        if ($validator->fails()) {
            return $this->respondWithErrors('Validation Error.', $validator->errors());
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // $success['token'] =  $user->createToken('testing')->plainTextToken; // Sanctum
        $success['token'] =  $user->createToken('testing')->accessToken; // Passport
        $success['name'] =  $user->name;

        return $this->respondWithSuccess($success, 'User register successfully.');
    }

    /**
     * Login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|string|email:rfc,dns|max:255',
            'password' => 'required|string|min:8'
        ]);

        //Add Hooks
        $validator->after(function ($validator) use ($request) {
            if ($request->password == "00000000") {
                $validator->errors()->add(
                    'password', 'Something is wrong with this field!'
                );
            }
        });

        if ($validator->fails()) {
            return $this->respondWithErrors('Validation Error.', $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // $success['token'] =  $user->createToken('testing')->plainTextToken; // Sanctum
            $success['token'] =  $user->createToken('testing')->accessToken; // Passport
            $success['name'] =  $user->name;

            return $this->respondWithSuccess($success, 'User logged successfully.');
        } else {
            return $this->setStatusCode(422)->respondWithErrors('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Fresh token
     *
     * @return void
     */
    public function customToken(object $request): JsonResponse
    {
        $response = Http::post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);
        return $response->json();
    }

    /**
     * Logged user
     *
     * @return void
     */
    public function me(): JsonResponse
    {
        $user = auth()->user(); 

        return $this->respondWithSuccess($user, 'Authenticated Information.');
    }

    /**
     * Refresh token
     *
     * @return void
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'scope' => '',
        ]);

        return $this->respondWithSuccess($response->json(), 'Refreshed token.');
    }

    /**
     * Logout
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return $this->setStatusCode(204)->respondWithSuccess([], 'Logged out successfully.');
    }
}
