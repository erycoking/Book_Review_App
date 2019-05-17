<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\Rating;
use App\Http\Resources\RatingResource;

class RatingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, $id)
    {
        //Validate
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'review' => 'required|min:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'rating is required'], 400);
        }

        $user = Auth::user();
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['error' => 'book is required'], 400);
        }

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
