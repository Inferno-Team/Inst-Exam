<?php

namespace App\Http\Controllers;

use App\Http\Requests\sections\AddSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;

class SectionController extends Controller
{
    public function getAllSectionWithYears()
    {
        $section = Section::get()->map->format();

        return LocalResponse::returnData("sections", $section);
    }
    public function getAllSections()
    {
        return LocalResponse::returnData("sections", Section::all()); // select * from sections
    }
    public function addSection(AddSectionRequest $request)
    {
        $section = Section::create([
            'name' => $request->name,
        ]);
        return LocalResponse::returnData('section', $section, 'تمت إضافة القسم بنجاح');
    }

}
