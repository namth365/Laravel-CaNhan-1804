<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     [
        //         'name' => 'ADMIN',
        //         'email' => 'admin@gmail.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$vct5ZNYH5WAlQlVwlMjYZurkSZY5SyhqiHVC5z4pkTDA6rylOqjBG', // password
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //     ]
        // ]);
        // User::factory(4)->create();

        $user = User::where('email','admin@gmail.com')->first();
        $user->password = Hash::make('123');
        $user->Save();

    }


}
