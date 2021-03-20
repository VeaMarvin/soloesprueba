<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountRate extends Model
{
    //Constantes
    const DIA = 'DIAS';
    const MES = 'MESES';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discount_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'day_month'
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

    //Mutadores
    public function getNameAttribute()
    {
        return "{$this->quantity} - {$this->day_month}";
    }
}
