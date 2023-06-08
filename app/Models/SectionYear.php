<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function format()
    {
        return [
            'year' => $this->year->format(),
            'section' => $this->section_id
        ];
    }
}
