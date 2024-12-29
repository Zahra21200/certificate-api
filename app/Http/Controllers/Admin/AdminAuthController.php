<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    protected $adminRepo;

    public function __construct(AdminRepositoryInterface $adminRepo)
    {
        $this->adminRepo = $adminRepo;
    }


    // Admin Registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:255',
            'username' => 'required|unique:admins|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                'code' => 402,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 402);
        }

        Admin::create([
            "username" => $request->username,
            "password" => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => "Admin account created successfully",
        ], 200);
    }
    
    public function login(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'code' => 422,
            'message' => $validator->errors()->first(),
            'data' => null,
        ], 422);
    }

    // Prepare credentials
    $credentials = [
        'username' => $request->username,
        'password' => $request->password,
    ];

    // Attempt login using the admin guard
    if (!$token = auth('admin')->attempt($credentials)) {
        return response()->json([
            'status' => false,
            'code' => 401,
            'message' => __('The username or password is incorrect'),
            'data' => null,
        ], 401);
    }

    // Retrieve authenticated admin
    $admin = auth('admin')->user();

    // Prepare the response data
    $data = $admin->toArray();
    $data['token'] = $token;
    $data['token_type'] = 'Bearer';

    return response()->json([
        'status' => true,
        'code' => 200,
        'message' => __('Admin login successful'),
        'data' => $data,
    ], 200);
}




    public function logout()
    {
        Auth::guard('admin')->logout();

        return response()->json([
            'status' => true,
            'message' => __('Logout successful'),
        ], 200);
    }

}
