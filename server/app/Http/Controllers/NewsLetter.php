<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter as ModelsNewsLetter;
use Exception;
use Illuminate\Http\Request;

class NewsLetter extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['subscribe', 'unsubscribe']]);
    }

    public function subscribe(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required'
            ]);

            $newEmail = ModelsNewsLetter::updateOrCreate($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Subscribed To NewsLetter!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function unsubscribe(Request $request, $id)
    {
        try {

            $deleteEmail  = ModelsNewsLetter::find($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'UnSubscribed To NewsLetter!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
