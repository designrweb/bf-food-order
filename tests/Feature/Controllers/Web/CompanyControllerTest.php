<?php

namespace Tests\Feature\Controllers\Web;

use App\Company;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class CompanyControllerTest extends TestCase
{
    // todo remove
    use WithoutMiddleware;

    /** @test */
    public function index_method_returns_correct_view_for_admin()
    {
        $response = $this->get('admin/companies');

        // todo add interact as admin
        $response->assertOk();
        $response->assertSee('grid-index-page');
    }

    /** @test */
    public function show_method_returns_correct_view_for_admin()
    {
        $company = create(Company::class);

        $response = $this->get('admin/companies/' . $company->id);

        // todo add interact as admin
        $response->assertOk();
        $response->assertSee('grid-view-page');
        // todo add company id to blade
//        $response->assertSee('id=' . $company->id);
    }

    // todo add other methods
    //get('admin/companies/get-all');
    //get('admin/companies/get-structure');
    //get('admin/companies/get-view-structure');
    //get('admin/companies/get-one/{id}');
    //get('admin/companies/create');
    //post('admin/companies/');
    //get('admin/companies/{id}/edit');
    //put('admin/companies/{id}');
    //delete('admin/companies/{id}');
}
