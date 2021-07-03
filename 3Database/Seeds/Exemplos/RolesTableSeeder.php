<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //reset roles table 
        //DB::table("roles")->truncate();
        DB::table('roles')->delete();
        //create admin role
        $admin = new Role;
        $admin->name = "admin";
        $admin->display_name = "Admin";
        $admin->save();

         //create editor role
         $editor = new Role;
         $editor->name = "editor";
         $editor->display_name = "editor";
         $editor->save();

         //create author role
         $author = new Role;
         $author->name = "author";
         $author->display_name = "author";
         $author->save();


          //attach roles to users

          //first user as admin
         $user1 = User::find('1');   //get user where id is 1
         $user1->detachRole($admin); //detach role so that we wont get duplicate entry error if we run seeder again
         $user1->attachRole($admin); //attaching role here

         //second user as editor
         $user2 = User::find('2'); //get user where id is 2
         $user2->detachRole($editor); //detach role so that we wont get duplicate entry error if we run seeder again
         $user2->attachRole($editor);//attaching role here

         //third user as author
         $user3 = User::find('3'); //get user where id is 3
         $user3->detachRole($author); //detach role so that we wont get duplicate entry error if we run seeder again
         $user3->attachRole($author); //attaching role here 

    }
}
