<?php

namespace App\Repositories;

use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Location;
use App\QueryBuilders\LocationSearch;
use App\Services\ImageService;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class LocationRepository implements RepositoryInterface
{
    /** @var Location */
    protected $model;

    /**
     * LocationRepository constructor.
     *
     * @param Location $model
     */
    public function __construct(Location $model)
    {
        $this->model = $model;
    }

    /**
     * @return LocationCollection
     */
    public function all()
    {
        return new LocationCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                LocationSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return LocationResource
     */
    public function add(array $data)
    {
        if ($data['image_name']) {
            $data['image_name'] = ImageService::storeInFile($data['image_name'], Location::IMAGE_FOLDER);
        }

        return new LocationResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return LocationResource
     */
    public function update(array $data, $id)
    {
        if (!empty($data['image_name'])) {
            $data['image_name'] = ImageService::storeInFile($data['image_name'], Location::IMAGE_FOLDER);
        }

        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new LocationResource($model);
    }

    /**
     * @param array $data
     * @param       $id
     */
    public function updateImage(array $data, $id)
    {
        $model = $this->model->findOrFail($id);

        $model->update([
            'image_name' => ImageService::storeInFile($data['image_name'], Location::IMAGE_FOLDER)
        ]);

        return true;
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
     * @return LocationResource
     */
    public function get($id)
    {
        return new LocationResource($this->model->findOrFail($id));
    }

    /**
     * @return array
     */
    public function getList()
    {
        $locationsArray = [];
        $allLocations   = $this->model::all();

        foreach ($allLocations as $location) {
            $locationsArray[] = [
                'id'   => $location->id,
                'name' => $location->name,
            ];
        }

        return $locationsArray;
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeImage($id)
    {
        $model = $this->model->findOrFail($id);

        ImageService::removeImage($model->imageurl, Location::IMAGE_FOLDER);

        $model->update([
            'image_name' => null
        ]);

        return true;
    }
}
