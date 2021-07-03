<?php
use Illuminate\Database\Seeder;
use App\Role;       //added role model 
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin role
        $admin = new Role;             //creating role using role model
        $admin->name = "admin";
        $admin->display_name = "Admin";
        $admin->save();

         //create editor role
         $editor = new Role;            //creating role using role model
         $editor->name = "editor";
         $editor->display_name = "editor";
         $editor->save();

         //create author role
         $author = new Role;            //creating role using role model
         $author->name = "author";
         $author->display_name = "author";
         $author->save();
    }
}
