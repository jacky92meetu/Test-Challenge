<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // This will replace our 404 response with
        // a JSON response.
        if($exception instanceof \Illuminate\Validation\ValidationException){
            return response()->json([
                'error' => 'Invalid data'
            ], 400);
        }
        if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
            return response()->json([
                'error' => 'Method not allowed'
            ], 405);
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException || $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 404);
        }
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 403);
        }
        
        return parent::render($request, $exception);
    }
}
