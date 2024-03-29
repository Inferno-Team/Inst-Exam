<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function PHPUnit\Framework\isNan;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name',"en_name"];
    public function sectionYearTerm(): HasMany
    {
        return $this->hasMany(SectionYearTerm::class, 'section_id');
    }
    public function sectionYear(): HasMany
    {
        return $this->hasMany(SectionYear::class, 'section_id')->with('year');
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
                            'id' => $student->id,
                            'first_name' => $student->user->first_name,
                            'univ_id' => $student->univ_id,
                            'father_name' => $student->father_name,
                            'mother_name' => $student->mother_name,
                            'last_name' => $student->last_name,
                            // 'phone_number' => $student->user->phone_number,
                            // 'gender' => $student->gender,
                        ];
                    })
                ];
            })
        ];
    }
}
