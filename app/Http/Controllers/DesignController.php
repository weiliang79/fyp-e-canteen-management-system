<?php

namespace App\Http\Controllers;

use App\Models\InformationPageDesign;
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

    public function informationIndex () {
        $infos = InformationPageDesign::all();

        return view('admin.design.information.index', compact('infos'));
    }

    public function showInformationCreateForm () {
        $info = null;
        return view('admin.design.information.edit', compact('info'));
    }

    public function storeInformation (Request $request) {
        
        $request->validate([
            'title' => 'required',
        ]);

        InformationPageDesign::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        
        return redirect()->route('admin.design.information')->with('swal-success', 'Information Page created successful.');
    }

    public function showInformationEditForm (Request $request) {
        $info = InformationPageDesign::find($request->id);

        return view('admin.design.information.edit', compact('info'));
    }

    public function updateInformation (Request $request) {
        $request->validate([
            'title' => 'required',
        ]);

        InformationPageDesign::find($request->id)->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.design.information')->with('swal-success', 'Information Page updated successful.');
    }
}
