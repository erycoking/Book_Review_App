<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Runner\Exception;
use Illuminate\Support\Facades\Validator;

/**
 * controller for manipulating books table
 */
class BookController extends Controller
{

    /**
     * adding  auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\BookResource
     */
    public function index()
    {
        // load books and related objects eargerly
        $books = Book::with(['user', 'ratings']);
        // return paginated data ordered by id
        return (BookResource::collection($books->orderBy('id', 'desc')->paginate(15)))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\BookResource
     */
    public function store(Request $request)
    {
        // get max allowed file size
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        // define validation rulee
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:8',
            'cover_img'=>'image|nullable|max:' . $max_size,
            'book'=>'file|nullable|max:' . $max_size
        ]);

        // test validation
        if ($validator->fails()) {
            return response()->json(['error' => 'title and description is required'], 400);
        }

        // handle file upload
        if($request->hasFile('cover_img')){
            // get file with extenstion
            $fileNamewithExt = $request->file('cover_img')->getClientOriginalName();
            // get file name only
            $filename = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            // get extension only
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            // filename to store
            $fileNameToStoreImg = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStoreImg);
        }else{
            // no file was uploaded
            $fileNameToStoreImg = 'no_cover_img.jpg';
        }

        // handle file upload
        if($request->hasFile('book')){
            // get file with extenstion
            $fileNamewithExt = $request->file('book')->getClientOriginalName();
            // get file name only
            $filename = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            // get extension only
            $extension = $request->file('book')->getClientOriginalExtension();
            // filename to store
            $fileNameToStoreBook = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $request->file('book')->storeAs('public/books', $fileNameToStoreBook);
        }else{
            // no file was uploaded
            $fileNameToStoreBook = 'no_book.png';
        }

        try {
            // get current user
            $user = Auth::user();
            // create new book
            $book = new Book();
            $book->user_id = $user->id;
            $book->title = $request->input('title');
            $book->description = $request->input('description');
            $book->cover_img = $fileNameToStoreImg;
            $book->book = $fileNameToStoreBook;
            $user->books()->save($book);
        }catch(Exception $ex){
            return response()->json(['error' => $ex->getMessage()], 400);
        }


        // return book resource
        return (new BookResource($book))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\BookResource
     */
    public function show($id)
    {
        // fetch book in the db
        $book = Book::find($id);
        // check if book exists
        if($book == null){
            return response()->json(['error' => 'book not found'], 404);
        }

        // redifine files urls
        $book->cover_img = '/storage/cover_images/'.$book->cover_img;
        $book->book = '/storage/books/'.$book->book;
        // fetch related objects
        $book->with(['user', 'ratings']);
        // return book resource
        return (new BookResource($book))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return App\Http\Resources\BookResource
     */
    public function update(Request $request, $id)
    {

        // fetch book in the db
        $book = Book::find($id);
        // check if book exists
        if($book == null){
            return response()->json(['error' => 'book not found'], 404);
        }

        // check if the book belongs to the current user
        if ($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can only edit your own books.'], 403);
        }

        // get allowed max file size
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        // define validation rule
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:8',
            'cover_img'=>'image|nullable|max:' . $max_size,
            'book'=>'file|nullable|max:' . $max_size
        ]);

        // test validation
        if ($validator->fails()) {
            return response()->json(['error' => 'title and description is required'], 400);
        }

        // handle file upload
        if($request->hasFile('cover_img')){
            // get file with extenstion
            $fileNamewithExt = $request->file('cover_img')->getClientOriginalName();
            // get file name only
            $filename = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            // get extension only
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            // filename to store
            $fileNameToStoreImg = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStoreImg);
        }else{
            // no file was uploaded
            $fileNameToStoreImg = 'no_cover_img.jpg';
        }

        // handle file upload
        if($request->hasFile('book')){
            // get file with extenstion
            $fileNamewithExt = $request->file('book')->getClientOriginalName();
            // get file name only
            $filename = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            // get extension only
            $extension = $request->file('book')->getClientOriginalExtension();
            // filename to store
            $fileNameToStoreBook = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $request->file('book')->storeAs('public/books', $fileNameToStoreBook);
        }else{
            // no file was uploaded
            $fileNameToStoreBook = 'no_book.png';
        }

        // update fields
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        // check for cover image and update if exists
        if($request->hasFile('cover_img')){
            $book->cover_img = $fileNameToStoreImg;
        }
        // check for book and update if exists
        if($request->hasFile('book')){
            $book->book = $fileNameToStoreBook;
        }
        // save book in db
        $book->save();

        // return book resource
        return (new BookResource($book))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Http\Resources\BookResource
     */
    public function destroy($id)
    {
        // check if book exists in the dv
        $book = Book::find($id);
        if($book == null){
            return response()->json(['error' => 'book not found'], 404);
        }

        // delete book if exists and return resource
        if ($book->delete()) {
            return (new BookResource($book))->response()->setStatusCode(200);
        }
    }
}
