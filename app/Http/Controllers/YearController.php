<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use App\Models\SectionYear;
use App\Models\Year;
use App\Models\YearSectionModetator;

class YearController extends Controller
{
    public function getYears($sectionId)
    {
        // $years = Year::whereHas('moderator', function ($query) use ($sectionId) {
        //     $query->where('section_id', $sectionId);
        // })->get()->map->format();
        // $years =SectionYear::where('section_id',$sectionId)->get()->map->format();
        $years = Year::with(['moderator' => function ($query) use ($sectionId) {
            $query->where('section_id', $sectionId);
        }], 'moderator.moderator')->get()->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'moderator' => $item->moderator != null ? $item->moderator->moderatorFormat() : null,
                'name' => $item->name
            ];
        });
        return LocalResponse::returnData('years', $years);
    }
}
