<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        if(empty(auth()->user()->api_token)){
            auth()->user()->generateToken();    
        }

        $accessToken = auth()->user()->api_token;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function reset_token(Request $request)
    {
        $accessToken = auth()->user()->generateToken();

        return response(['access_token' => $accessToken]);
    }
}