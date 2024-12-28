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
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
                ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => false,
                 'code' => 402,
                 'message' => $validator->errors()->first(),
                 'data' => null,
                    ], 402);
        }

        $admin = Admin::where('username', $request->username)
                      ->first();

        if ($admin) {
            $credentials = [
                'password' => $request->password,
            ];

            if ($admin->username == $request->username) {
                $credentials['username'] = $request->login;
            }

            try {
                if (!$token = auth('admin')->attempt($credentials)) {
                    return response()->json([
                        'status' => false,
                        'code' => 401,
                        'message' => __('The username or password is incorrect'),
                        'data' => null,
                    ], 401);
                }
                $data = $admin->toArray();
                $data['token'] = $token;
                $data['type'] = 'admin';
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => __('Admin login successful'),
                    'data' => $data,
                ], 200);

            } catch (JWTException $e) {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'message' => __('Server error, please try again later'),
                    'data' => null,
                ], 500);
            }
        }

        return response()->json([
            'status' => false,
            'message' => __('The username does not exist'),
        ], 404);
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
