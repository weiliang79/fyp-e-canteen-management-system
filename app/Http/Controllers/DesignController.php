<?php

namespace App\Http\Controllers;

use App\Models\GeneralDesign;
use App\Models\InformationPageDesign;
use App\Models\LandingDesign;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DesignController extends Controller
{

    /**
     * Show the general design settings.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function generalIndex()
    {
        $designs = GeneralDesign::all();
        return view('admin.design.general', compact('designs'));
    }

    /**
     * Update the general design settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function updateGeneral(Request $request)
    {
        $split = explode('.', parse_url($request->app_icon_path, PHP_URL_PATH));

        if($request->app_icon_path !== null) {
            if(end($split) !== 'ico'){
                throw ValidationException::withMessages([
                    'app_icon_path' => 'The file must be in .ico type.',
                ]);
            }

            $design = GeneralDesign::firstOrCreate(['name' => 'app_icon']);
            $design->path = substr(parse_url($request->app_icon_path, PHP_URL_PATH), 1);
            $design->save();
        } else {
            $design = GeneralDesign::firstOrCreate(['name' => 'app_icon']);
            $design->path = null;
            $design->save();
        }

        return redirect()->route('admin.design.general')->with('swal-success', 'General Design updated successful.');
    }

    /**
     * Show the landing design settings.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function landingIndex()
    {
        $design = LandingDesign::first();
        return view('admin.design.landing', compact('design'));
    }

    /**
     * Update the landing design settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function landingUpdate(Request $request)
    {
        $design = LandingDesign::firstOrCreate(['id' => 1]);
        $design->banner_path = $request->banner_path ? substr(parse_url($request->banner_path, PHP_URL_PATH), 1) : null;
        $design->slogan = $request->slogan;
        $design->description = $request->description;
        $design->save();

        return redirect()->route('admin.design.landing')->with('swal-success', 'Landing Page design updated successful.');
    }

    /**
     * Show the information design page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function informationIndex()
    {
        $infos = InformationPageDesign::all();
        return view('admin.design.information.index', compact('infos'));
    }

    /**
     * Show the information design create form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showInformationCreateForm()
    {
        $info = null;
        return view('admin.design.information.edit', compact('info'));
    }

    /**
     * Create the given information design.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeInformation(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        InformationPageDesign::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.design.information')->with('swal-success', 'Information Page created successful.');
    }

    /**
     * Show the given information design edit form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showInformationEditForm(Request $request)
    {
        $info = InformationPageDesign::find($request->id);
        return view('admin.design.information.edit', compact('info'));
    }

    /**
     * Update the given information design.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInformation(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        InformationPageDesign::find($request->id)->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.design.information')->with('swal-success', 'Information Page updated successful.');
    }

    public function deleteInformation(Request $request)
    {
        InformationPageDesign::destroy($request->id);
        return response()->json('Information page delete successful.');
    }
}
