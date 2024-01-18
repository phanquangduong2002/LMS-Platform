<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllBlogCategories']]);
    }

    public function postBlogCategory(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|unique:tutorial_categories'
            ]);

            $blogCategory = BlogCategory::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Blog Category created successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllBlogCategories()
    {
        try {
            $blogCategories = BlogCategory::all();

            return response()->json([
                'success' => true,
                'message' => 'Blog Categories Fetched Successfully',
                'tutCategories' => $blogCategories
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getABlogCat($id)
    {
        try {
            $blogCategory = BlogCategory::find($id);

            if (!$blogCategory) return response()->json([
                'success' => false,
                'message' => 'Blog Category Not Found'
            ], 404);

            return response()->json([
                'success' => true,
                'message' => 'Tutorial Category Found',
                'tutCategory' => $blogCategory
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function editABlogCat(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|unique:tutorial_categories,title,' . $id,
            ]);
            $blogCategory = BlogCategory::find($id);

            if (!$blogCategory) return response()->json([
                'success' => false,
                'message' => 'Blog Category Not Found'
            ], 404);

            $blogCategory->title = $request['title'];
            $blogCategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Blog Category Edited Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteABlogCat($id)
    {
        try {
            $blogCategory = BlogCategory::find($id);

            if (!$blogCategory) return response()->json([
                'success' => false,
                'message' => 'Tutorial Category Not Found'
            ], 404);

            $logsToDelete = Blog::where('blog_category_id', $id)->get();
            foreach ($logsToDelete as $blog) {
                $blog->keywords()->delete();
                $blog->delete();
            }

            $blogCategory->delete();

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
