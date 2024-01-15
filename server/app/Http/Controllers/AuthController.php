<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\PasswordResetToken;
use Carbon\Carbon;
use App\Mail\VerifyMail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register', 'refresh', 'verificationMail', 'forgetPassword', 'resetPasswordLoad', 'resetPassword']]);
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
        try {
            Auth::logout();
            return response()->json(['status' => true, 'message' => 'User successfully signed out']);
        } catch (Exception $e) {

            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
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

    public function sendVerifyMail($email)
    {
        if (auth()->user()) {
            $user = User::where('email', $email)->get();
            if (count($user) == 0) return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);

            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain . '/verify-mail' . '/' . $token;

            $data['url'] = $url;
            $data['email'] = $email;
            $data['title'] = 'Email Verification';
            $data['body'] = 'Please click here to below to verify your mail.';

            Mail::to($email)->send(new VerifyMail($data));

            $user = User::find($user[0]->id);
            $user->remember_token = $token;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Mail sent successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User is not Authenticated'
            ], 403);
        }
    }

    public function verificationMail($token)
    {
        try {
            $user = User::where('remember_token', $token)->get();

            if (!(count($user) > 0)) return view('404');

            $datetime = Carbon::now()->format('Y-m-d H:i:s');

            $user = User::find($user[0]->id);

            $user->remember_token = '';
            $user->is_verified = 1;
            $user->email_verified_at = $datetime;
            $user->save();

            return "<h1>Email verified successfully</h1>";
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $user =  User::where('email', $request->email)->get();

            if (count($user) > 0) {

                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/reset-password?token=' . $token;

                $data['url'] = $url;
                $data['email'] = $request['email'];
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on below link to reset your password.";

                Mail::to($request->email)->send(new ForgetPasswordMail($data));

                $datetime = Carbon::now()->format('Y-m-d H:i:s');

                PasswordResetToken::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Please check your mail to reset your password'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function resetPasswordLoad(Request $request)
    {
        $token = $request->token;

        $resetData = PasswordResetToken::where('token', $token)->get();

        if (isset($token) && count($resetData) > 0) {
            $user = User::where('email', $resetData[0]['email'])->get();
            return view('resetPassword', compact('user'));
        } else {
            return view('404');
        }
    }

    public function resetPassword()
    {
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
