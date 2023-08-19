<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function login(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
        $token = $user->createToken('device_namefor_admin')->accessToken;
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function store_user(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('device_name', ['admin']);
        return Response::json([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
    }

    public function logout (Request $request) 
    {
        $token = Auth::guard('user')->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
