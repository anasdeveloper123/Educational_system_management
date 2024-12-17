<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'username' => ['required','string'], 
            'mobile' => ['required' , 'unique:users,mobile'],
            'password' => ['required']
        ],[
            'mobile.unique' => 'Mobile is not unique'
        ]);
        $user = User::query()->create([
            'username' => $request['username'],
            'mobile' => $request['mobile'],
            'password' => $request['password']
        ]);
        $token = $user->createToken("API TOKEN")->plainTextToken;
        $data = [];
        $data['user'] = $user;
        $data['token'] = $token;

        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => 'User Register Successfully'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'digits:10', 'exists:users,mobile'],
            'password' => ['required']
        ]);
        if(!Auth::attempt($request->only(['mobile','password'])))
        {
            $message = 'mobile & password does not match with our record.';
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => $message
            ],500);
        }
        $user = User::query()->where('mobile','=',$request['mobile'])->first();
        $token = $user->createToken("API TOKEN")->plainTextToken;
        $data = [];
        $data['user'] = $user;
        $data['token'] = $token;

        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => 'User Logged in Successfully'
        ]); 
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 1,
            'data' => [],
            'message' => 'User logged out Successfully'
        ]);
    }
}
