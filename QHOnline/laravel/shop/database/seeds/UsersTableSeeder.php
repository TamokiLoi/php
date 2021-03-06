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
            'name' => 'Tamoki',
            'email' => 'tamoki1110@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('T@moki110292'),
            'remember_token' => Str::random(10),
        ]);
        factory(User::class, 50)->create();
    }
}
