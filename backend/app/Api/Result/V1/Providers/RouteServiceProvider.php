<?php

namespace App\Api\Result\V1\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @OA\Server(
     *     url=LOCAL_HOST,
     *     description="Local"
     * ),
     *
     * @OA\Info(
     *     title="Tribe - Result API",
     *     version="1",
     *     description="Result API"
     * )
     */
    public function boot()
    {
        $this->routes(function () {
            Route::middleware([
                \App\Api\Base\Middlewares\ApiExceptionMiddleware::class,
            ])->prefix('/api/result/v1')
                ->group(base_path('app/Api/Result/V1/Routes/api.php'));
        });
    }
}
