<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'type'
    ];
    public function getToken()
    {
        $token = null;
        if (isset($this->remember_token))
            $token = $this->remember_token;
        else {
            $token = $this->createToken('authToken')->plainTextToken;
            $this->remember_token = $token;
            $this->save();
        }
        return $token;
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
