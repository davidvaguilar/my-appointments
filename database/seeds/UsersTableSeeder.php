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
        'dni' => 12354879,
        'address' => '',
        'phone' => '',
        'role'=> 'admin'
      ]);
      factory(User::class, 50)->create();
    }
}
