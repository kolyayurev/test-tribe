<?php

namespace App\Repositories;

use App\Api\Result\V1\Dto\ResultTopDto;
use Illuminate\Support\Collection;

interface ResultRepositoryContract
{
    /**
     * @return Collection<int, ResultTopDto>
     */
    public function getTopExceptMember(?int $exceptMemberId = null, int $limit = 10): Collection;

    /**
     * @return ?ResultTopDto
     */
    public function getTopOneByMember(?int $memberId = null): ?ResultTopDto;
}
