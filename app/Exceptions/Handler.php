<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        $httpCode = $exception->getCode();

        if($httpCode == 500){
            return response()->json([
                'error' => 'internal error'
            ], 500);
        }

        if($httpCode == 400){
            return response()->json([
                'error' => 'Bad request'
            ], 400);
        }

        if($httpCode == 401){
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        if($httpCode == 405){
            return response()->json([
                'error' => 'Method Not Allowed'
            ], 405);
        }

        if($httpCode >= 403 && $httpCode <= 499){
            return response()->json([
                'error' => 'Bad request'
            ], 403);
        }


        // This will replace our 404 response with
        // a JSON response.
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json([
                'error' => 'Resource not found'
            ], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException && $request->wantsJson()) {
            return response()->json([
                'error' => 'Method Not Allowed'
            ], 405);
        }

        return parent::render($request, $exception);
    }
}
