<?php

namespace App\Http\Controllers;

use App\Events\PermissionDenied;
use App\Models\Company;
use Illuminate\Http\Request;

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

    public function destroy(Company $company)
    {
        if(!auth()->user()->can('companies.delete')){
            event(new PermissionDenied());
            return back();
        }

        $company->delete();
        return back();
    }
}
