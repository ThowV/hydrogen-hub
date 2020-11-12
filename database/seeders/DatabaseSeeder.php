<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDayLog;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(['email'=>"melchiorkokernoot@gmail.com", "password"=>Hash::make('melchior123'), "company_id"=>1, "first_name"=>"Melchior","last_name"=>"kokernoot"]);
        \App\Models\User::factory(10)->create();
        Company::factory(10)->create();
        CompanyDayLog::factory(50)->create();
        Trade::factory(50)->create();

    }
}
