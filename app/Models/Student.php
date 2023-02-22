<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'univ_id',
        'name',
        'father_name',
        'mother_name',
        'last_name',
        'birth_place',
        'gender',
        'field_number',
        'recruitment_division',
        'city',
        'address',
        'nationalty'
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'student_id');
    }
    public function statuses(): HasMany
    {
        return $this->hasMany(StudentStatus::class, 'student_id');
    }
    public function years(): HasMany
    {
        return $this->hasMany(StudentYear::class, 'student_id');
    }
}
