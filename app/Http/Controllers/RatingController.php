<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\Rating;
use App\Http\Resources\RatingResource;

/**
 * controller adding user reviews
 */
class RatingController extends Controller
{

    /**
     * defining middlewares
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * stores new user review
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     *
     * @return App\Http\Resources\RatingResource
     */
    public function store(Request $request, $id)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'review' => 'required|min:10'
        ]);

        // test validation
        if ($validator->fails()) {
            return response()->json(['error' => 'rating and rating are both required'], 400);
        }

        // get current user
        $user = Auth::user();
        // get book being reviewed
        $book = Book::find($id);

        // checking if book exists
        if ($book == null) {
            return response()->json(['error' => 'book is required'], 400);
        }

        // if review on current user exists update it else create a new one
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review
            ]
        );

        // return new rating resource
        return (new RatingResource($rating))->response()->setStatusCode(200);
    }
}
