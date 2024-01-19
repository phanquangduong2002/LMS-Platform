<?php

namespace App\Http\Controllers;

use App\Models\CourseLesson;
use Exception;
use Illuminate\Http\Request;

class CourseLessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function createLesson(Request $request, $id)
    {
        try {

            $request->validate([
                'course_id' => 'required|numeric',
                'title' => 'required|string',
                'content' => 'required|string',
                // 'video' => 'required|mimes:mp4,mov,ogg,qt|max:102400',
                'video_duration' => 'required|numeric',
                'free_preview' => 'nullable'
            ]);

            $lesson = new CourseLesson();

            // $video_url = cloudinary()->uploadVideo($request->file('video')->getRealPath(), [
            //     'folder' => 'lms-cdn-videos',
            // ])->getSecurePath();

            $lesson->course_id = $request['course_id'];
            $lesson->title = $request['title'];
            $lesson->content = $request['content'];
            $lesson->video = 'video.mp4';
            $lesson->video_duration = $request['video_duration'];
            $lesson->free_preview = $request['free_preview'];

            $lesson->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
