<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $appends = ['students_count', 'first_time_count', 'failed_count', 'sucessed_count'];
    protected $fillable = ['name', 'section_year_term_id', 'type'];

    public function sectionYearTerm(): BelongsTo
    {
        return $this->belongsTo(SectionYearTerm::class, 'section_year_term_id');
    }
    public function students(): HasMany
    {
        return $this->hasMany(StudentCourse::class, 'course_id');
    }
    public function studentsCount(): Attribute
    {
        return new Attribute(
            get: fn () => count($this->students) //- $this->sucessed_count
        );
    }
    public function sucessedCount(): Attribute
    {
        return new Attribute(
            get: function () {
                $st = $this->students->where('status', 'ناجح');
                return count($st);
            }
        );
    }
    public function failedCount(): Attribute
    {
        return new Attribute(
            get: function () {
                $st = $this->students->where('status', 'راسب');
                return count($st);
            }
        );
    }
    public function firstTimeCount(): Attribute
    {
        return new Attribute(
            get: function () {
                $st = $this->students->where('status',  'اول مرة');
                return count($st);
            }
        );
    }
}
