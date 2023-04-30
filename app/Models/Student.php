<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'univ_id',
        'father_name',
        'mother_name',
        'user_id',
        'birth_place',
        'gender',
        'field_number',
        'recruitment_division',
        'city',
        'address',
        'nationalty'
    ];

    public function user(): HasOne{
        return $this->hasOne(User::class,'user_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'student_id');
    }
    public function statuses(): HasMany
    {
        return $this->hasMany(StudentStatus::class, 'student_id');
    }
    public function year(): HasOne
    {
        return $this->hasOne(StudentYear::class, 'student_id');
    }
}
