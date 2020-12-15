<?php


namespace App\Actions;


use App\Models\User;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

class BindRoleToUserAction
{
    public function execute($roleName, $user_id)
    {

        //Check if role exists
        if (!Role::whereName($roleName)->get()) {
            throw new RoleDoesNotExist();
        }

        $user = User::findOrFail($user_id);

        if (is_array($roleName)) {
            foreach ($roleName as $singleRoleName) {
                if ($singleRoleName != "Super Admin" && false != $singleRoleName) {
                    $user->assignRole($singleRoleName);
                }
            }
        } else {
            if ($roleName != "Super Admin") {
                $user->assignRole($roleName);

            }
        }

        $user->save();
    }
}
