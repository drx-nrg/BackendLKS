<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "no_ktp" => "required",
            "username" => "required",
            "email" => "required|email",
            "password" => "required",
            "date_birth" => "required|date",
            "phone" => "required",
            "description" => "required",
        ]);

        if($validation->fails())
        {
            return response()->json([
                "message" => "Invalid Field",
                "errors" => $validation->errors()
            ], 422);
        }

        $input = $request->all();
        $input["password"] = Hash::make($request->password);
        $user = User::create($input);

        if($user){
            return response()->json([
                "message" => "Create Register Success",
                "data" => $user
            ], 200);
        }
    }

    public function registerWithToken(Request $request, $token)
    {
        $validation = Validator::make($request->all(), [
            "no_ktp" => "required",
            "username" => "required",
            "email" => "required|email",
            "password" => "required",
            "date_birth" => "required|date",
            "phone" => "required",
            "description" => "required",
        ]);

        if($validation->fails())
        {
            return response()->json([
                "message" => "Invalid Field",
                "errors" => $validation->errors()
            ], 422);
        }

        $input = $request->all();
        $input["password"] = Hash::make($request->password);
        $user = User::create($input);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "message" => "Create Register Success",
            "token" => $token,
            "data" => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required"
        ]);

        if($validation->fails())
        {
            return response()->json([
                "message" => "Invalid Field",
                "errors" => $validation->errors()
            ], 422);
        }

        $user = User::where('username', $request->username)->firstOrFail();
     
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Invalid Login"
            ], 401);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "message" => "Login Success",
            "token" => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        // $currentUser = Auth::user();
        // $currentUser->currentAccessToken()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Log Out Success'
        ]);
    }
}
