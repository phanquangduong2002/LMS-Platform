<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogKeyword;
use Exception;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getABlog']]);
    }
    public function postBlog(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'blog_category_id' => 'required',
                'content' => 'required',
                'keywords' => 'array|required|array|min:1',
                'keywords.*' => 'required|string',
            ]);

            $blog = Blog::create($request->all());

            foreach ($request->input('keywords') as $keyword) {
                BlogKeyword::create([
                    'keyword' => $keyword,
                    'blog_id' => $blog->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Blog created successfully',
                'blog' => $blog
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllBlog()
    {
        try {
            $blogs = Blog::paginate();

            return response()->json([
                'success' => true,
                'message' => 'All Blogs Fetched Successfully',
                'blogs' => $blogs
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getABlog($blogCatId, $slug)
    {
        try {
            $blog = Blog::where('blogs.slug', $slug)
                ->where('blogs.blog_category_id', $blogCatId)
                ->join('blog_categories', 'blogs.blog_category_id', '=', 'blog_categories.id')
                ->select('blogs.*', 'blog_categories.title as blog_category_title', 'blog_categories.slug as blog_category_slug')
                ->first();

            if (!$blog)
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found'
                ], 404);

            $blogTopics = Blog::where('blogs.blog_category_id', $blogCatId)
                ->join('blog_categories', 'blogs.tutorial_category_id', '=', 'blog_categories.id')
                ->select('blogs.id', 'blogs.title', 'blogs.slug', 'blogs.blog_category_id', 'blog_categories.title as blog_category_title', 'blog_categories.slug as blog_category_slug')
                ->orderBy('blogs.created_at')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Blog found successfully',
                'blog' => $blog,
                'blogTopics' => $blogTopics
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function updateBlog(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|',
                'blog_category_id' => 'required',
                'content' => 'required',
            ]);

            $blog = Blog::find($id);

            if (!$blog)
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found'
                ], 404);

            $blog->title = $request['title'];
            $blog->blog_category_id = $request['blog_category_id'];
            $blog->content = $request['content'];

            $blog->save();

            return response()->json([
                'success' => true,
                'message' => 'Blog updated Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteBlog(Request $request, $id)
    {
        try {

            $blog = Blog::find($id);

            if (!$blog)
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found'
                ], 404);

            $blog->keywords()->delete();
            $blog->delete();

            return response()->json([
                'success' => true,
                'message' => 'Blog deleted Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
