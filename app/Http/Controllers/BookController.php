<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Runner\Exception;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['user', 'ratings']);
        return (BookResource::collection($books->orderBy('id', 'desc')->paginate(15)))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validate
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'title and description is required'], 400);
        }

        try {
            $user = Auth::user();
            $book = new Book();
            $book->user_id = $user->id;
            $book->title = $request->input('title');
            $book->description = $request->input('description');
            $user->books()->save($book);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], 400);
        }


        return (new BookResource($book))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        $book->with(['user', 'ratings']);
        return (new BookResource($book))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //Validate
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'title and description is required'], 400);
        }

        $book = Book::find($id);

        if ($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can only edit your own books.'], 403);
        }

        $book->update($request->only(['title', 'description']));

        return (new BookResource($book))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if ($book->delete()) {
            return (new BookResource($book))->response()->setStatusCode(200);
        }
    }
}
