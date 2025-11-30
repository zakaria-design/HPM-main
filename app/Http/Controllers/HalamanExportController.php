<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanExportController extends Controller
{
    public function index()
    {
        return view('auth.export');
    }
}
