<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;

class DateController extends Controller
{
    public function getDates()
    {
        $date =  Dates::first();
        return LocalResponse::returnData('date', $date);
    }
    public function setDates(Request $request)
    {
        $date = Dates::first();
        $kv = explode(':', $request[0]);

        // return response()->json($kv, 200);
        // $arr = json_encode($request->all());
        // return response()->json($arr, 200);
        if (isset($date)) {
            $date->update([
                $kv[0] => $kv[1]
            ]);
        } else {
            $date = Dates::create([
                $kv[0] => $kv[1]
            ]);
        }
        return LocalResponse::returnData('date', $date, 'تم الحفظ بنجاح');
    }
}
