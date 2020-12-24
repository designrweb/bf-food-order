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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
