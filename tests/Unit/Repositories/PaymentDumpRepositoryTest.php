<?php

namespace Tests\Unit\Repositories;

use App\PaymentDump;
use App\Repositories\PaymentDumpRepository;
use Tests\TestCase;

/**
 * @group repository
 */
class PaymentDumpRepositoryTest extends TestCase
{
    protected $paymentDumpRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->paymentDumpRepository = $this->app->make(PaymentDumpRepository::class);
    }

    /** @test */
    public function it_returns_all_payment_dumps()
    {
        create(PaymentDump::class, [], 5);

        $results = $this->paymentDumpRepository->all();

        $this->assertEquals(5, $results->count());
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $results);
    }

    /** @test */
    public function it_creates_payment_dump()
    {
        $payload = make(PaymentDump::class)->getAttributes();

        $model = $this->paymentDumpRepository->add($payload);

        $this->assertTrue($model->exists);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $payload);
        $this->assertInstanceOf(PaymentDump::class, $model);
    }

    /** @test */
    public function it_updates_payment_dump()
    {
        $model = create(PaymentDump::class, ['file_name' => 'first-dump.csv']);

        $updatedModel = $this->paymentDumpRepository->update(['file_name' => 'second-dump.csv'], $model->id);

        $this->assertEquals('second-dump.csv', $updatedModel->file_name);
        $this->assertInstanceOf(PaymentDump::class, $updatedModel);
        $this->assertDatabaseHas($updatedModel->getTable(), ['file_name' => 'second-dump.csv']);
        $this->assertDatabaseMissing($updatedModel->getTable(), ['file_name' => 'first-dump.csv']);
    }

    /** @test */
    public function it_deletes_payment_dump()
    {
        $model = create(PaymentDump::class);

        $result = $this->paymentDumpRepository->delete($model->id);

        $this->assertEquals(1, $result);
        $this->assertTrue($this->paymentDumpRepository->all()->isEmpty());
        $this->assertDeleted($model->getTable(), ['id' => $model->id]);
    }

    /** @test */
    public function it_returns_single_payment_dump()
    {
        $model = create(PaymentDump::class);

        $result = $this->paymentDumpRepository->get($model->id);

        $this->assertEquals(1, $result->count());
        $this->assertEquals($model->id, $result->id);
        $this->assertInstanceOf(PaymentDump::class, $result);
    }
}
