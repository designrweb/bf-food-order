<?php

namespace Tests\Unit\Repositories;

use App\Order;
use App\Repositories\OrderRepository;
use Tests\TestCase;

/**
 * @group repository
 */
class OrderRepositoryTest extends TestCase
{
    protected $orderRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = $this->app->make(OrderRepository::class);
    }

    /** @test */
    public function it_returns_all_orders()
    {
        create(Order::class, [], 5);

        $results = $this->orderRepository->all();

        $this->assertEquals(5, $results->count());
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $results);
    }

    /** @test */
    public function it_creates_order()
    {
        $payload = make(Order::class)->getAttributes();

        $model = $this->orderRepository->add($payload);

        $this->assertTrue($model->exists);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $payload);
        $this->assertInstanceOf(Order::class, $model);
    }

    /** @test */
    public function it_updates_order()
    {
        $model = create(Order::class, ['day' => '2020-02-02']);

        $updatedModel = $this->orderRepository->update(['day' => '2021-12-12'], $model->id);

        $this->assertEquals('2021-12-12', $updatedModel->day);
        $this->assertInstanceOf(Order::class, $updatedModel);
        $this->assertDatabaseHas($updatedModel->getTable(), ['day' => '2021-12-12']);
        $this->assertDatabaseMissing($updatedModel->getTable(), ['day' => '2020-02-02']);
    }

    /** @test */
    public function it_soft_deletes_order()
    {
        $model = create(Order::class);

        $result = $this->orderRepository->delete($model->id);

        $this->assertEquals(1, $result);
        $this->assertTrue($this->orderRepository->all()->isEmpty());
        $this->assertSoftDeleted($model->getTable(), ['id' => $model->id]);
    }

    /** @test */
    public function it_returns_single_order()
    {
        $model = create(Order::class);

        $result = $this->orderRepository->get($model->id);

        $this->assertEquals(1, $result->count());
        $this->assertEquals($model->id, $result->id);
        $this->assertInstanceOf(Order::class, $result);
    }
}
