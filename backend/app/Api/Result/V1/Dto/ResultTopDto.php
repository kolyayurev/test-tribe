<?php

namespace App\Api\Result\V1\Dto;

use App\Api\Base\Dto\BaseDtoAbstract;

/**
 * @OA\Schema(
 *     schema="ResultTopDto",
 *     title="Топовый результат",
 * )
 */
class ResultTopDto extends BaseDtoAbstract
{
    /**
     * @OA\Property(
     *     property="email",
     *     example="example@email.com",
     *     type="string",
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *     property="place",
     *     description="Место в рейтинге",
     *     type="number",
     *     example="1",
     * )
     *
     * @var int
     */
    public int $place;

    /**
     * @OA\Property(
     *     property="milliseconds",
     *     description="Миллисекунды",
     *     type="number",
     *     example="1000",
     * )
     *
     * @var int
     */
    public int $milliseconds;

}
