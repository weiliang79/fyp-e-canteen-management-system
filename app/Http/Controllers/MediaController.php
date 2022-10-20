<?php

namespace App\Http\Controllers;

class MediaController extends Controller
{

    /**
     * Show the media manager.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('media_manager.index');
    }
}
