<?php

namespace Tests\Feature\Api\Web\InteractsWithPages;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
use Tests\CreatesApplication;

class AdminSidebarLinksTest extends BaseTestCase
{
    use CreatesApplication, WithoutMiddleware;

    public $baseUrl = 'http://localhost';

    /** @test */
    public function locations_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Locations');
        $this->seePageIs('/admin/locations');
    }

    /** @test */
    public function groups_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Groups');
        $this->seePageIs('/admin/location-groups');
    }

    /** @test */
    public function administrators_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Administrators');
        $this->seePageIs('/admin/users');
    }

    /** @test */
    public function consumers_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Consumers');
        $this->seePageIs('/admin/consumers');
    }

    /** @test */
    public function bank_transactions_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Bank Transactions');
        $this->seePageIs('/admin/payments');
    }

    /** @test */
    public function meal_orders_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Meal Orders');
        $this->seePageIs('/admin/payments/meal-orders');
    }

    /** @test */
    public function add_payments_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Add Payments');
        $this->seePageIs('/admin/payments/create');
    }

    /** @test */
    public function payment_dumps_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Payment Dumps');
        $this->seePageIs('/admin/payment-dumps');
    }

    /** @test */
    public function subsidization_organizations_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Organizations');
        $this->seePageIs('/admin/subsidization-organizations');
    }

    /** @test */
    public function subsidization_rules_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Rules');
        $this->seePageIs('/admin/subsidization-rules');
    }

    /** @test */
    public function menu_categories_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Menu Categories');
        $this->seePageIs('/admin/menu-categories');
    }

    /** @test */
    public function menu_items_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Menu Items');
        $this->seePageIs('/admin/menu-items');
    }

    /** @test */
    public function food_orders_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Food Orders');
        $this->seePageIs('/admin/orders');
    }

    /** @test */
    public function voucher_limits_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Voucher Limits');
        $this->seePageIs('/admin/voucher-limits');
    }

    /** @test */
    public function vacations_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Vacations');
        $this->seePageIs('/admin/vacations');
    }

    /** @test */
    public function settings_link_works_correctly()
    {
        $this->goToAdminPage();

        $this->click('Settings');
        $this->seePageIs('/admin/settings/combined');
    }

    protected function goToAdminPage()
    {
        $this->visit('/admin');
        $this->see('Admin part');
    }
}
