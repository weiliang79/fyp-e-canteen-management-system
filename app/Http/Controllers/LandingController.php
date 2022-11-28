<?php

namespace App\Http\Controllers;

use App\Models\InformationPageDesign;
use App\Models\LandingDesign;
use Illuminate\Http\Request;

class LandingController extends Controller
{

    /**
     * Show the landing page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $design = LandingDesign::first();
        return view('landing', compact('design'));
    }

    /**
     * Show the given information page.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function information(Request $request)
    {
        $info = InformationPageDesign::find($request->id);
        if($info === null){
            return redirect()->route('landing');
        }
        return view('information', compact('info'));
    }
}
