<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Login
    public function Login(Request $request){
        return response()->json('Login method ');
    }


    // Register
    public function Register(Request $request){
        return response()->json('Register method ');
    }


    // Reset password
    public function Reset(Request $request){
        return response()->json('Reset method ');
    }


    // Me
    public function Me($id){
        return response()->json($id);
    }


    // Logout
    public function Logout(Request $request){
        return response()->json('Logout method ');
    }
}
