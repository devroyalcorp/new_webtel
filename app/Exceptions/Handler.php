<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    function render($request, Throwable $e)
    {
            if ($this->isHttpException($e)) {
                if ($e->getStatusCode() == 404) {
                    return response()->view('errors.404', [], 404);
                }
                if ($e->getStatusCode() == 500) {
                    $errorCode = "500";
                    return response()->view('errors.500', [], 500, compact('errorCode'));
                }
                if ($e->getStatusCode() == 400) {
                    $errorCode = "400";
                    return response()->view('errors.500', [], 400, compact('errorCode'));
                }
            }
            return parent::render($request, $e);
         }
}
