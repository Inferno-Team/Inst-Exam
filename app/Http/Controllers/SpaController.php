<?php

namespace App\Http\Controllers;

use App\Jobs\CheckCurrentTime;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        $this->dispatch(new CheckCurrentTime());
        return view('spa');
    }
}
