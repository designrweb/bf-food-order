<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Services\ImageService;
use App\Setting;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class SettingCollection
 *
 * @package App\Http\Resources
 */
class CombinedSettingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function (Setting $item) {
                if ($item->setting_name == 'logo' && !empty($item->value)) {
                    return ImageService::decrypt($item->value);
                }

                return $item->value;
            })
        ];
    }
}
