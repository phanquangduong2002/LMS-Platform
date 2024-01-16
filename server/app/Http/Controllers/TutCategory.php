<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialCategory;
use Exception;
use Illuminate\Http\Request;

class TutCategory extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllTutCategories']]);
    }

    public function postTutorialCategory(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|unique:tutorial_categories'
            ]);

            $tutCategory = TutorialCategory::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Tutorial Category created successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllTutCategories()
    {
        try {
            $tutCategories = TutorialCategory::all();

            return response()->json([
                'success' => true,
                'message' => 'Tutorial Categories Fetched Successfully',
                'tutCategories' => $tutCategories
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getATutCat($id)
    {
        try {
            $tutCategory = TutorialCategory::find($id);

            if (!$tutCategory) return response()->json([
                'success' => false,
                'message' => 'Tutorial Category Not Found'
            ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Tutorial Category Found',
                'tutCategory' => $tutCategory
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function editATutCat(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|unique:tutorial_categories,title,' . $id,
                'image' => 'nullable|filled'
            ]);
            $tutCategory = TutorialCategory::find($id);

            if (!$tutCategory) return response()->json([
                'success' => false,
                'message' => 'Tutorial Category Not Found'
            ], 404);

            $tutCategory->title = $request['title'];
            $tutCategory->image = $request->filled('image') ? $request->image : $tutCategory->image;
            $tutCategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Tutorial Category Edited Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteATutCat($id)
    {
        try {
            $tutCategory = TutorialCategory::find($id);

            if (!$tutCategory) return response()->json([
                'success' => false,
                'message' => 'Tutorial Category Not Found'
            ], 404);

            $tutorialsToDelete = Tutorial::where('tutorial_category_id', $id)->get();
            foreach ($tutorialsToDelete as $tutorial) {
                $tutorial->keywords()->delete();
                $tutorial->delete();
            }

            $tutCategory->delete();


            return response()->json([
                'success' => true,
                'message' => 'Tutorial Category Deleted Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
