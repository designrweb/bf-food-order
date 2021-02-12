<?php

namespace Tests\Feature\Http\Controllers;

use App\Company;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class CompanyControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('companies.index'));

        $response->assertOk();
        $response->assertViewIs('companies.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('companies.create'));

        $response->assertOk();
        $response->assertViewIs('companies._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $this->markTestIncomplete();

        $company = create(Company::class);

        $response = $this->get(route('companies.show', $company));

        $response->assertOk();
        $response->assertViewIs('companies.view');
        $response->assertViewHas('resource', $company);
    }

    /** @test */
    public function edit_returns_view()
    {
        $this->markTestIncomplete();

        $company = create(Company::class);

        $response = $this->get(route('companies.edit', $company));

        $response->assertOk();
        $response->assertViewIs('companies._form');
        $response->assertViewHas('resource', $company);
    }

    // todo add other methods
    //get('admin/companies/get-all');
    //get('admin/companies/get-structure');
    //get('admin/companies/get-view-structure');
    //get('admin/companies/get-one/{id}');
    //post('admin/companies/');
    //get('admin/companies/{id}/edit');
    //put('admin/companies/{id}');
    //delete('admin/companies/{id}');
}
