<?php

namespace App\Http\Controllers;

class OverviewController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}
