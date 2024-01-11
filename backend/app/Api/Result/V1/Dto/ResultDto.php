<?php

namespace App\Api\Result\V1\Dto;

use App\Api\Base\Dto\BaseDtoAbstract;

/**
 * @OA\Schema(
 *     schema="ResultDto",
 *     title="Результат",
 * )
 */
class ResultDto extends BaseDtoAbstract
{
    /**
     * @OA\Property(
     *     property="member_id",
     *     description="Id of member",
     *     type="number",
     *     example="1",
     * )
     *
     * @var ?int
     */
    public ?int $member_id;

    /**
     * @OA\Property(
     *     property="milliseconds",
     *     description="Миллисекунды",
     *     type="number",
     *     example="1000",
     * )
     */
    public int $milliseconds;
}
