<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCourse extends Model
{
    use HasFactory;
    protected $appends = ['this_year_ava', 'this_year_ava_mark1', 'this_year_ava_mark2', 'full_mark'];
    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'with_help',
        'mark1',
        'mark2',
        'year'
    ];
    public function fullMark(): Attribute
    {
        return new Attribute(
            get: fn () => $this->mark1 && $this->mark2 ? $this->mark1 + $this->mark2 : 0,
        );
    }
    public function thisYearAva(): Attribute
    {
        return new Attribute(
            get: function () {
                $date = Dates::first();
                if (!isset($date)) return true;
                if ($this->year == $date->year) return true;
                return false;
            }
        );
    }
    public function thisYearAvaMark1(): Attribute
    {
        return new Attribute(
            get: function () {
                $ava = $this->this_year_ava;
                return $ava && $this->mark1 === null;
            }
        );
    }
    public function thisYearAvaMark2(): Attribute
    {
        return new Attribute(
            get: function () {
                $ava = $this->this_year_ava;
                return $ava && $this->mark2 === null;
            }
        );
    }
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
