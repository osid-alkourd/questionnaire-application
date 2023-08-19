<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class TenantController extends Controller
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

        $tenant = Tenant::where('email', $data['email'])->first();
        if (!$tenant || !Hash::check($data['password'], $tenant->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
            $token = $tenant->createToken('device_name')->accessToken;
            return response()->json(['token' => $token, 'tenant' => $tenant], 201);
       
    }


    public function store_tenant(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:tenants',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        }

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $tenant->createToken('device_name')->accessToken;
        return Response::json([
            'token' => $token,
            'tenant' => $tenant,
        ], 201);
    }

    // public function logout(Request $request)
    // {
    //     Auth::guard('tenant')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect()->route('tenant.login')
    //         ->withSuccess('You have logged out successfully!');;
    // }

    public function test()
    {
        $tenant = Auth::guard('tenant')->user()->name;
        return $tenant;
    }


}
