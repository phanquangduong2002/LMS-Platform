<?php

namespace App\Http\Controllers;

use App\Models\DocImage;
use App\Models\DocKeyword;
use App\Models\Documentation;
use Exception;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function postDocument(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required',
                'author' => 'nullable',
                'content' => 'required',
                'keywords' => 'array|required|array|min:1',
                'keywords.*' => 'required|string',
            ]);

            $document = new Documentation();

            $document->title = $request['title'];
            $document->content = $request['content'];

            if ($request->hasFile('author')) $document->author = $request['author'];

            $document->save();

            if ($request->hasFile('images')) {

                foreach ($request->images as $image) {
                    $thumbnail = cloudinary()->upload($image->getRealPath(), [
                        'folder' => 'lms-cdn-images',
                    ])->getSecurePath();

                    DocImage::create([
                        'doc_id' => $document->id,
                        'image' => $thumbnail
                    ]);
                }
            }

            foreach ($request->input('keywords') as $keyword) {
                DocKeyword::create([
                    'doc_id' => $document->id,
                    'keyword' => $keyword,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tutorial created successfully',
                'tutorial' => $document
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
