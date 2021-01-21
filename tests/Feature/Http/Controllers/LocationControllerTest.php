<?php

namespace Tests\Feature\Http\Controllers;

use App\Company;
use App\Location;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class LocationControllerTest extends TestCase
{
    // todo remove and acts as admin
    use WithoutMiddleware;

    /** @test */
    public function it_returns_index_location_structure()
    {
        $response = $this->get('/admin/locations/get-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "filters"      => [],
                "sort"         => [
                    'image_name',
                    'name',
                ],
                "fields"       => [

                ],
                "allowActions" => []
            ]);
    }

    /** @test */
    public function it_returns_view_location_structure()
    {
        $response = $this->get('/admin/locations/get-view-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "fields"       => [],
                "allowActions" => []
            ]);
    }

    /** @test */
    public function it_creates_new_location()
    {
        $company = create(Company::class);

        $payload = [
            'name'       => 'Name',
            'street'     => 'Street',
            'company_id' => $company->id,
            'zip'        => 12345,
            'city'       => 'City',
            'email'      => 'some@wxample.com',
            'slug'       => 'new-slug',
        ];

        $response = $this->postJson('/admin/locations', $payload);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id',
            ]);

        $checkResponse = $this->getJson(
            '/admin/locations/get-one/' . $response->getData()->id);

        $checkResponse
            ->assertOk()
            ->assertJson($payload);
    }

    /** @test */
    public function it_deletes_existing_location()
    {
        $location = create(Location::class);

        $this->getJson('/admin/locations/get-one/' . $location->id)
            ->assertOk();

        $this->delete('/locations/' . $location->id);

        $this->getJson('/admin/locations/' . $location->id)
            ->assertStatus(404);
    }
}
