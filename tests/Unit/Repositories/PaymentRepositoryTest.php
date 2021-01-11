<?php

namespace Tests\Unit\Repositories;

use App\Payment;
use App\Repositories\PaymentRepository;
use Tests\TestCase;

/**
 * @group repository
 */
class PaymentRepositoryTest extends TestCase
{
    protected $paymentRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->paymentRepository = $this->app->make(PaymentRepository::class);
    }

    /** @test */
    public function it_returns_all_payments()
    {
        create(Payment::class, [], 5);

        $results = $this->paymentRepository->all();

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

        $model = $this->paymentRepository->add($payload);

        $this->assertTrue($model->exists);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $payload);
        $this->assertInstanceOf(Payment::class, $model);
    }

    /** @test */
    public function it_updates_payment()
    {
        $model = create(Payment::class, ['comment' => 'First payment']);

        $updatedModel = $this->paymentRepository->update(['comment' => 'Second payment'], $model->id);

        $this->assertEquals('Second payment', $updatedModel->comment);
        $this->assertInstanceOf(Payment::class, $updatedModel);
        $this->assertDatabaseHas($updatedModel->getTable(), ['comment' => 'Second payment']);
        $this->assertDatabaseMissing($updatedModel->getTable(), ['comment' => 'First payment']);
    }

    /** @test */
    public function it_deletes_payment()
    {
        $model = create(Payment::class);

        $result = $this->paymentRepository->delete($model->id);

        $this->assertEquals(1, $result);
        $this->assertTrue($this->paymentRepository->all()->isEmpty());
        $this->assertDeleted($model->getTable(), ['id' => $model->id]);
    }

    /** @test */
    public function it_returns_single_payment()
    {
        $model = create(Payment::class);

        $result = $this->paymentRepository->get($model->id);

        $this->assertEquals(1, $result->count());
        $this->assertEquals($model->id, $result->id);
        $this->assertInstanceOf(Payment::class, $result);
    }
}
