<?php

namespace App\Http\Controllers;

use App\Models\POSSetting;
use Illuminate\Http\Request;

class POSSettingController extends Controller
{
    public function index(){
        $settings = POSSetting::all();

        //dd($settings);

        return view('admin.pos_settings.index', compact('settings'));
    }

    public function store(Request $request){
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $setting = POSSetting::firstOrCreate(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }

        return redirect()->route('admin.pos_settings')->with('swal-success', 'POS Settings save successful.');
    }
}
