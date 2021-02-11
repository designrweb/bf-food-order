<?php

namespace Tests\Unit\Repositories;

use App\Consumer;
use App\Order;
use App\Payment;
use App\Repositories\PaymentRepository;
use Tests\TestCase;

/**
 * @group repository
 */
class PaymentRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(PaymentRepository::class);
    }

    /** @test */
    public function it_returns_all_payments()
    {
        create(Payment::class, [], 5);

        $results = $this->repository->all();

        $this->assertEquals(5, $results->count());
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $results);
    }

    /** @test */
    public function it_creates_payment()
    {
        $payload = make(Payment::class, [
            'amount'        => 5,
            'transacted_at' => '2021-01-11',
        ])->getAttributes();

        $model = $this->repository->add($payload);

        $this->assertTrue($model->exists);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $payload);
        $this->assertInstanceOf(Payment::class, $model);
    }

    /** @test */
    public function it_updates_payment()
    {
        $model = create(Payment::class, ['comment' => 'First payment']);

        $updatedModel = $this->repository->update(['comment' => 'Second payment'], $model->id);

        $this->assertEquals('Second payment', $updatedModel->comment);
        $this->assertInstanceOf(Payment::class, $updatedModel);
        $this->assertDatabaseHas($updatedModel->getTable(), ['comment' => 'Second payment']);
        $this->assertDatabaseMissing($updatedModel->getTable(), ['comment' => 'First payment']);
    }

    /** @test */
    public function it_deletes_payment()
    {
        $model = create(Payment::class);

        $result = $this->repository->delete($model->id);

        $this->assertEquals(1, $result);
        $this->assertTrue($this->repository->all()->isEmpty());
        $this->assertDeleted($model->getTable(), ['id' => $model->id]);
    }

    /** @test */
    public function it_returns_single_payment()
    {
        $model = create(Payment::class);

        $result = $this->repository->get($model->id);

        $this->assertEquals(1, $result->count());
        $this->assertEquals($model->id, $result->id);
        $this->assertInstanceOf(Payment::class, $result);
    }

    /** @test */
    public function there_is_already_one_order_with_subsidization_for_consumer_on_given_date()
    {
        $date = '2021-02-02';

        $consumer = create(Consumer::class);

        $subsidizedOrder = create(Order::class, [
            'consumer_id'   => $consumer->id,
            'day'           => $date,
            'is_subsidized' => Order::IS_SUBSIDIZED,
        ]);

        $newOrder = create(Order::class, [
            'consumer_id' => $consumer->id,
            'day'         => $date,
        ]);

        $ordersWithSubsidizationCount = $this->repository->countOrdersWithSubsidizationByDateForConsumer($newOrder);

        $this->assertEquals(1, $ordersWithSubsidizationCount);
    }

    /** @test */
    public function there_is_no_orders_with_subsidization_for_consumer_on_given_date()
    {
        $date = '2021-02-02';

        $consumer = create(Consumer::class);

        $notSubsidizedOrder = create(Order::class, [
            'consumer_id'   => $consumer->id,
            'day'           => $date,
            'is_subsidized' => null,
        ]);

        $newOrder = create(Order::class, [
            'consumer_id' => $consumer->id,
            'day'         => $date,
        ]);

        $ordersWithSubsidizationCount = $this->repository->countOrdersWithSubsidizationByDateForConsumer($newOrder);

        $this->assertEquals(0, $ordersWithSubsidizationCount);
    }
}
