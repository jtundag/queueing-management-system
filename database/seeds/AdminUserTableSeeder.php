<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::where('uuid', 'admin')->first()->delete();
        
        $admin = \App\User::create([
            'uuid' => 'admin',
            'username' => 'admin',
            'first_name' => 'admin', 
            'middle_name' => 'admin', 
            'last_name' => 'admin', 
            'email' => 'admin@qms.com', 
            'password' => \Hash::make('admin'),
            'gender' => 'male',
            'mobile_no' => '123',
            'phone_no' => '123',
        ]);

        \Bouncer::assign('admin')->to($admin);
    }
}
