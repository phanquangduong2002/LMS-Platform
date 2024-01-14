<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = Auth::attempt($validator->validated())) {
            return response()->json(['status' => false, 'error' => 'Wrong account or password'], 401);
        }


        $refreshToken = $this->createRefreshToken();

        return $this->createNewToken($token, $refreshToken);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->toJson()], 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => Hash::make($request->password)]
        ));

        // $token =  Auth::login($user);

        // return $this->createNewToken($token);

        return response()->json([
            "status" => true,
            "message" => "New account created successfully",
            "user" => $user
        ], 201);
    }


    public function profile()
    {
        try {
            return response()->json(Auth::user());
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'error' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => true, 'message' => 'User successfully signed out']);
    }

    public function refresh()
    {
        $refreshToken = request()->refresh_token;
        try {
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);

            $user = User::find($decoded['sub']);

            if (!$user) return response()->json(['status' => false, 'error' => 'User not found', 404]);

            Auth::invalidate(); // Vô hiệu hóa token hiện tại

            $token = Auth::login($user); // Tạo token mới
            $refreshToken = $this->createRefreshToken();

            return $this->createNewToken($token, $refreshToken);
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'error' => 'Refresh token Invalid'], 500);
        }
    }

    private function createNewToken($token, $refreshToken)
    {
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }


    private function createRefreshToken()
    {
        $data = [
            'sub' => Auth::user()->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($data);

        return $refreshToken;
    }
}
