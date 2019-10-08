<?php

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	$roles = Roles::create([
            'id'=> 1,
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);
    
        $roles = Roles::create([
    	    'id'=> 2,
            'name' => 'member',
            'display_name' => 'Regular User',
        ]);
    }
}