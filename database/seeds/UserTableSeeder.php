<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Model;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::Where('name', 'admin')->first();
        $supervisor = Role::Where('name', 'supervisor')->first();
        $executive = Role::Where('name', 'executive')->first();

        // Admin
        $user =  new User();
        $user->name = "Admin";
        $user->email = "a@d.min";
        $user->password = bcrypt("a@d.min");
        $user->save();
        $user->roles()->attach($admin);

        // Supervisor
        $user =  new User();
        $user->name = "Supervisor";
        $user->email = "s@u.per";
        $user->password = bcrypt("s@u.per");
        $user->save();
        $user->roles()->attach($supervisor);

        // Executive
        $user =  new User();
        $user->name = "Executive";
        $user->email = "e@x.e";
        $user->password = bcrypt("e@x.e");
        $user->save();
        $user->roles()->attach($executive);
    }
}
