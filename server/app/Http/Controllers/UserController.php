<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            "username" => "required|unique:users,username",
            "name" => "required|max:255",
            "email" => "required|email",
            "password" => "required|confirmed"
        ], [
            "username.required" => "Vui lòng nhập tên tài khoản!",
            "username.unique" => "Tên tài khoản đã tồn tại!",

            "name.required" => "Vui lòng nhập họ tên!",
            "name.max" => "Tên quá dài!",

            "email.required" => "Vui lòng nhập email!",
            "email.email" => "Email không hợp lệ!",

            "password.required" => "Vui lòng nhập mật khẩu!",
            "password.confirmed" => "Mật khẩu không khớp!"
        ]);


        $user = $request->except(["password", "password_confirmation"]);
        $user["password"] = Hash::make($request["password"]);
        User::create($user);


        return response()->json(['message' => 'User created successfully'], 200);
    }
}
