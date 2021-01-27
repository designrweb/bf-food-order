<?php

namespace Tests\Unit\Repositories;

use App\LocationGroup;
use App\Repositories\LocationGroupRepository;
use Tests\TestCase;

/**
 * @group repository
 */
class LocationGroupRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(LocationGroupRepository::class);
    }

    /** @test */
    public function it_returns_all_location_groups()
    {
        create(LocationGroup::class, [], 5);

        $results = $this->repository->all();

        $this->assertEquals(5, $results->count());
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $results);
    }

    /** @test */
    public function it_returns_single_location_group()
    {
        $model = create(LocationGroup::class);

        $result = $this->repository->get($model->id);

        $this->assertEquals(1, $result->count());
        $this->assertEquals($model->id, $result->id);
        $this->assertInstanceOf(LocationGroup::class, $result);
    }

    /** @test */
    public function it_creates_location_group()
    {
        $payload = make(LocationGroup::class)->getAttributes();

        $model = $this->repository->add($payload);

        $this->assertTrue($model->exists);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $payload);
        $this->assertInstanceOf(LocationGroup::class, $model);
    }

    /** @test */
    public function it_updates_location_group()
    {
        $model = create(LocationGroup::class, ['name' => 'k9']);

        $updatedModel = $this->repository->update(['name' => 'A2'], $model->id);

        $this->assertEquals('A2', $updatedModel->name);
        $this->assertInstanceOf(LocationGroup::class, $updatedModel);
        $this->assertDatabaseHas($updatedModel->getTable(), ['name' => 'A2']);
        $this->assertDatabaseMissing($updatedModel->getTable(), ['name' => 'k9']);
    }
}
