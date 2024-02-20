<?php

namespace App\Http\Controllers\Frontent;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|min:8',
            'confirmPassword'   => 'required|same:password',
            'user_type'         => 'required'
        ]);


        if($validator->fails()){
            return response()->json([
                'message'   => 'please input validate info'
            ]);
        }

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'user_type' => $request->user_type,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => 'Registration Successfully'
        ]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'  => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
           return response()->json([
            'message' => 'Please fillup all the field'
           ]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $token = $user->createToken($user->email)->plainTextToken;

            return response()->json([
                'status'   => 200,
                'message'  => 'Login Successfully',
                'token'    => $token,
                'user'     => $user
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   => 'Invalide Credential'
            ]);
        }
    }
}
