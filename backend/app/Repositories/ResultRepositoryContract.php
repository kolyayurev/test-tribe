<?php

namespace App\Repositories;

use App\Api\Result\V1\Dto\ResultTopDto;
use Illuminate\Support\Collection;


interface ResultRepositoryContract
{
    /**
     * @param int|null $exceptMemberId
     * @param int $limit
     * @return Collection<int, ResultTopDto>
     */
    public function getTopExceptMember(?int $exceptMemberId = null, int $limit = 10): Collection;

    /**
     * @param  int|null  $memberId
     * @return ?ResultTopDto
     */
    public function getTopOneByMember(?int $memberId = null): ?ResultTopDto;
}
