<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class RandomUsersSeeder extends Seeder
{
    /**
     * Create 5 users with random roles: “Librarian” or “Customer”.
     */
    public function run(): void
    {
        // make sure the roles exist on the enum / database column
        $roles = ['Librarian', 'Customer'];

        User::factory()->count(5)->create()->each(function (User $user) use ($roles) {
            $user->update([
                'role'     => collect($roles)->random(),
                'password' => Hash::make('password'),       
                'email'    => Str::replace('@example.net', '@demo.test', $user->email),
            ]);
        });

        $this->command->info('5 random users created (password = "password").');
    }
}
