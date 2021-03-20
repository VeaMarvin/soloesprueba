<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'avatar',
        'current',
        'system',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name_complete'];

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
    public function getNameCompleteAttribute()
    {
        return $this->nickname === null ? $this->name : $this->nickname;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = "data:image/jpeg;base64,{$value}";
    }

    //Relaciones
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function request_credits()
    {
        return $this->hasMany(RequestCredit::class);
    }
}
