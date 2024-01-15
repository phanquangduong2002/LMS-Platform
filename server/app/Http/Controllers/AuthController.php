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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\PasswordReset;
use Carbon\Carbon;
use App\Mail\SendMail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'forgetPassword']]);
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
            $url = $domain . '/' . $token;

            $data['url'] = $url;
            $data['email'] = $email;
            $data['title'] = 'Email Verification';
            $data['body'] = 'Please click here to below to verify your mail.';

            Mail::send('verifyMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

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

    public function forgetPassword(Request $request)
    {
        // try {
        //     $user =  User::where('email', $request->email)->get();

        //     if (count($user) > 0) {

        //         $token = Str::random(40);
        //         $domain = URL::to('/');
        //         $url = $domain . '/reset-password?token=' . $token;

        //         $data['url'] = $url;
        //         $data['email'] = $request['email'];
        //         $data['title'] = "Password Reset";
        //         $data['body'] = "Please click on below link to reset your password.";

        //         Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
        //             $message->to($data['email'])->subject($data['title']);
        //         });

        //         $datetime = Carbon::now()->format('Y-m-d H:i:s');

        //         PasswordReset::updateOrCreate(
        //             ['email' => $request->email],
        //             [
        //                 'email' => $request->email,
        //                 'token' => $token,
        //                 'created_at' => $datetime
        //             ]
        //         );

        //         return response()->json([
        //             'status' => true,
        //             'message' => 'Please check your mail to reset your password'
        //         ], 200);
        //     } else {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'User not found'
        //         ], 404);
        //     }
        // } catch (Exception $e) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $e->getMessage()
        //     ], 500);
        // }

        try {
            $mailData = [
                'title' => 'Mail from LMS Platform',
                'body' => 'Please click on below link to reset your password.'
            ];

            Mail::to('phanquangduong2002@gmail.com')->send(new SendMail($mailData));

            return response()->json([
                'status' => true,
                'message' => 'Please check your mail to reset your password'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
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
