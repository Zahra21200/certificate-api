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
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                'code' => 402,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 402);
        }

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => __('The username does not exist'),
            ], 404);
        }

        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'message' => __('The username or password is incorrect'),
                'data' => null,
            ], 401);
        }

        try {
            $token = auth('admin')->login($admin); // Use 'api' guard
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => __('Could not create token.'),
            ], 500);
        }

        $data = $admin->toArray();
        $data['token'] = $token;
        $data['token_type'] = 'Bearer'; // Include token type

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
