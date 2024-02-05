<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $user = Auth::user();
        
        return response()->json([
            "message" => "Get User data success",
            "user" => $user
        ], 200);
    }
    public function index()
    {
        $users = User::all();

        if(!$users){
            return response()->json([
                "message" => "Get all users failed"
            ], 400);
        }

        return response()->json([
            "message" => "Get all users success",
            "users" => $users
        ], 200);
    }
}
