<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDayLog;
use App\Models\RegistrationRequest;
use App\Models\Trade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $u_1 = User::create(['email' => "melchiorkokernoot@gmail.com", "password" => Hash::make('melchior123'), "company_id" => rand(1,10), "first_name" => "Melchior", "last_name" => "kokernoot"]);
        $u_2 = User::create(['email'=>"t.l.visscher@outlook.com", "password"=> Hash::make('thomas123'), "company_id" => rand(1,10), "first_name"=>"Thomas","last_name"=>"Visscher"]);
        $u_3 = User::create(['email' => "martijnjongman9@gmail.com", "password" => Hash::make('martijn123'), "company_id" => rand(1,10), "first_name" => "Martijn", "last_name" => "Jongman"]);

        \App\Models\User::factory(25)->create();
        Company::factory(10)->create();
        CompanyDayLog::factory(50)->create();
        Trade::factory(50)->create();
        RegistrationRequest::factory(10)->create();

        $this->createPermissions();
        $this->createRoles();
        $this->bindRolesToPermissions();


        $u_1->assignRole('Super Admin');
        $u_2->assignRole('Super Admin');
        $u_3->assignRole('Super Admin');
    }

    public function createPermissions()
    {
        Permission::insert([
            ["name" => "request.allow", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "request.deny", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "companies.delete", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "companies.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            ["name" => "listing.create", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "listing.buy", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "listing.sellto", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "listings.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "listing.delete", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "listing.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.portfolio.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.portfolio.write", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.users.create", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.users.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.users.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.users.delete", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.fund.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.produced.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.stored.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "company.demand.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

        ]);
    }

    public function bindRolesToPermissions()
    {

    }

    public function createRoles()
    {
        Role::insert([
            ["name" => "Super Admin", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "Admin", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "Portfolio Manager", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "Trader", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "Analyst", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "Spectator", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
        ]);
    }
}
