<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Super Users - all in all
        $super = new User();
        $super->name = 'Super user';
        $super->email = 'super@gmail.com';
        $super->password = bcrypt('123456');
        $super->save();

        // Super Admin - all in users
        $admin = new User();
        $admin->name = 'Admin user';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->save();

        // Super Manager - all in clients and products
        $manager = new User();
        $manager->name = 'Manager user';
        $manager->email = 'manager@gmail.com';
        $manager->password = bcrypt('123456');
        $manager->save();

        // User - only index and show from clients
        $user = new User();
        $user->name = 'User Common';
        $user->email = 'user@gmail.com';
        $user->password = bcrypt('123456');
        $user->save();

        // Test - only login
        $user = new User();
        $user->name = 'Test user only login';
        $user->email = 'test@gmail.com';
        $user->password = bcrypt('123456');
        $user->save();
    }
}
