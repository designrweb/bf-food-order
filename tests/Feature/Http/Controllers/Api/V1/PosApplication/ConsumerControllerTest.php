<?php

namespace Tests\Feature\Http\Controllers\Api\V1\PosApplication;

use App\Consumer;
use App\ConsumerQrCode;
use App\ConsumerSubsidization;
use App\LocationGroup;
use App\MenuCategory;
use App\SubsidizationOrganization;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @group pos_api_controller
 */
class ConsumerControllerTest extends TestCase
{
    /** @test */
    public function it_should_forbid_an_unauthenticated_user_to_retrieve_all_consumers()
    {
        $response = $this->getJson('/api/v1/pos/consumer');

        $response->assertUnauthorized();
        $response->assertExactJson([
            "message" => "Unauthorized",
            "status"  => 401
        ]);
    }

    /** @test */
    public function it_returns_consumers_that_belong_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => create(SubsidizationRule::class, [
                'subsidization_organization_id' => create(SubsidizationOrganization::class, [
                    'company_id' => $posManager->location->company->id,
                ]),
            ]),
            'menu_category_id'      => create(MenuCategory::class, [
                'location_id' => $posManager->location->id,
            ]),
            'percent'               => 70
        ]);

        $consumerFirst = create(Consumer::class, [
            'balance'           => '250.45',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        create(ConsumerSubsidization::class, [
            'subsidization_rule_id' => $subsidizedMenuCategory->subsidization_rule_id,
            'consumer_id'           => $consumerFirst->id,
            'subsidization_start'   => Carbon::now()->subDays(10),
        ]);

        $consumerSecond = create(Consumer::class, [
            'balance'           => '50.15',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        create(Consumer::class, [
            'balance' => '320.00'
        ]);

        $response = $this->getJson('/api/v1/pos/consumer');

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
                "subsidizedMenuCategories" => [
                    [
                        'menu_category_id'      => $subsidizedMenuCategory->menu_category_id,
                        'subsidization_rule_id' => $subsidizedMenuCategory->subsidization_rule_id,
                        'percent'               => 70
                    ],
                ]
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
                "subsidizedMenuCategories" => $consumerSecond->subsidizedMenuCategories
            ]
        ]);
    }

    /** @test */
    public function it_searches_consumer_by_first_or_last_name()
    {
        $posManager = $this->actingAsPosManager();

        $consumerFirst = create(Consumer::class, [
            'balance'           => '250.45',
            'firstname'         => 'Antua',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        $consumerSecond = create(Consumer::class, [
            'balance'           => '50.15',
            'lastname'          => 'Panteric',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        create(Consumer::class, [
            'balance' => '320.00'
        ]);

        $response = $this->getJson('/api/v1/pos/search/consumer?term=ant');

        $response->assertOk();
        $response->assertExactJson([
            [
                "consumer_id"              => $consumerFirst->id,
                "firstname"                => 'Antua',
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
                "lastname"                 => 'Panteric',
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
    public function it_search_consumer_by_qr_code()
    {
        $firstQrCode  = '843ae5ed4812b163859acaf36f60f2d222eba11b924fc3c395289467778e9a03';
        $secondQrCode = '3223fc738b45b1205bc4edd5c55d484c849ba5565836dce10de8281784009cc3';

        $posManager = $this->actingAsPosManager();

        $consumerFirst = create(Consumer::class, [
            'balance'           => '250.45',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        $consumerSecond = create(Consumer::class, [
            'balance'           => '50.15',
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        create(Consumer::class, [
            'balance' => '320.00'
        ]);

        create(ConsumerQrCode::class, [
            'consumer_id'  => $consumerFirst->id,
            'qr_code_hash' => $firstQrCode,
        ]);

        create(ConsumerQrCode::class, [
            'consumer_id'  => $consumerSecond->id,
            'qr_code_hash' => $secondQrCode,
        ]);

        $response = $this->getJson('/api/v1/pos/search/consumer-qr-code?term=' . $firstQrCode);

        $response->assertOk();
        $response->assertExactJson([
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
        ]);
    }
}
