<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Exception;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllCourseCategories']]);
    }

    public function postCourseCategory(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|unique:tutorial_categories'
            ]);

            $courseCategory = CourseCategory::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Course Category created successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllCourseCategories()
    {
        try {
            $courseCategories = CourseCategory::all();

            return response()->json([
                'success' => true,
                'message' => 'Course Categories Fetched Successfully',
                'courseCategories' => $courseCategories
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getACourseCat($id)
    {
        try {
            $courseCategory = CourseCategory::find($id);

            if (!$courseCategory) return response()->json([
                'success' => false,
                'message' => 'Course Category Not Found'
            ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Tutorial Category Found',
                'courseCategory' => $courseCategory
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function editACourseCat(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|unique:course_categories,title,' . $id,
            ]);
            $courseCategory = CourseCategory::find($id);

            if (!$courseCategory) return response()->json([
                'success' => false,
                'message' => 'Course Category Not Found'
            ], 404);

            $courseCategory->title = $request['title'];
            $courseCategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Course Category Edited Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteACourseCat($id)
    {
        try {
            $courseCategory = CourseCategory::find($id);

            if (!$courseCategory) return response()->json([
                'success' => false,
                'message' => 'Course Category Not Found'
            ], 404);

            $coursesToDelete = Course::where('course_category_id', $id)->get();
            foreach ($coursesToDelete as $course) {
                $course->delete();
            }

            $courseCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course Category Deleted Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
