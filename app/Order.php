<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //Constantes
    const PEDIDO = 'PEDIDO';
    const PROCESO = 'PROCESO';
    const ENTREGADO = 'ENTREGADO';
    const ANULADO = 'ANULADO';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nit',
        'name_complete',
        'email',
        'direction',
        'phone',
        'status',
        'observation',
        'total',
        'user_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['user'];

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
    public function getUserAttribute()
    {
        return User::find($this->user_id)->name;
    }

    public function getStringTotalAttribute()
    {
        $total = number_format($this->total,2,'.',',');
        return "Q {$total}";
    }

    public function getStringFechaAttribute()
    {
        return date('d/m/Y', strtotime($this->created_at));
    }

    public function getStringColorAttribute()
    {
        switch ($this->status) {
            case Order::PEDIDO:
                $color = "primary";
                break;
            case Order::PROCESO:
                $color = "success";
                break;
            case Order::ENTREGADO:
                $color = "warning";
                break;
            case Order::ANULADO:
                $color = "danger";
                break;
            default:
                $color = "default";
                break;
        }

        return $color;
    }

    //Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
