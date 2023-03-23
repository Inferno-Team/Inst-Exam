<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'password',
        'last_name',
        'phone_number',
        'type'
    ];
    public function moderatedYear(): HasOne
    {
        return $this->hasOne(YearModerator::class, 'moderator_id');
    }
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

    public function moderatorFormating()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'year' => $this->moderatedYear == null ? null : $this->moderatedYear->yearFormation(),
        ];
    }
    public function format()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
        ];
    }
}
