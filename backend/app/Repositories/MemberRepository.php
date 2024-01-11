<?php

namespace App\Repositories;

use App\Models\Member;

/**
 * @extends BaseRepository<Member>
 */
class MemberRepository extends BaseRepository
{
    protected string $model = Member::class;

    public function findByEmail(?string $email): ?Member
    {
        return $this->query()->where('email', $email)->first();
    }
}
