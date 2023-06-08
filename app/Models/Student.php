<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'univ_id',
        'father_name',
        'mother_name',
        'last_name',
        'birth_place',
        'gender',
        'field_number',
        'recruitment_division',
        'city',
        'address',
        'nationalty',
        "year_of_birth",
        "first_year"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(StudentCourse::class, 'student_id');
    }
    public function statuses(): HasMany
    {
        return $this->hasMany(StudentStatus::class, 'student_id');
    }
    public function year(): HasOne
    {
        return $this->hasOne(StudentYear::class, 'student_id');
    }
    public function format()
    {
        return (object)[
            "full_name" => $this->user->first_name . " " . $this->user->last_name,
            "birth_place" => $this->birth_place,
            "nationalty" => $this->nationalty,
            "year_of_birth" => $this->year_of_birth,
            "first_year" => $this->first_year,
            // "first_year" => $this->statuses->sortBy("created_at")->first()->year,
            // "last_year" => $this->statuses->where("last_status", true)->first()->year,

            "last_year" => "2021/2022",
        ];
    }
}
