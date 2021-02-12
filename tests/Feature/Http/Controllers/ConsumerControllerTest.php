<?php

namespace Tests\Feature\Http\Controllers;

use App\Company;
use App\Consumer;
use App\Location;
use App\LocationGroup;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ConsumerControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('consumers.index'));

        $response->assertOk();
        $response->assertViewIs('consumers.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('consumers.create'));

        $response->assertOk();
        $response->assertViewIs('consumers._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $this->markTestIncomplete();
        $consumer = create(Consumer::class);

        $response = $this->get(route('consumers.show', $consumer));

        $response->assertOk();
        $response->assertViewIs('consumers.view');
        $response->assertViewHas('resource', $consumer);
    }

    /** @test */
    public function edit_returns_view()
    {
        $this->markTestIncomplete();

        $consumer = create(Consumer::class);

        $response = $this->get(route('consumers.edit', $consumer));

        $response->assertOk();
        $response->assertViewIs('consumers._form');
        $response->assertViewHas('resource', $consumer);
    }

    /** @test */
    public function admin_can_not_create_consumer()
    {
        $this->actingAsAdmin();

        $response = $this->get('/admin/consumers/create');

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_not_edit_consumer()
    {
        $admin = $this->actingAsAdmin();

        $location = create(Location::class, [
            'company_id' => $admin->company->id
        ]);

        $locationGroup = create(LocationGroup::class, [
            'location_id' => $location->id
        ]);

        $consumer = create(Consumer::class, [
            'location_group_id' => $locationGroup->id
        ]);

        $response = $this->get('/admin/consumers/' . $consumer->id . '/edit');

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_not_delete_consumer()
    {
        $admin = $this->actingAsAdmin();

        $location = create(Location::class, [
            'company_id' => $admin->company->id
        ]);

        $locationGroup = create(LocationGroup::class, [
            'location_id' => $location->id
        ]);

        $consumer = create(Consumer::class, [
            'location_group_id' => $locationGroup->id
        ]);

        $response = $this->delete('/admin/consumers/' . $consumer->id);

        $response->assertForbidden();

        $this->getJson('/admin/consumers/get-one/' . $consumer->id)
            ->assertOk();
    }

    /** @test */
    public function admin_can_not_view_consumer_from_other_company()
    {
        $this->actingAsAdmin();

        $otherCompany = create(Company::class);

        $location = create(Location::class, [
            'company_id' => $otherCompany->id
        ]);

        $locationGroup = create(LocationGroup::class, [
            'location_id' => $location->id
        ]);

        $consumer = create(Consumer::class, [
            'location_group_id' => $locationGroup->id
        ]);

        $response = $this->get('/admin/consumers/' . $consumer->id);

        $response->assertNotFound();
    }

    /** @test */
    public function it_returns_all_consumers()
    {
//        $this->assertTrue(false);
    }


    /** @test */
    public function it_returns_single_consumer()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_updates_existing_consumer()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_deletes_existing_consumer()
    {
//        $this->assertTrue(false);
    }
}
