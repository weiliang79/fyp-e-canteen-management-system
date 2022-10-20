<?php

namespace App\Http\Controllers;

use App\Models\POSSetting;
use Illuminate\Http\Request;

class POSSettingController extends Controller
{

    /**
     * Show the POS settings.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $settings = POSSetting::all();
        return view('admin.pos_settings.index', compact('settings'));
    }

    /**
     * Update the POS settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $setting = POSSetting::firstOrCreate(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }

        return redirect()->route('admin.pos_settings')->with('swal-success', 'POS Settings save successful.');
    }
}
