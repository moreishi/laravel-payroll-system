<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PassportController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if($validate->fails()) return response()->json([
            'status' => 'Ok',
            'result' => ['error' => $validate->errors()]
        ], 400);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken(env('APP_KEY'))->accessToken;

        return response()->json([
            'status' => 'Ok',
            'result' => ['token' => $token]
        ], 200);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken(env('APP_KEY'))->accessToken;
            return response()->json([
                'status' => 'Ok',
                'result' => ['token' => $token]], 200);
        } else {
            return response()->json([
                'status' => 'Ok',
                'result' => ['error' => 'UnAuthorised']], 401);
        }
    }
}
