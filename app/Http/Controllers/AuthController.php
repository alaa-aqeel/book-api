<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Login user 
     * 
     * @param Illuminate\Http\Request $request 
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // validation rules 
        $validatedData = $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        // check email and password 
        if (Auth::attempt($validatedData)){

            // create access token for user 
            $access_tokne = Auth::user()
                            ->createToken("User Access Token")
                            ->accessToken;

            return response()->json([

                "token" => $access_tokne
            ]);
        }
        
        return response()->json([
            "message" => __("messages.errors.login")
        ], 401);
    }

    /**
     * Register new user 
     * 
     * @param App\Http\Requests\UserRequest $request 
     * @return Illuminate\Http\Response
     */
    public function register(UserRequest $request)
    {
        // validation rules 
        $validatedData = $request->validated();

        // encode password 
        $validatedData['password'] = Hash::make($validatedData["password"]);

        // create new user 
        $user = User::create($validatedData);

        return response()->json([
            "message" => __("messages.success.register")
        ], 201);
    }
}