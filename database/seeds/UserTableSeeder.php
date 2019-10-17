<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id'=> 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => 1
        ]);
        $user = User::create([
	       'id'=> 2,
            'name' => 'Demo',
            'email' => 'demo@demo.com',
            'password' => bcrypt('demo'),
            'role_id' => 2	
        ]);
    }
}
