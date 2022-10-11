<?php

namespace App\Http\Controllers;

use App\Models\LandingDesign;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        $design = LandingDesign::first();
        return view('landing', compact('design'));
    }
}
