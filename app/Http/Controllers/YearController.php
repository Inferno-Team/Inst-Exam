<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use App\Models\Year;

class YearController extends Controller
{
    public function getYears()
    {
        $years = Year::get()->map->format();
        return LocalResponse::returnData('years', $years);
    }
}
