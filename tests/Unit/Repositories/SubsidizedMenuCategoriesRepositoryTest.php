<?php

namespace Tests\Unit\Repositories;

use App\MenuCategory;
use App\Repositories\SubsidizedMenuCategoriesRepository;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use Tests\TestCase;

/**
 * @group repository
 */
class SubsidizedMenuCategoriesRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(SubsidizedMenuCategoriesRepository::class);
    }

    /** @test */
    public function it_returns_all_subsidized_menu_categories()
    {
        create(SubsidizedMenuCategories::class, [], 5);

        $results = $this->repository->all();

        $this->assertEquals(5, $results->count());
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $results);
    }

    /** @test */
    public function it_creates_subsidized_menu_category()
    {
        $payload = make(SubsidizedMenuCategories::class)->getAttributes();

        $model = $this->repository->add($payload);

        $this->assertTrue($model->exists);
        $this->assertDatabaseCount($model->getTable(), 1);
        $this->assertDatabaseHas($model->getTable(), $payload);
        $this->assertInstanceOf(SubsidizedMenuCategories::class, $model);
    }

    /** @test */
    public function it_updates_subsidized_menu_category()
    {
        $model = create(SubsidizedMenuCategories::class, ['percent' => 50]);

        $updatedModel = $this->repository->update(['percent' => 80], $model->id);

        $this->assertEquals(80, $updatedModel->percent);
        $this->assertInstanceOf(SubsidizedMenuCategories::class, $updatedModel);
        $this->assertDatabaseHas($updatedModel->getTable(), ['percent' => 80]);
        $this->assertDatabaseMissing($updatedModel->getTable(), ['percent' => 50]);
    }

    /** @test */
    public function it_deletes_subsidized_menu_category()
    {
        $model = create(SubsidizedMenuCategories::class);

        $result = $this->repository->delete($model->id);

        $this->assertEquals(1, $result);
        $this->assertTrue($this->repository->all()->isEmpty());
        $this->assertDeleted($model->getTable(), ['id' => $model->id]);
    }

    /** @test */
    public function it_returns_single_subsidized_menu_category()
    {
        $model = create(SubsidizedMenuCategories::class);

        $result = $this->repository->get($model->id);

        $this->assertEquals(1, $result->count());
        $this->assertEquals($model->id, $result->id);
        $this->assertInstanceOf(SubsidizedMenuCategories::class, $result);
    }

    /** @test */
    public function it_returns_menu_category_with_subsidization()
    {
        $menuCategory = create(MenuCategory::class);

        $subsidizationRule = create(SubsidizationRule::class);

        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'menu_category_id'       => $menuCategory->id,
            'subsidization_rules_id' => $subsidizationRule->id,
        ]);

        $menuCategoryWithSubsidization = $this->repository->getMenuCategoryWithSubsidization($menuCategory->id, $subsidizationRule->id);

        $this->assertEquals($subsidizedMenuCategory->getAttributes(), $menuCategoryWithSubsidization->getAttributes());
    }
}
