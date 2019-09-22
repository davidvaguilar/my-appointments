<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create([
        'name' => 'David Villegas',
        'email' => 'david.villegas.aguilar@gmail.com',
        'password' => bcrypt('123123'),
        'role'=> 'admin'
      ]);
      User::create([
        'name' => 'Paciente Test',
        'email' => 'paciente@correo.com',
        'password' => bcrypt('123123'),
        'role'=> 'patient'
      ]);
      User::create([
        'name' => 'Medico Test',
        'email' => 'doctor@correo.com',
        'password' => bcrypt('123123'),
        'role'=> 'doctor'
      ]);

      //factory(User::class, 50)->create();
      factory(User::class, 50)->states('patient')->create();
    }
}
