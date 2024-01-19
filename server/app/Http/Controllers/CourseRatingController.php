<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
}
