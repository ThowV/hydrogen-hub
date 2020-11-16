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
        $u_1 = User::create(['email'=>"melchiorkokernoot@gmail.com", "password"=> Hash::make('melchior123'), "company_id"=>1, "first_name"=>"Melchior","last_name"=>"Kokernoot"]);
        $u_2 = User::create(['email'=>"t.l.visscher@outlook.com", "password"=> Hash::make('thomas123'), "company_id"=>2, "first_name"=>"Thomas","last_name"=>"Visscher"]);
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
    }

    public function createPermissions()
    {
        Permission::insert([
            ["name" => "request.allow", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "request.deny", "guard_name" => "web", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
        ]);
    }

    public function bindRolesToPermissions()
    {
        $super_admin = Role::findByName("Super Admin");
        $super_admin->givePermissionTo('request.allow');
        $super_admin->givePermissionTo('request.deny');

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
