<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function sectionYearTerm(): HasMany
    {
        return $this->hasMany(SectionYearTerm::class, 'section_id');
    }
    public function sectionYear(): HasMany
    {
        return $this->hasMany(SectionYear::class, 'section_id');
    }
    public function format()
    {
        return (object)[
            'name' => $this->name,
            'id' => $this->id,
            'years' => $this->sectionYear->map(function ($section_year) {
                return (object)[
                    "id" => $section_year->year->id,
                    "name" => $section_year->year->name,
                    'students' => $section_year->students->map(function ($student) {
                        return (object)[
                            'ت' => $student->id,
                            'الاسم' => $student->user->first_name,
                            'اسم الأب' => $student->father_name,
                            'اسم الأم' => $student->mother_name,
                            'الكنية' => $student->last_name,
                            // 'phone_number' => $student->user->phone_number,
                            // 'gender' => $student->gender,
                        ];
                    })
                ];
            })
        ];
    }
}
