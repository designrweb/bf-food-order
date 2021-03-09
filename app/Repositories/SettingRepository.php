<?php

namespace App\Repositories;

use App\Components\ImageComponent;
use App\Setting;
use App\QueryBuilders\SettingSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SettingRepository implements RepositoryInterface
{
    /** @var Setting */
    protected $model;

    /**
     * SettingRepository constructor.
     *
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SettingSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @return mixed
     */
    public function allCombined()
    {
        return auth()->user()->company->settings->keyBy('setting_name');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $themeColor
     * @return bool
     */
    public function updateThemeColor($themeColor = null)
    {
        Setting::updateOrCreate([
            'setting_name' => 'theme_color',
            'visible_name' => 'Theme Color',
            'company_id'   => auth()->user()->company_id,
        ], [
            'value' => $themeColor
        ]);

        return true;
    }

    /**
     * @param $sidebarThemeColor
     * @return bool
     */
    public function updateSidebarColor($sidebarThemeColor = null)
    {
        Setting::updateOrCreate([
            'setting_name' => 'sidebar_theme_color',
            'visible_name' => 'Sidebar Theme Color',
            'company_id'   => auth()->user()->company_id,
        ], [
            'value' => $sidebarThemeColor
        ]);

        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    public function updateEmail($email = null)
    {
        Setting::updateOrCreate([
            'setting_name' => 'email',
            'visible_name' => 'Email',
            'company_id'   => auth()->user()->company_id,
        ], [
            'value' => $email,
        ]);

        return true;
    }

    /**
     * @param null $logo
     * @return bool
     */
    public function updateLogo($logo = null)
    {
        Setting::updateOrCreate([
            'setting_name' => 'logo',
            'visible_name' => 'Logo',
            'company_id'   => auth()->user()->company_id,
        ], [
            'value' => !empty($logo) ? ImageComponent::storeInFile($logo, $this->model::IMAGE_FOLDER) : '',
        ]);

        return true;
    }

    /**
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get setting email
     *
     * @return Setting|null
     */
    public function getSubsidizationSupportEmail()
    {
        return auth()->user()->company->settings->where('setting_name', '=', 'subsidization_support_email')->first();
    }
}
