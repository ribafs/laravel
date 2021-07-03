<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        // Super Users - all in all
        $super = new Group();
        $super->name = 'Super';
        $super->slug = 'super';
        $super->save();

        // Super Admin - all in users
        $admin = new Group();
        $admin->name = 'Admin';
        $admin->slug = 'admin';
        $admin->save();

        // Super Manager - all in clients and products
        $manager = new Group();
        $manager->name = 'Manager';
        $manager->slug = 'manager';
        $manager->save();

        // User - only index and show from clients
        $user = new Group();
        $user->name = 'User';
        $user->slug = 'user';
        $user->save();
    }
}
