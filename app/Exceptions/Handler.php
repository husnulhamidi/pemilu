<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\InvalidOrderException;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
       
        // $this->renderable(function(\Illuminate\Validation\ValidationException $e, $request) {
        //     return response()->json([
        //         'result' => 1,
        //         'errors' => $e->errors()
        //     ], 200);
        // });

        // $this->renderable(function (InvalidOrderException $e, $request) {
        //     return response()->view('errors.invalid-order', [], 500);
        // });

        // $this->renderable(function (NotFoundHttpException $e, $request) {
        //     if ($request->is('api/*')) {
        //         return response()->json([
        //             'message' => 'Record not found.'
        //         ], 404);
        //     }
        // });
        
        // if ($exception instanceof ModelNotFoundException) {
        //     return response()->json([
        //         'success' => "false",
        //         'message' => $e->errors()
        //     ], 404);
        // }

        // //check if exception is an instance of NotFoundHttpException.
        // if ($exception instanceof NotFoundHttpException) {
        //          return response()->json([
        //         'success' => "false",
        //         'message' => $e->errors()
        //     ], 404);
        // }

        //return parent::render($request, $exception);

    }

    
}
