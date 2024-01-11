<?php

namespace App\Api\Result\V1\Services;

use App\Api\Base\Services\CRUD\BaseCRUDService;
use App\Models\Result;

/**
 * @extends BaseCRUDService<Result>
 */
class ResultService extends BaseCRUDService
{
    protected string $model = Result::class;
}
