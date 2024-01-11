<?php


use App\Api\Result\V1\Dto\ResultDto;
use App\Api\Result\V1\Services\ResultService;
use App\Models\Member;
use App\Models\Result;

beforeEach(function () {
    $this->service = app(ResultService::class);
});

test('api service result store', function () {

    Member::factory()->create();
    $data = Result::factory()->make()->toArray();

    $result = $this->service->store(ResultDto::fillFromArray($data));

    $resultData = $result->only(array_keys($data));

    $this->assertEquals($data, $resultData);

});
