<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birth',
        'gender',
        'role',
        'pp',
        'address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $attributes = [
        'pp' => '',
        'role' => 'admin',
        'status' => 'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function generateVerificationToken()
    // {
    //     $this->verification_token = Str::random(40);
    //     $this->save();

    //     return $this->verification_token;
    // }
}
