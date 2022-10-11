<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function landingIndex () {
        return view('admin.design.landing');
    }
}
