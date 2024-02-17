<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\UserCourse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Backtrace\Arguments\ReducedArgument\TruncatedReducedArgument;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllCourses', 'getAllCoursesByCategory', 'getACourse', 'getParticularInstructorCourses']]);
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
                ->join('users', 'courses.instructor', '=', 'users.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug', 'users.name as instructor_name', 'users.user_image as instructor_image')
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

    public function getAllCoursesByCategory($courseCatId)
    {
        try {
            $courses = Course::where('courses.course_category_id', $courseCatId)
                ->join('course_categories', 'courses.course_category_id', '=', 'course_categories.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug')
                ->paginate();

            return response()->json([
                'success' => true,
                'message' => 'All Course Fetch for particaular Category Successfully',
                'courses' => $courses
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getACourse($slug)
    {
        try {
            $course = Course::where('courses.slug', $slug)
                ->join('course_categories', 'courses.course_category_id', '=', 'course_categories.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug')
                ->first();

            if (!$course)
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found'
                ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Course found successfully',
                'course' => $course,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getParticularInstructorCourses($constructorId)
    {
        try {
            $courses = Course::where('courses.instructor', $constructorId)
                ->join('course_categories', 'courses.course_category_id', '=', 'course_categories.id')
                ->select('courses.*', 'course_categories.title as course_category_title', 'course_categories.slug as course_category_slug')
                ->paginate();

            if (count($courses) == 0)
                return response()->json([
                    'success' => false,
                    'message' => 'Courses by instructor id ' . $constructorId . ' not found'
                ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Course found successfully',
                'course' => $courses,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateCourse(Request $request, $id)
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

            $course = Course::find($id);

            if (!$course) return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);

            if ($request->hasFile('image')) {
                $image_url = $course->image;
                $filename = pathinfo($image_url)['filename'];
                $public_id = 'lms-cdn-images/' . $filename;

                cloudinary()->destroy($public_id);

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

            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Course updated Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteCourse($id)
    {
        try {
            $course = Course::find($id);

            if (!$course) return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);

            $lessons = CourseLesson::where('course_id', $id)->get();
            foreach ($lessons as $lesson) {
                $lesson->delete();
            }

            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course deleted Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function publishedCourse($id)
    {
        try {
            $course = Course::find($id);

            if (!$course) return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);

            $course->published = true;

            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Course published Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function unpublishedCourse($id)
    {
        try {
            $course = Course::find($id);

            if (!$course) return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);

            $course->published = false;

            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Course unpublished Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function freeEnrollment(Request $request, $courseId)
    {
        try {
            $course = Course::find($courseId);

            if (!$course) return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);

            if ($course->paid) return response()->json([
                'success' => false,
                'message' => 'This course is a paid course'
            ]);

            $findUserCourse = UserCourse::where('user_id', Auth::user()->id)
                ->where('course_id', $courseId)->first();

            if ($findUserCourse)
                return response()->json([
                    'success' => false,
                    'message' => 'You have previously added this course'
                ]);

            $userCourse = new UserCourse();

            $userCourse->user_id = Auth::user()->id;

            $userCourse->course_id = $courseId;

            $userCourse->save();

            return response()->json([
                'success' => true,
                'message' => 'Course Added'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
