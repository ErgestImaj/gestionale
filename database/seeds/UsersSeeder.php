<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'username'             => 'admin',
            'slug'                 =>'admin',
            'firstname'            =>'Presidente',
            'lastname'             =>'Gennaro',
            'email'                => 'admin@admin.com',
            'email_verified_at'    => now(),
            'password'             => bcrypt('secret'),
            'remember_token'       => Str::random(10),
            'activation'           =>now(),
            'created_by'           =>1,
            'state'           =>1,
        ]);
    }
}
