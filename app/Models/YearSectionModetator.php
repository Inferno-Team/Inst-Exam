<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YearSectionModetator extends Model
{
    use HasFactory;
    protected $fillable = [
        'moderator_id',
        'section_id',
        'year_id',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, "year_id");
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }
    public function moderatorFormat()
    {
        return $this->moderator;
    }
    public function yearFormation()
    {
        $year = $this->year;
        Carbon::setLocale('ar');
        return [
            'year_id' => $this->year_id,
            'year_name' => $year->name,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
