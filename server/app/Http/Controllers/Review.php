<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;


class Review extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function createReview(Request $request)
    {
        try {
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
