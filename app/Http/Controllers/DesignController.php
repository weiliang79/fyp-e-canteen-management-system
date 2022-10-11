<?php

namespace App\Http\Controllers;

use App\Models\LandingDesign;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function landingIndex () {
        $design = LandingDesign::first();
        return view('admin.design.landing', compact('design'));
    }

    public function landingUpdate (Request $request) {

        $design = LandingDesign::firstOrCreate(['id' => 1]);
        $design->banner_path = $request->banner_path ? substr(parse_url($request->banner_path, PHP_URL_PATH), 1) : null;
        $design->slogan = $request->slogan;
        $design->description = $request->description;
        $design->save();

        return redirect()->route('admin.design.landing')->with('swal-success', 'Landing Page design updated successful.');

    }
}
