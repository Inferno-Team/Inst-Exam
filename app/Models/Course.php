<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'section_year_term_id'];

    public function sectionYearTerm():BelongsTo{
        return $this->belongsTo(SectionYearTerm::class,'section_year_term_id');
    }
}
