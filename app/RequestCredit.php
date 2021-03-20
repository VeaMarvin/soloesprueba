<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCredit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'request_credits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_start',
        'date_end',
        'total',
        'order_id',
        'credit_id',
        'user_id',
        'payment',
        'current'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['order_concat'];

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
    public function getOrderConcatAttribute()
    {
        return "#{$this->order_id}";
    }

    public function getTotalConcatAttribute()
    {
        $total = number_format($this->total,2,'.',',');
        return "Q {$total}";
    }

    //Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
