<?php

namespace Tests\Unit\Models\Consumer\Relation;

use App\Company;
use App\Consumer;
use App\ConsumerSubsidization;
use App\Location;
use App\LocationGroup;
use App\Order;
use App\SubsidizationRule;
use Tests\TestCase;

/**
 * @group relation
 */
class ConsumerRelationTest extends TestCase
{
    /** @test */
    public function consumer_has_subsidization()
    {
        $consumer          = create(Consumer::class);
        $subsidizationRule = create(SubsidizationRule::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id
        ]);

        $this->assertEquals(1, $consumer->subsidization->count());
        $this->assertInstanceOf(ConsumerSubsidization::class, $consumer->subsidization);
    }

    /** @test */
    public function consumer_does_not_have_direct_subsidization_rule_relation()
    {
        $consumer = create(Consumer::class);

        $this->assertEmpty($consumer->subsidizationRule);
    }

    /** @test */
    public function consumer_has_many_pre_orders_for_current_day()
    {
        $consumer = create(Consumer::class);

        $order = create(Order::class, [
            'consumer_id' => $consumer->id,
            'pickedup'    => 0,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d')
        ]);

        create(Order::class, [
            'consumer_id' => $consumer->id,
            'pickedup'    => 0,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d')
        ], 3);


        create(Order::class, [
            'pickedup'    => 0,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d')
        ], 2);

        $this->assertEquals(4, $consumer->preOrderedItems->count());
        $this->assertTrue($consumer->preOrderedItems->contains($order));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $consumer->preOrderedItems);
    }

    /** @test */
    public function consumer_has_many_pre_orders_picked_up_in_current_day()
    {

        $posManager = $this->actingAsPosManager();

        $consumer = create(Consumer::class, [
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        $order = create(Order::class, [
            'consumer_id' => $consumer->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d')
        ]);

        create(Order::class, [
            'consumer_id' => $consumer->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d')
        ], 2);

        create(Order::class, [
            'consumer_id' => $consumer->id,
            'pickedup'    => 0,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d')
        ]);

        $t = $consumer->pickedUpPreOrderedItems;

        $this->assertEquals(3, $consumer->pickedUpPreOrderedItems->count());
        $this->assertTrue($consumer->pickedUpPreOrderedItems->contains($order));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $consumer->pickedUpPreOrderedItems);
    }

    /** @test */
    public function consumer_belongs_to_location_group()
    {
        $consumer = create(Consumer::class, [
            'location_group_id' => create(LocationGroup::class)
        ]);

        $this->assertEquals(1, $consumer->locationgroup->count());
        $this->assertInstanceOf(LocationGroup::class, $consumer->locationgroup);
    }

    /** @test */
    public function consumer_belongs_to_location_through_location_group()
    {
        $consumer = create(Consumer::class, [
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => create(Location::class)
            ])
        ]);

        $this->assertEquals(1, $consumer->location->count());
        $this->assertInstanceOf(Location::class, $consumer->location);
    }

    /** @test */
    public function consumer_belongs_to_company_through_location()
    {
        $consumer = create(Consumer::class, [
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => create(Location::class, [
                    'company_id' => create(Company::class)
                ])
            ])
        ]);

        $this->assertEquals(1, $consumer->company->count());
        $this->assertInstanceOf(Company::class, $consumer->company);
    }
}
