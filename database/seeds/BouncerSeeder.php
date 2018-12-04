<?php

use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'student',
            'title' => 'Student',
        ]);
        
        Bouncer::role()->firstOrCreate([
            'name' => 'personnel',
            'title' => 'Personnel',
        ]);
        
        Bouncer::allow('admin')
            ->to('ban-users');
        
        Bouncer::allow('admin')
            ->to('list-students');
        Bouncer::allow('admin')
            ->to('list-personnels');
            
        Bouncer::allow('admin')
            ->to('create-students');
        Bouncer::allow('admin')
            ->to('create-personnels');
        Bouncer::allow('admin')
            ->to('create-students');
        
        Bouncer::allow('student')
            ->to('queue');
    }
}
