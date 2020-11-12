<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDayLog;
use App\Models\Trade;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        Company::factory(10)->create();
        CompanyDayLog::factory(50)->create();
        Trade::factory(50)->create();

    }
}
