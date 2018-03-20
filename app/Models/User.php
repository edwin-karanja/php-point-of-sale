<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasPermissionsTrait;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Check if the current user is within the administrators array.
     * @return bool
     */
    public function isAdmin()
    {
        return in_array($this->email, config('pos.admins'));
    }

    /**
     * Check that the current user is not ad administrator.
     * @return bool
     */
    public function isNotAdmin()
    {
        return ! $this->isAdmin();
    }
}
