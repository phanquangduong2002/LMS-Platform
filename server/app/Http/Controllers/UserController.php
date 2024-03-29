<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function getAllUser()
    {
        $users = User::all();
        return response()->json([
            "success" => true,
            "message" => "All Users Fetched Successfully",
            "users" => $users
        ], 200);
    }


    public function getUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['success' => false, 'error' => 'User not found'], 404);
            }

            return response()->json([
                'success' => true,
                'message' => "Get User Successfully",
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $id = Auth::user()->id;

            $validated = $request->validate([
                "username" => "required|unique:users,username," . $id,
                "name" => "required|max:255",
                "email" => "required|email",
                "user_image" => "nullable|filled",
            ]);

            $user = User::find($id);

            if (!$user) {
                return response()->json(['success' => false, 'error' => 'User not found'], 404);
            }

            $user->username = $request['username'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->user_image = $request->filled('user_image') ? $request->user_image : $user->user_image;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Profile Updated Successfully',
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) return response()->json(['success' => false, 'error' => 'User not found'], 404);

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function blockUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) return response()->json(['success' => false, 'error' => 'User not found'], 404);

            $user->is_blocked = true;

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User Blocked Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function unblockUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) return response()->json(['success' => false, 'error' => 'User not found'], 404);

            $user->is_blocked = false;

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User Unblocked Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                "password" => "required|confirmed",
            ]);

            $datetime = Carbon::now()->format('Y-m-d H:i:s');

            $id = Auth::user()->id;

            $user = User::find($id);

            $user->password  = Hash::make($request['password']);
            $user->change_password_at = $datetime;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password updated Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
