<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyPhone extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business_phones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'company_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s'
    ];
}
