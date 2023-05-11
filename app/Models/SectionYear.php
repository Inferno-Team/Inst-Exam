<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SectionYear extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'year_id',
    ];
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_years', 'section_year_id', 'student_id', null, 'id')
            ->with('user');
    }
    public function year(): HasOne
    {
        return $this->hasOne(Year::class, 'id');
    }
    public function format()
    {
        return [
            'year' => $this->year->format(),
            'section' => $this->section_id
        ];
    }
}
