<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoKeyword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function postVideo(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                // 'video' => 'required|mimes:mp4,mov,ogg,qt|max:102400',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required',
                'keywords' => 'array|required|array|min:1',
                'keywords.*' => 'required|string',
            ]);


            $thumbnail = cloudinary()->upload($request->file('thumbnail')->getRealPath(), [
                'folder' => 'lms-cdn-images',
            ])->getSecurePath();

            // $video_url = cloudinary()->uploadVideo($request->file('video')->getRealPath(), [
            //     'folder' => 'lms-cdn-videos',
            // ])->getSecurePath();

            $video = new Video();

            // $video->video_url = $video_url;

            $video->video_url = 'video.mp4';
            $video->title = $request['title'];
            $video->thumbnail = $thumbnail;
            $video->description = $request['description'];

            $video->save();

            foreach ($request->input('keywords') as $keyword) {
                VideoKeyword::create([
                    'keyword' => $keyword,
                    'video_id' => $video->id,
                ]);
            };

            return response()->json([
                'success' => true,
                'message' => 'Video Posted Successfully',
                'video' => $video,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllVideo()
    {
        try {
            $videos = Video::paginate();

            return response()->json([
                'success' => true,
                'message' => 'Videos Fetched Successfully',
                'videos' => $videos
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVideo($slug)
    {
        try {
            $video = Video::where('slug', $slug)->first();

            if (!$video)
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Video found',
                'video' => $video
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateVideo(Request $request, $id)
    {
        try {

            $request->validate([
                'title' => 'required',
                // 'video' => 'required|mimes:mp4,mov,ogg,qt|max:102400',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required',
            ]);

            $video = Video::find($id);

            if (!$video)
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);

            $video->title = $request['title'];
            $video->description = $request['description'];


            if ($request->hasFile('video')) {
                // $video_url = cloudinary()->uploadVideo($request->file('video')->getRealPath(), [
                //     'folder' => 'lms-cdn-videos',
                // ])->getSecurePath();

                // $video->video_url = $video_url;

                $video->video_url = 'video.mp4';
            }


            if ($request->hasFile('thumbnail')) {

                // Lấy public_id từ URL hiện tại trong cơ sở dữ liệu

                $thumbnail_url = $video->thumbnail;
                $filename = pathinfo($thumbnail_url)['filename'];
                $public_id = 'lms-cdn-images/' . $filename;

                cloudinary()->destroy($public_id);

                $thumbnail = cloudinary()->upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'lms-cdn-images',
                ])->getSecurePath();

                $video->thumbnail = $thumbnail;
            }

            $video->save();

            return response()->json([
                'success' => true,
                'message' => 'Video Updated Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteVideo($id)
    {
        try {
            $video = Video::find($id);

            if (!$video)
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);

            $video->keywords()->delete();

            $thumbnail_url = $video->thumbnail;
            $filename = pathinfo($thumbnail_url)['filename'];
            $public_id = 'lms-cdn-images/' . $filename;
            cloudinary()->destroy($public_id);

            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Video Deleted Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
