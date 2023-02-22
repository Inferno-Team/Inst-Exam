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
}
