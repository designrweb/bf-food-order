<?php

namespace Tests\Feature\Http\Controllers\Api\V1\PosApplication;

use App\Consumer;
use App\LocationGroup;
use Tests\TestCase;

/**
 * @group api_controller
 */
class ConsumerControllerTest extends TestCase
{
    /** @test */
    public function it_returns_all_consumers()
    {
        $this->withoutExceptionHandling();

        $consumerFirst = create(Consumer::class, [
            'balance' => '250.45'
        ]);

        $consumerSecond = create(Consumer::class, [
            'balance' => '320.00'
        ]);

        $response = $this->get('/api/v1/pos/consumer');

        $response->assertOk();
        $response->assertExactJson([
            [
                "consumer_id"              => $consumerFirst->id,
                "firstname"                => $consumerFirst->firstname,
                "lastname"                 => $consumerFirst->lastname,
                "coefficient"              => $consumerFirst->balance,
                "locationGroup"            => $consumerFirst->locationgroup->name,
                "image"                    => null,
                "preOrderedItems"          => $consumerFirst->preOrderedItems,
                "pickedUpPreOrderedItems"  => $consumerFirst->pickedUpPreOrderedItems,
                "pickedUpPosOrderedItems"  => $consumerFirst->pickedUpPosOrderedItems,
                "subsidizedMenuCategories" => []
            ],
            [
                "consumer_id"              => $consumerSecond->id,
                "firstname"                => $consumerSecond->firstname,
                "lastname"                 => $consumerSecond->lastname,
                "coefficient"              => $consumerSecond->balance,
                "locationGroup"            => $consumerSecond->locationgroup->name,
                "image"                    => null,
                "preOrderedItems"          => $consumerSecond->preOrderedItems,
                "pickedUpPreOrderedItems"  => $consumerSecond->pickedUpPreOrderedItems,
                "pickedUpPosOrderedItems"  => $consumerSecond->pickedUpPosOrderedItems,
                "subsidizedMenuCategories" => []
            ]
        ]);
    }

    /** @test */
    public function it_returns_consumers_that_belong_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        $consumerFirst = create(Consumer::class, [
            'balance'           => '250.45',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        create(Consumer::class, [
            'balance' => '320.00'
        ]);

        $response = $this->get('/api/v1/pos/consumer');

        $response->assertOk();
        $response->assertExactJson([
            [
                "consumer_id"              => $consumerFirst->id,
                "firstname"                => $consumerFirst->firstname,
                "lastname"                 => $consumerFirst->lastname,
                "coefficient"              => $consumerFirst->balance,
                "locationGroup"            => $consumerFirst->locationgroup->name,
                "image"                    => null,
                "preOrderedItems"          => $consumerFirst->preOrderedItems,
                "pickedUpPreOrderedItems"  => $consumerFirst->pickedUpPreOrderedItems,
                "pickedUpPosOrderedItems"  => $consumerFirst->pickedUpPosOrderedItems,
                "subsidizedMenuCategories" => []
            ]
        ]);
    }
}
