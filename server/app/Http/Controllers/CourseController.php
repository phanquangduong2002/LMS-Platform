<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function createCourse(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'image' => 'nullable',
                'course_category_id' => 'required|numeric',
                'paid' => 'nullable',
            ]);

            $course = new Course();

            if ($request->hasFile('image')) {
                $image_url = cloudinary()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'lms-cdn-images',
                ])->getSecurePath();

                $course->image = $image_url;
            }

            $course->title = $request['title'];
            $course->description = $request['description'];
            $course->price = $request['price'];
            $course->course_category_id = $request['course_category_id'];

            if ($request->has('paid')) $course->paid = $request['paid'];


            $course->instructor = Auth::user()->id;

            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Course created successfully',
                'course' => $course
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
