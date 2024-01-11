<?php

namespace App\Repositories;

use App\Models\Result;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\Api\Result\V1\Dto\ResultTopDto;

/**
 * @extends BaseRepository<Result>
 *
 */
class ResultRepository extends BaseRepository implements ResultRepositoryContract
{
    protected string $model = Result::class;

    /**
     * @param int|null $exceptMemberId
     * @param int $limit
     * @return Collection<int, ResultTopDto>
     */
    public function getTopExceptMember(?int $exceptMemberId = null, int $limit = 10): Collection
    {
        return
            DB::query()
                ->select([
                    'email',
                    'place',
                    'milliseconds'
                ])
                ->fromSub(
                    $this->calculatePlaceQuery(),
                    'r2',
                )
                ->whereNot('r2.member_id', $exceptMemberId)
                ->limit($limit)
                ->get()
                ->map(function ($item) {
                    return ResultTopDto::fillFromModel($item);
                });
    }

    /**
     * @param int|null $memberId
     * @return ?ResultTopDto
     */
    public function getTopOneByMember(?int $memberId = null): ?ResultTopDto
    {
        $data = DB::query()
            ->select([
                'email',
                'place',
                'milliseconds'
            ])
            ->fromSub(
                $this->calculatePlaceQuery(),
                'r2',
            )
            ->where('r2.member_id', $memberId)
            ->first();

        return $data ? ResultTopDto::fillFromModel($data) : null;

    }

    protected function calculatePlaceQuery(): Builder
    {
        return
            DB::query()
                ->fromRaw('(SELECT @position:=0) as t')
                ->select([
                    'r1.member_id',
                    'r1.email',
                    'r1.milliseconds',
                    DB::raw('@position := @position + 1 AS place')
                ])
                ->joinSub(
                    DB::query()
                        ->from('results')
                        ->select([
                            'results.member_id',
                            'members.email',
                            DB::raw('MIN(results.milliseconds) as milliseconds')
                        ])
                        ->leftJoin('members', 'results.member_id', '=', 'members.id')
                        ->whereNotNull('results.member_id')
                        ->groupBy('results.member_id')
                        ->orderBy('milliseconds')
                    ,
                    'r1',
                    function ($join) {
                        $join->on(DB::raw(1), '=', DB::raw(1));
                    }
                );
    }
}
