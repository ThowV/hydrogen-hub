<?php

namespace App\Http\Controllers;


use App\Events\PermissionDenied;
use App\Models\Company;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.index');
    }

    public function portfolio()
    {
        $date = Carbon::now();
        $period = CarbonPeriod::create($date->copy()->startOfWeek(), $date->copy()->endOfWeek());
        foreach ($period as $periodPart) {
            $return[] = $periodPart->toFormattedDateString();
            //For now, let's imagine the demands look like this:
            $demands[] = $looped_demands = rand(0,100);
            $produced [] = $looped_produced = rand(0,25);
            $stored [] = $looped_stored = rand(10,50);
            $unsettled [] = ($looped_demands - ($looped_stored + $looped_produced)) ;
        }
        //TODO get the demands for the company


        return view('company.portfolio')->withPeriod($return)->withDemands($demands)->withProduced($produced)->withStored($stored)->withUnsettled($unsettled);
    }

    public function overview()
    {
        return view('company.overview');
    }

    public function destroy(Company $company)
    {
        if (!auth()->user()->can('companies.delete')) {
            event(new PermissionDenied());
            return back();
        }

        $company->delete();
        return back();
    }
}
