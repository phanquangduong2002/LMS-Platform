<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Backtrace\Arguments\ReducedArgument\TruncatedReducedArgument;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllCourses', 'getACourse']]);
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

    public function getAllCourses()
    {
        try {
            $courses = Course::join('course_categories', 'courses.course_category_id', '=', 'course_categories.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug')
                ->paginate();

            return response()->json([
                'success' => true,
                'message' => 'All Course Fetch Successfully',
                'courses' => $courses
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getACourse($courseCatId, $slug)
    {
        try {
            $course = Course::where('courses.slug', $slug)
                ->where('courses.course_category_id', $courseCatId)
                ->join('course_categories', 'courses.course_category_id', '=', 'course_categories.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug')
                ->first();

            if (!$course)
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found'
                ], 404);

            $courseTopics = Course::where('courses.course_category_id', $courseCatId)
                ->join('course_categories', 'courses.course_category_id', '=', 'course_categories.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug')
                ->orderBy('courses.created_at')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Course found successfully',
                'course' => $course,
                'courseTopics' => $courseTopics
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
