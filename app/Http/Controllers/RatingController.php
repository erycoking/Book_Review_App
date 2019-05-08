<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, Book $book)
    {
        //Validate
        $validator = Validator::make($request->all(), [
            'rating' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'rating is required'], 400);
        }

        $user = Auth::user();

        $rating = Rating::firstOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            ['rating' => $request->rating]
        );

        return (new RatingResource($rating))->response()->setStatusCode(200);
    }
}
