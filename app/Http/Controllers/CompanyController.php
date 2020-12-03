<?php

namespace App\Http\Controllers;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.index');
    }

    public function portfolio()
    {
        return view('company.portfolio');
    }

    public function overview()
    {
        return view('company.overview');
    }
}
