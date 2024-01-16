<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoKeyword;
use Exception;
use Illuminate\Http\Request;

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
                'thumbnail' => 'required',
                'description' => 'required',
                'video_url' => 'required',
                'keywords' => 'array|required|array|min:1',
                'keywords.*' => 'required|string',
            ]);

            $video = Video::create($request->all());

            foreach ($request->input('keywords') as $keyword) {
                VideoKeyword::create([
                    'keyword' => $keyword,
                    'video_id' => $video->id,
                ]);
            };

            return response()->json([
                'success' => true,
                'message' => 'Video Posted Successfully'
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
                'thumbnail' => 'required',
                'description' => 'required',
                'video_url' => 'required',
            ]);


            $video = Video::find($id);

            if (!$video)
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);

            $video->title = $request['title'];
            $video->thumbnail = $request['thumbnail'];
            $video->description = $request['description'];
            $video->video_url = $request['video_url'];

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
