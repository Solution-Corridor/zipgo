<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $exception)
{
    // Let Laravel render the response first
    $response = parent::render($request, $exception);

    // If it's a view response → inject the current auth user
    if ($response instanceof \Illuminate\Http\Response 
        || $response instanceof \Illuminate\Http\JsonResponse
        || $response instanceof \Illuminate\View\View) {
        
        view()->share('authUser', auth()->user());
    }

    // Handle custom error views
    if ($this->isHttpException($exception)) {
        $statusCode = $exception->getStatusCode();

        if (view()->exists("errors.$statusCode")) {
            return response()->view("errors.$statusCode", [], $statusCode);
        }
    }

    return $response;
}
}
