<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            // TODO: creat validate request
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // TODO: find user by email
            // jika udah kevalid, bungkus ke 1 variabel | jika user sesuai
            // $credentials = request(['email', 'required']);
            // if (!Auth::attempt($credentials)) {
            //     return ResponseFormatter::error('Unauthorized', 401);
            // }

            // di check lagi
            $user = User::where('email', $request->email)->firstOrFail();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid Password');
            }

            // TODO: Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // TODO: Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login Success');
        } catch (Exception $e) { // exception->ekspestasi
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            // TODO: Validate request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
            ]);

            // TODO: Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // TODO: Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // TODO: Return Response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Register Success');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // TODO: Revoke Token | mencabut, bukan hapus
        $token = $request->user()->currentAccessToken()->delete();

        // TODO: Return Response
        return ResponseFormatter::success($token, 'Logout Success');
    }

    public function fetch(Request $request)
    {
        // TODO: Get User
        $user = $request->user();

        // TODO: Return Response
        return Responseformatter::success($user, 'Fetch Success');
    }
}
