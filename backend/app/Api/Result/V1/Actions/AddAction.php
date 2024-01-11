<?php

namespace App\Api\Result\V1\Actions;

use App\Api\Base\Action\BaseActionAbstract;
use App\Api\Result\V1\Dto\ResultDto;
use App\Api\Result\V1\Services\ResultService;
use App\Repositories\MemberRepository;

class AddAction extends BaseActionAbstract
{
    public function __construct(
        protected ResultService $service,
        protected MemberRepository $memberRepository
    ) {
    }

    public function getRules(): array
    {
        return [
            'email' => 'string|email|max:255|nullable',
            'milliseconds' => 'required|numeric',
        ];
    }

    /**
     *  @OA\Post(
     *      path="/api/result/v1/add",
     *      operationId="ResultAdd",
     *      tags={"result"},
     *      summary="Добавление результата",
     *      description="result add",
     *
     *     @OA\RequestBody(
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                  @OA\Property(
     *                      property="email",
     *                      title="Email",
     *                      type="string",
     *                      example="example@email.com",
     *                  ),
     *                  @OA\Property(
     *                      property="milliseconds",
     *                      title="Milliseconds",
     *                      type="number",
     *                      example="1000",
     *                  ),
     *              )
     *          ),
     *      ),
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
        $member = $this->memberRepository->findByEmail(data_get($this->validated, 'email'));

        $this->service->store(ResultDto::fillFromArray([
            'member_id' => $member?->id,
            'milliseconds' => data_get($this->validated, 'milliseconds')
        ]));

        return null;
    }
}
