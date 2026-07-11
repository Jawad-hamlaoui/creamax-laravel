<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function mentionsLegales()
    {
        return view('pages.mentions-legales');
    }
}
