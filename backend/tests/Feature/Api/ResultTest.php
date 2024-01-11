<?php

use App\Api\Base\Action\BaseActionAbstract;
use App\Models\Member;
use App\Models\Result;

it('api result add', function () {

    $member = Member::factory()->create();

    $attributes = ['email'=> $member->email, 'milliseconds' => rand(0, 10000)];

    $response = $this->postJson(route('api.result.add'), $attributes);

    $response->assertStatus(200)->assertJson(['status' => BaseActionAbstract::STATUS_SUCCESS,'data'=>null,'message'=>'Ok']);

    $this->assertDatabaseHas('results', ['member_id'=> $member->id, 'milliseconds' => $attributes['milliseconds']]);
});




