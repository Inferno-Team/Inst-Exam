<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarkRevelRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        "no_financial_receipt",
        "date_financial_receipt",
        "student_id",
        "section_year_id"
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function section_year(): BelongsTo
    {
        return $this->belongsTo(SectionYear::class, 'section_year_id');
    }
    public static function format(MarkRevelRequest $request)
    {
        return (object)[
            "student" => $request->student->format(),
            "section_name" => (object)[
                "en" => $request->section_year->section->en_name,
                "ar" => $request->section_year->section->name,
            ],

        ];
    }
}
