<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMenuCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_menu_category';

    /**
     * @var array
     */
    protected $fillable = ['menu_category_id', 'company_id'];
}
