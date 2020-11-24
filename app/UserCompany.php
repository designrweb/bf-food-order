<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_company';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'company_id'];
}
