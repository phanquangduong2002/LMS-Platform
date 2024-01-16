<?php

namespace App\Http\Controllers;

use App\Models\Tutorial as ModelsTutorial;
use App\Models\TutorialKeyword;
use Exception;
use Illuminate\Http\Request;

class Tutorial extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getATutorial']]);
    }
    public function postTutorial(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|unique:tutorials',
                'tutorial_category_id' => 'required',
                'content' => 'required',
                'keywords' => 'array|required|array|min:1',
                'keywords.*' => 'required|string',
            ]);

            $tutorial = ModelsTutorial::create($request->all());

            foreach ($request->input('keywords') as $keyword) {
                TutorialKeyword::create([
                    'keyword' => $keyword,
                    'tutorial_id' => $tutorial->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tutorial created successfully',
                'tutorial' => $tutorial
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllTutorial()
    {
        try {
            $tutorials = ModelsTutorial::paginate();

            return response()->json([
                'success' => true,
                'message' => 'All Tutorial Fetched Successfully',
                'tutorials' => $tutorials
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getATutorial($tutCatId, $slug)
    {
        try {
            $tutorial = ModelsTutorial::where('tutorials.slug', $slug)
                ->where('tutorials.tutorial_category_id', $tutCatId)
                ->join('tutorial_categories', 'tutorials.tutorial_category_id', '=', 'tutorial_categories.id')
                ->select('tutorials.*', 'tutorial_categories.title as tutorial_category_title', 'tutorial_categories.slug as tutorial_category_slug')
                ->first();

            if (!$tutorial)
                return response()->json([
                    'success' => false,
                    'message' => 'Tutorial not found'
                ], 404);

            $tutorialTopics = ModelsTutorial::where('tutorials.tutorial_category_id', $tutCatId)
                ->join('tutorial_categories', 'tutorials.tutorial_category_id', '=', 'tutorial_categories.id')
                ->select('tutorials.id', 'tutorials.title', 'tutorials.slug', 'tutorials.tutorial_category_id', 'tutorial_categories.title as tutorial_category_title', 'tutorial_categories.slug as tutorial_category_slug')
                ->orderBy('tutorials.created_at')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Tutorial found successfully',
                'tutorial' => $tutorial,
                'tutorialTopics' => $tutorialTopics
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function updateTutorial(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|unique:tutorials,title,' . $id,
                'tutorial_category_id' => 'required',
                'content' => 'required',
            ]);

            $tutorial = ModelsTutorial::find($id);

            if (!$tutorial)
                return response()->json([
                    'success' => false,
                    'message' => 'Tutorial not found'
                ], 404);

            $tutorial->title = $request['title'];
            $tutorial->tutorial_category_id = $request['tutorial_category_id'];
            $tutorial->content = $request['content'];

            $tutorial->save();

            return response()->json([
                'success' => true,
                'message' => 'Tutorial updated Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTutorial(Request $request, $id)
    {
        try {

            $tutorial = ModelsTutorial::find($id);

            if (!$tutorial)
                return response()->json([
                    'success' => false,
                    'message' => 'Tutorial not found'
                ], 404);

            $tutorial->keywords()->delete();
            $tutorial->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tutorial deleted Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
