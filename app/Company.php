<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $zip
 * @property string $city
 * @property string $street
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Company extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'zip', 'city', 'street', 'created_at', 'updated_at'];

    /**
     * @return array
     */
    public static function getCompaniesList()
    {
        $companiesArray = [];
        $allCompanies   = self::all();

        foreach ($allCompanies as $company) {
            $companiesArray[] = [
                'id'   => $company->id,
                'name' => $company->name,
            ];
        }

        return $companiesArray;
    }

}
