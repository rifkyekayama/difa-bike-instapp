<?php

use Illuminate\Database\Seeder;

use App\Models\UserControl\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	$admin = new User;
    	$admin->name = "Super Admin";
    	$admin->email = "super@admin.com";
    	$admin->password = bcrypt('admin');
    	$admin->save();
    }
}
