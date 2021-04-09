<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public const Roles = [
        1 => 'Admin',
        2 => 'Moderatör',
        3 => 'Kütüphane Yöneticisi',
        4 => 'Kullanıcı'
    ];

    /**
     * returns the id of a given role
     *
     * @param string $role  user's role
     * @return int roleID
     */
    public static function getRoleID($role)
    {
        return array_search($role, self::Roles);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'tcno',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rent(){
        return $this->belongsToMany(Rents::class)->get();
    }
}
