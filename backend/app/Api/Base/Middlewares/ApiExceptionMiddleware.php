<?php

namespace App\Api\Base\Middlewares;

use App\Api\Base\Action\BaseActionAbstract;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function __;
use function config;
use function response;

class ApiExceptionMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            return $next($request);

        } catch (\Throwable $exception) {
            $status = $exception->getCode();
            $text = config('app.debug') ?
                $exception->getMessage()
                :
                __('Internal server error');

            return response()->json([
                'data' => null,
                'status' => BaseActionAbstract::STATUS_ERROR,
                'message' => $text,
            ], $status);
        }
    }
}
