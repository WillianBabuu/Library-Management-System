<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Util\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Class AuthController
 *
 * @author Rugemarila Jeremiah
 * @package App\Http\Controllers
 */

class AuthController extends Controller {

    public function register(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'terms_and_condition' => 'required',
        ]);

        /**
         * @var \App\Models\User $user
         */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('main')->plainTextToken;
        $refreshToken = "TODO_REFRESH_TOKEN_GIVEN";

        $returnData = [
            'user' => $user,
            'token' => $token,
            'refresh_token' => $refreshToken,
        ];

        return response(JsonResponse::get(JsonResponse::$OK, "Successfull Registration", $returnData));
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required'
            ],
            'remember' => 'boolean',
        ]);

        $remember = $credentials['remember'] ? true: false;
        unset($credentials['remember']);

        if(!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The provided credentials are not correct'
            ], 422);
        }

        /**
         * @var \App\Models\User $user
         */

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        $refreshToken = "TODO_REFRESH_TOKEN_GIVEN";

        $returnData = [
            'user' => $user,
            'token' => $token,
            'refresh_token' => $refreshToken,
        ];

        return response(JsonResponse::get(JsonResponse::$OK, "Successful Login", $returnData));
    }

    public function logout(Request $request) {

        // Revoke a specific token...
        $requestBearerToken = (!empty($request->user())) ? $request->user()->tokens()->where('id', $request->bearerToken()) : null;
        if(!empty($requestBearerToken)) $requestBearerToken->delete();

        //Alternative of using personal access token model
        /*PersonalAccessToken::findToken($request->bearerToken())->delete();*/

        return response(JsonResponse::get(JsonResponse::$OK, "Successful Logout", null));
    }
}
