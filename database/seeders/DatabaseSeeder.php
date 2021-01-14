<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDayLog;
use App\Models\CompanyDayLogSection;
use App\Models\CompanyHydrogenInterest;
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
        $users[] = User::create(['email' => "melchiorkokernoot@gmail.com", "password" => Hash::make('melchior123'), "company_id" => 1, "first_name" => "Melchior", "last_name" => "kokernoot"]);
        $users[] = User::create(['email'=>"t.l.visscher@outlook.com", "password"=> Hash::make('thomas123'), "company_id" => 2, "first_name"=>"Thomas","last_name"=>"Visscher"]);
        $users[] = User::create(['email' => "martijnjongman9@gmail.com", "password" => Hash::make('martijn123'), "company_id" => rand(1,2), "first_name" => "Martijn", "last_name" => "Jongman"]);
        $users[] = User::create(['email' => "h.zwetsloot@groningen-seaports.com", "password" => Hash::make('Henk123!@#'), "company_id" => rand(1,2), "first_name" => "Henk", "last_name" => "Zwetsloot"]);
        $users[] = User::create(['email' => "rdewolf300@gmail.com", "password" => Hash::make('Rob123!@#'), "company_id" => rand(1,2), "first_name" => "Rob", "last_name" => "de Wolf"]);
        $users[] = User::create(['email' => "michiel@energy21.com", "password" => Hash::make('Michiel123!@#'), "company_id" => rand(1,2), "first_name" => "Michiel", "last_name" => "Dorresteijn"]);

        User::factory(25)->create();
        Company::factory(10)->create();
        CompanyDayLog::factory(100)->create();
        CompanyDayLogSection::factory(200)->create();
        Trade::factory(50)->create();
        RegistrationRequest::factory(10)->create();

        $this->createCompanyInterest([1, 2]);
        $this->createPermissions();
        $this->createRoles();
        $this->bindRolesToPermissions();

        foreach ($users as $user) {
            $user->assignRole('Super Admin');
        }
    }

    public function createCompanyInterest($company_ids)
    {
        foreach ($company_ids as $company_id) {
            foreach (['green', 'blue', 'grey'] as $interest) {
                $companyHydrogenInterest = new CompanyHydrogenInterest();
                $companyHydrogenInterest->fill(['company_id' => $company_id, 'interest' => $interest]);
                $companyHydrogenInterest->save();
            }
        }
    }

    public function createPermissions()
    {
        Permission::insert([
            ["name" => "request.allow", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "request.deny", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "companies.delete", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "companies.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "users.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "users.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "users.delete", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "users.create", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "employees.delete", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "employees.create", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "employees.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "employees.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "employees.roles.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "employees.roles.read", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

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
            ["name" => "company.settings.update", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

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
