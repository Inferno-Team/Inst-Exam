<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'status',
        'section_year_id',
        'last_status',
        'year_date'
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
