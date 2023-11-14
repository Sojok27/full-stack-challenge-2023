<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();
        
        // Supervisor
        $role = new Role();
        $role->name = 'supervisor';
        $role->description = 'System Supervisor';
        $role->save();
        
        // Executive
        $role = new Role();
        $role->name = 'executive';
        $role->description = 'System Executive';
        $role->save();
    }
}
