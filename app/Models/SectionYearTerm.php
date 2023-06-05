<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SectionYearTerm extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'year_term_id'
    ];
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function yearTerm(): BelongsTo
    {
        return $this->belongsTo(YearTerm::class, 'year_term_id');
    }
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'section_year_term_id');
    }
    public function studentStatus(): HasMany
    {
        return $this->hasMany(StudentStatus::class, 'section_year_term_id');
    }
    public function studentYears(): HasMany
    {
        return $this->hasMany(studentYears::class, 'section_year_term_id');
    }
    public function format()
    {
        return (object)[
            "section_name" => $this->section->name,
            "year" => $this->yearTerm->year->name,
            "term" => $this->yearTerm->name
        ];
    }
}
