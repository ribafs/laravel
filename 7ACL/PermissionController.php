<?php
namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{   

    public function permission()
    {   
                $super_permission = Permission::where('slug','all-all')->first();
                $admin_permission = Permission::where('slug', 'users-all')->first();
                $manager_permission = Permission::where('slug', 'clients-all')->first();
                $user_permission = Permission::where('slug', 'clients-index')->first();

                $super_group = Group::where('slug','super')->first();
                $admin_group = Group::where('slug', 'admin')->first();
                $manager_group = Group::where('slug', 'manager')->first();
                $user_group = Group::where('slug', 'user')->first();

                $super_group = new Group();
                $super_group->slug = 'super';
                $super_group->name = 'Super user';
                $super_group->save();
                $super_group->permissions()->attach($super_permission);

                $admin_group = new Group();
                $admin_group->slug = 'admin';
                $admin_group->name = 'Admin user';
                $admin_group->save();
                $admin_group->permissions()->attach($admin_permission);

                $manager_group = new Group();
                $manager_group->slug = 'manager';
                $manager_group->name = 'Manager user';
                $manager_group->save();
                $manager_group->permissions()->attach($manager_permission);

                $user_group = new Group();
                $user_group->slug = 'user';
                $user_group->name = 'User common';
                $user_group->save();
                $user_group->permissions()->attach($user_permission);

                $superUsers = new Permission();
                $superUsers->slug = 'all-all';
                $superUsers->name = 'All permissions';
                $superUsers->save();
                $superUsers->groups()->attach($super_group);

                $adminUsers = new Permission();
                $adminUsers->slug = 'users-all';
                $adminUsers->name = 'All permissions on users';
                $adminUsers->save();
                $adminUsers->groups()->attach($admin_group);

                $managerUsers = new Permission();
                $managerUsers->slug = 'clients-all';
                $managerUsers->name = 'All permissions on clients';
                $managerUsers->save();
                $managerUsers->groups()->attach($manager_group);

                // Adicionar outras permissões: 
                // clients-create, clients-edit, clients-show, clients-delete
                // users-create, users-edit, users-show, users-delete
                // groups-create, groups-edit, groups-show, groups-delete
                // permissions-create, permissions-edit, permissions-show, permissions-delete

                $userUsers = new Permission();
                $userUsers->slug = 'clients-index';
                $userUsers->name = 'Permission on clients index';
                $userUsers->save();
                $userUsers->groups()->attach($user_group);

                $super = new User();
                $super->name = 'Super user';
                $super->email = 'super@gmail.com';
                $super->password = bcrypt('123456');
                $super->save();
                $super->groups()->attach($super_group);
                $super->permissions()->attach($super_permission);

                $admin = new User();
                $admin->name = 'Admin user';
                $admin->email = 'admin@gmail.com';
                $admin->password = bcrypt('123456');
                $admin->save();
                $admin->groups()->attach($admin_group);
                $admin->permissions()->attach($admin_permission);

                $manager = new User();
                $manager->name = 'Manager user';
                $manager->email = 'manager@gmail.com';
                $manager->password = bcrypt('123456');
                $manager->save();
                $manager->groups()->attach($manager_group);
                $manager->permissions()->attach($manager_permission);

                $user = new User();
                $user->name = 'User common';
                $user->email = 'user@gmail.com';
                $user->password = bcrypt('123456');
                $user->save();
                $user->groups()->attach($user_group);
                $user->permissions()->attach($user_permission);

                return redirect()->back();
    }
}
