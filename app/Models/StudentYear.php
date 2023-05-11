<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentYear extends Model
{
    use HasFactory;
    protected $fillable  = [
        'student_id',
        'section_year_id'
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function sectionYear(): BelongsTo
    {
        return $this->belongsTo(SectionYear::class, 'section_year_id');
    }
}
