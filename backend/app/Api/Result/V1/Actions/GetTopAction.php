<?php

namespace App\Api\Result\V1\Actions;

use App\Api\Base\Action\BaseActionAbstract;
use App\Repositories\MemberRepository;
use App\Repositories\ResultRepositoryContract;
use Illuminate\Support\Facades\Cache;

class GetTopAction extends BaseActionAbstract
{
    public function __construct(
        protected ResultRepositoryContract $resultRepository,
        protected MemberRepository $memberRepository
    ) {
    }

    public function getRules(): array
    {
        return [
            'email' => 'string|email|max:255|nullable',
        ];
    }

    /**
     * @OA\Get(
     *      path="/api/result/v1/get-top-ten",
     *      operationId="ResultGetTopTen",
     *      tags={"result"},
     *      summary="Топ 10 лучших результатов",
     *      description="result top ten",
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          example="example@email.com",
     *          required=true,
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful or error operations",
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                  @OA\Property(
     *                      property="status",
     *                      type="string",
     *                      example="success"
     *                  ),
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="top",
     *                          type="array",
     *
     *                          @OA\Items(
     *                              ref="#/components/schemas/ResultTopDto"
     *                          ),
     *                      ),
     *
     *                      @OA\Property(
     *                           property="self",
     *                           ref="#/components/schemas/ResultTopDto",
     *                       ),
     *                  ),
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Ok"
     *                  )
     *              )
     *          )
     *
     *     )
     * )
     */
    protected function action(): ?array
    {
        $data = Cache::remember('result.top-ten', 0,
            function () {
                $member = $this->memberRepository->findByEmail(data_get($this->validated, 'email'));

                $topTen = $this->resultRepository->getTopExceptMember(
                    exceptMemberId: $member?->id,
                    limit: 10
                );
                $topTen = $topTen->map(function ($item) {
                    $item->email = mask_email($item->email);

                    return $item->toArray();
                });

                $self = $this->resultRepository->getTopOneByMember(
                    memberId: $member?->id,
                );

                //                dd($self);
                return [
                    'top' => $topTen->toArray(),
                    'self' => $self?->toArray(),
                ];
            });

        return $data;
    }
}
