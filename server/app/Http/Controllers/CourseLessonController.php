<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLesson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CourseLessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getALesson', 'getAllLessons']]);
    }

    public function createLesson(Request $request, $courseId)
    {
        try {

            $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                // 'video' => 'required|mimes:mp4,mov,ogg,qt|max:102400',
                'free_preview' => 'nullable'
            ]);

            $course = Course::find($courseId);

            if (!$course)
                return response()->json([
                    'success' => false,
                    'message' => 'No Course Exists with this ID'
                ], 404);

            if (Auth::user()->role !== 'admin' && Auth::user()->id !== $course->instructor)
                return response()->json([
                    'success' => false,
                    'message' => 'You are not the admin or instructor of this course'
                ], 401);

            $lesson = new CourseLesson();

            // $video_url = cloudinary()->uploadVideo($request->file('video')->getRealPath(), [
            //     'folder' => 'lms-cdn-videos',
            // ])->getSecurePath();
            $lesson->video = 'video.mp4';
            if ($request->has('video_duration')) $lesson->video_duration = $request['video_duration'];

            $lesson->course_id = $courseId;
            $lesson->title = $request['title'];
            $lesson->content = $request['content'];

            $lesson->free_preview = $request['free_preview'];

            $lesson->save();

            return response()->json([
                'success' => true,
                'message' => 'Lesson Added to the Course',
                'course' => $lesson
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getAllLessons($courseId)
    {
        try {
            $lessons = CourseLesson::where('course_id', $courseId)->get();

            return response()->json([
                'success' => true,
                'message' => 'All Lesson Fetched with Course ID ' . $courseId . ' Successfully',
                'lessons' => $lessons
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getALesson($courseId, $lessonId)
    {
        try {
            $lesson = CourseLesson::find($lessonId);

            if (!$lesson) return response()->json([
                'success' => false,
                'message' => 'Lesson not found'
            ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Lesson found',
                'lesson' => $lesson
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateALesson(Request $request, $courseId, $lessonId)
    {
        try {

            $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                // 'video' => 'required|mimes:mp4,mov,ogg,qt|max:102400',
                'free_preview' => 'nullable'
            ]);

            $course = Course::find($courseId);

            if (!$course)
                return response()->json([
                    'success' => false,
                    'message' => 'No Course Exists with this ID'
                ], 404);

            if (Auth::user()->role !== 'admin' && Auth::user()->id !== $course->instructor)
                return response()->json([
                    'success' => false,
                    'message' => 'You are not the admin or instructor of this course'
                ], 401);

            $lesson = CourseLesson::find($lessonId);

            if (!$lesson) return response()->json([
                'success' => false,
                'message' => 'Lesson Not Found'
            ], 404);

            // $video_url = cloudinary()->uploadVideo($request->file('video')->getRealPath(), [
            //     'folder' => 'lms-cdn-videos',
            // ])->getSecurePath();
            $lesson->video = 'video.mp4';
            if ($request->has('video_duration')) $lesson->video_duration = $request['video_duration'];

            $lesson->course_id = $courseId;
            $lesson->title = $request['title'];
            $lesson->content = $request['content'];

            $lesson->free_preview = $request['free_preview'];

            $lesson->save();

            return response()->json([
                'success' => true,
                'message' => 'Lesson updated Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteALesson($courseId, $lessonId)
    {
        try {

            $course = Course::find($courseId);

            if (!$course)
                return response()->json([
                    'success' => false,
                    'message' => 'No Course Exists with this ID'
                ], 404);

            if (Auth::user()->role !== 'admin' && Auth::user()->id !== $course->instructor)
                return response()->json([
                    'success' => false,
                    'message' => 'You are not the admin or instructor of this course'
                ], 401);

            $lesson = CourseLesson::find($lessonId);

            if (!$lesson) return response()->json([
                'success' => false,
                'message' => 'Lesson Not Found'
            ], 404);

            $lesson->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lesson Deleted Successfully',
                'user' => Auth::user()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
