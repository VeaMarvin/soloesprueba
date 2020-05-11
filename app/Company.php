<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slogan',
        'vision',
        'mision',
        'logotipo',
        'ubication_x',
        'ubication_y',
        'facebook',
        'twitter',
        'instagram',
        'page',
        'current',
        'system'
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
    public function setLogotipoAttribute($value)
    {
        $this->attributes['logotipo'] = "data:image/jpeg;base64,{$value}";
    }

    //Relaciones
    public function phones()
    {
        return $this->hasMany(CompanyPhone::class);
    }

    public function addresses()
    {
        return $this->hasMany(CompanyAddress::class);
    }
}
