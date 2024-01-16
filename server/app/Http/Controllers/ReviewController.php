<?php

namespace App\Http\Controllers;

use App\Models\Review as ModelsReview;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllReview']]);
    }

    public function createReview(Request $request)
    {
        try {
            $request->validate(['comment' => 'required']);

            $review = new ModelsReview();

            $review->user_id = Auth::user()->id;
            $review->comment = $request['comment'];

            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Review Added Successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllReview()
    {
        try {

            $reviews = ModelsReview::with(['user' => function ($query) {
                $query->select('id', 'user_image', 'name', 'email');
            }])->paginate();

            return response()->json([
                'success' => true,
                'message' => 'Reviews Fetched Successfully!',
                'reviews' => $reviews
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAReview($id)
    {
        try {

            $review = ModelsReview::with(['user' => function ($query) {
                $query->select('id', 'user_image', 'name', 'email');
            }])->find($id);

            if (!$review) return response()->json([
                'success' => false,
                'message' => 'Review not Found'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review Found',
                'reviews' => $review
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateReviewStatus(Request $request, $id)
    {
        try {

            $request->validate([
                'is_approved' => 'required'
            ]);

            $review = ModelsReview::find($id);

            if (!$review) return response()->json([
                'success' => false,
                'message' => 'Review not Found'
            ]);

            $review->is_approved = $request['is_approved'];

            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Review Status Updated Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAReview($id)
    {
        try {
            $review = ModelsReview::find($id);

            if (!$review) return response()->json([
                'success' => false,
                'message' => 'Review not Found'
            ]);

            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Review Deleted Successfully!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
