<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * Show demo dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('demo-dashboard');
    }
}