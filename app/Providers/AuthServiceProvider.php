<?php

namespace App\Providers;

use App\Company;
use App\Consumer;
use App\ConsumerAutoOrder;
use App\ConsumerQrCode;
use App\ConsumerSubsidization;
use App\Location;
use App\LocationGroup;
use App\MenuCategory;
use App\MenuItem;
use App\Order;
use App\Payment;
use App\Policies\CompanyPolicy;
use App\Policies\ConsumerAutoOrderPolicy;
use App\Policies\ConsumerQrCodePolicy;
use App\Policies\ConsumerSubsidizationPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use App\Policies\VoucherLimitPolicy;
use App\Policies\VacationPolicy;
use App\Policies\VacationLocationGroupPolicy;
use App\Policies\SubsidizedMenuCategoriesPolicy;
use App\Policies\SubsidizationRulePolicy;
use App\Policies\SubsidizationOrganizationPolicy;
use App\Policies\SettingPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\MenuCategoryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\LocationGroupPolicy;
use App\Policies\ConsumerPolicy;
use App\Setting;
use App\SubsidizationOrganization;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use App\User;
use App\Vacation;
use App\VacationLocationGroup;
use App\VoucherLimit;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class                      => UserPolicy::class,
        Order::class                     => OrderPolicy::class,
        ConsumerSubsidization::class     => ConsumerSubsidizationPolicy::class,
        ConsumerQrCode::class            => ConsumerQrCodePolicy::class,
        ConsumerAutoOrder::class         => ConsumerAutoOrderPolicy::class,
        Company::class                   => CompanyPolicy::class,
        VoucherLimit::class              => VoucherLimitPolicy::class,
        Vacation::class                  => VacationPolicy::class,
        VacationLocationGroup::class     => VacationLocationGroupPolicy::class,
        SubsidizedMenuCategories::class  => SubsidizedMenuCategoriesPolicy::class,
        SubsidizationRule::class         => SubsidizationRulePolicy::class,
        SubsidizationOrganization::class => SubsidizationOrganizationPolicy::class,
        Setting::class                   => SettingPolicy::class,
        Payment::class                   => PaymentPolicy::class,
        MenuItem::class                  => MenuItemPolicy::class,
        MenuCategory::class              => MenuCategoryPolicy::class,
        Location::class                  => LocationPolicy::class,
        LocationGroup::class             => LocationGroupPolicy::class,
        Consumer::class                  => ConsumerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerMenuGates();
    }

    /**
     * Register gates for menu items visibilities
     */
    private function registerMenuGates()
    {
        Gate::define('menu-' . class_basename(User::class), [UserPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Order::class), [OrderPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(ConsumerSubsidization::class), [ConsumerSubsidizationPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(ConsumerQrCode::class), [ConsumerQrCodePolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(ConsumerAutoOrder::class), [ConsumerAutoOrderPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Company::class), [CompanyPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(VoucherLimit::class), [VoucherLimitPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Vacation::class), [VacationPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(VacationLocationGroup::class), [VacationLocationGroupPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(SubsidizedMenuCategories::class), [SubsidizedMenuCategoriesPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(SubsidizationRule::class), [SubsidizationRulePolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(SubsidizationOrganization::class), [SubsidizationOrganizationPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Setting::class), [SettingPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(MenuItem::class), [MenuItemPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Payment::class), [PaymentPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(MenuCategory::class), [MenuCategoryPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Location::class), [LocationPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(LocationGroup::class), [LocationGroupPolicy::class, 'viewAny']);
        Gate::define('menu-' . class_basename(Consumer::class), [ConsumerPolicy::class, 'viewAny']);
        Gate::define('menu-Profile', [UserPolicy::class, 'viewProfile']);
    }
}
