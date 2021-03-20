<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    //Constantes
    const APROVADO_SI = 'SI';
    const APROVADO_NO = 'NO';
    const EN_ESPERA = 'EN ESPERA';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'credits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'approved',
        'current',
        'discount_rate_id',
        'user_id',
        'employee_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['credit_concat'];

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
    public function getCreditConcatAttribute()
    {
        $credit = DiscountRate::find($this->discount_rate_id);
        return "{$credit->quantity} {$credit->day_month}";
    }

    public function getEmpleadoAttribute()
    {
        $employee = User::find($this->employee_id);
        !is_null($employee) ? $empleado = $employee->name : $empleado = '';

        return $empleado;
    }

    //Relaciones
    public function discount_rate()
    {
        return $this->belongsTo(DiscountRate::class);
    }
}
