<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Year extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function terms(): HasMany
    {
        return $this->hasMany(YearTerm::class, 'year_id');
    }
    public function moderator(): HasOne
    {
        $m = $this->hasOne(YearSectionModetator::class, 'year_id');
        return $m == null ? null : $m;
    }
    public function format()
    {
        return [
            'moderator' => $this->moderator != null ? $this->moderator->moderatorFormat() : null,
            'name' => $this->name,
            'id' => $this->id,

        ];
    }
}
