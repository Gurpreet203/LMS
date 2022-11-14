<?php

namespace App\Http\Controllers;


class RouteController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function employee()
    {
        return view('user.employee');
    }
}
