<?php

namespace App\Repositories;

use App\Http\Resources\CombinedSettingCollection;
use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingResource;
use App\Services\ImageService;
use App\Setting;
use App\QueryBuilders\SettingSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SettingRepository implements RepositoryInterface
{
    /** @var Setting */
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * @return SettingCollection
     */
    public function all()
    {
        return new SettingCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SettingSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @return CombinedSettingCollection
     */
    public function allCombined()
    {
        return new CombinedSettingCollection(auth()->user()->userCompany->company->settings->keyBy('setting_name'));
    }

    /**
     * @param array $data
     * @return SettingResource
     */
    public function add(array $data)
    {
        return new SettingResource($this->model->create($data));
    }

    /**
     * @param $themeColor
     * @return bool
     */
    public function updateThemeColor($themeColor = null)
    {
        $settings = auth()->user()->userCompany->company->settings();

        $settings->updateOrCreate([
            'setting_name' => 'theme_color',
            'visible_name' => 'Theme Color',
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
        $settings = auth()->user()->userCompany->company->settings();

        $settings->updateOrCreate([
            'setting_name' => 'sidebar_theme_color',
            'visible_name' => 'Sidebar Theme Color',
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
        $settings = auth()->user()->userCompany->company->settings();

        $settings->updateOrCreate([
            'setting_name' => 'email',
            'visible_name' => 'Email',
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
        $settings = auth()->user()->userCompany->company->settings();

        $settings->updateOrCreate([
            'setting_name' => 'logo',
            'visible_name' => 'Logo',
        ], [
            'value' => !empty($logo) ? ImageService::storeEncrypt($logo) : '',
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function removeImage()
    {
        $settings = auth()->user()->userCompany->company->settings();

        $settings->where('setting_name', 'logo')->update([
            'value' => '',
        ]);

        return true;
    }

    /**
     * @param array $data
     * @param       $id
     * @return SettingResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new SettingResource($model);
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
     * @param       $id
     * @return SettingResource
     */
    public function get($id)
    {
        return new SettingResource($this->model->findOrFail($id));
    }
}
