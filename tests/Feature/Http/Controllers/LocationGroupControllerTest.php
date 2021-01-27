<?php

namespace Tests\Feature\Http\Controllers;

use App\Location;
use App\LocationGroup;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class LocationGroupControllerTest extends TestCase
{
    // todo remove and acts as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('location-groups.index'));

        $response->assertOk();
        $response->assertViewIs('location_group.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('location-groups.create'));

        $response->assertOk();
        $response->assertViewIs('location_group._form');

        //todo check if view has locationsList
    }

    /** @test */
    public function show_returns_view()
    {
        $locationGroup = create(LocationGroup::class);

        $response = $this->get(route('location-groups.show', $locationGroup));

        $response->assertOk();
        $response->assertViewIs('location_group.view');
        $response->assertViewHas('resource', $locationGroup);
    }

    /** @test */
    public function edit_returns_view()
    {
        $locationGroup = create(LocationGroup::class);

        $response = $this->get(route('location-groups.edit', $locationGroup));

        $response->assertOk();
        $response->assertViewIs('location_group._form');
        $response->assertViewHas('resource', $locationGroup);
    }

    /** @test */
    public function it_returns_index_structure()
    {
        $response = $this->get('/admin/location-groups/get-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "filters"      => [
                    'name',
                    'location_id',
                    'number_of_students',
                ],
                "sort"         => [
                    'name',
                    'location_id',
                    'number_of_students',
                ],
                "fields"       => [],
                "allowActions" => []
            ]);
    }

    /** @test */
    public function it_returns_view_structure()
    {
        $response = $this->get('/admin/location-groups/get-view-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "fields"       => [],
                "allowActions" => []
            ]);
    }

    /** @test */
    public function it_returns_all_location_groups()
    {
        create(LocationGroup::class, [], 5);

        $response = $this->getJson('/admin/location-groups/get-all');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure(['data', 'pagination']);

        // todo write get-all. return groups for admin of company
    }

    /** @test */
    public function it_returns_single_location_group()
    {
        $location = create(Location::class);

        $payload = [
            'name'        => 'Name',
            'location_id' => $location->id,
        ];

        $locationGroup = create(LocationGroup::class, $payload);

        $response = $this->get('/admin/location-groups/get-one/' . $locationGroup->id);

        $response
            ->assertOk()
            ->assertJson($payload)
            ->assertJsonStructure([
                'id',
                'location_id',
                'name',
                'location'
            ]);
    }

    // todo write get-one. return groups for admin of company

    /** @test */
    public function it_creates_new_location_group()
    {
        $location = create(Location::class);
        $payload  = [
            'name'        => 'Name',
            'location_id' => $location->id,
        ];

        $response = $this->postJson('/admin/location-groups', $payload);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id',
            ]);

        $checkResponse = $this->getJson(
            '/admin/location-groups/get-one/' . $response->getData()->id);

        $checkResponse
            ->assertOk()
            ->assertJson($payload);
    }

    /** @test */
    public function it_updates_existing_location_group()
    {
        $location = create(Location::class);

        $locationGroup = create(LocationGroup::class, [
            'name'        => 'Name',
            'location_id' => $location->id,
        ]);

        $response = $this->putJson('/admin/location-groups/' . $locationGroup->id, [
            'name'        => 'New Name',
            'location_id' => $location->id,
        ]);

        $response
            ->assertOk()
            ->assertExactJson([
                'id'          => $response->getData()->id,
                'name'        => 'New Name',
                'location_id' => $location->id,
            ]);
    }

    /** @test */
    public function it_can_not_delete_existing_location_group()
    {
        $location = create(Location::class);

        $payload = [
            'name'        => 'Name',
            'location_id' => $location->id,
        ];

        $locationGroup = create(LocationGroup::class, $payload);

        $response = $this->deleteJson('/admin/location-groups/' . $locationGroup->id);

        $response->assertStatus(405);

        $checkResponse = $this->getJson(
            '/admin/location-groups/get-one/' . $locationGroup->id);

        $checkResponse
            ->assertOk()
            ->assertJson($payload);
    }

    // todo test for validation
}
