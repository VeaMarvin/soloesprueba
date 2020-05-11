<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'product',
        'price',
        'discount',
        'subtotal',
        'order_id',
        'product_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['string_discount'];

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
    public function getStringDiscountAttribute()
    {
        return "{$this->discount}%";
    }

    public function getStringSubTotalAttribute()
    {
        $subtotal = number_format($this->subtotal,2,'.',',');
        return "Q {$subtotal}";
    }

    //Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
