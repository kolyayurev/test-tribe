<?php

namespace App\Exceptions;

use App\Api\Base\Action\BaseActionAbstract;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        \App\Api\Base\Exceptions\ApiException::class,
    ];

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

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            if ($e instanceof MethodNotAllowedException) {
                $text = __('The GET method is not supported');
            } elseif ($e instanceof NotFoundHttpException) {
                $text = __('Route not found');
            } elseif ($e instanceof TooManyRequestsHttpException) {
                $text = __('Too many requests');
            } else {
                $text = config('app.debug') ?
                    $e->getMessage()
                    :
                    __('Internal server error');
            }

            return response()->json([
                'data' => null,
                'status' => BaseActionAbstract::STATUS_ERROR,
                'message' => $text,
            ]);
        }

        return parent::render($request, $e);
    }
}
