<?php

use Illuminate\Database\Seeder;
use App\Enums\RoleType;
use App\Enums\UserStatus;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->create([
            'email' => 'dansharisan@gmail.com',
            'password' => '$2y$10$kONctkXHfXNakypS40w6S.k/WIitrpFDng3ObG8O9fmiH8yEC1uWu',
            'status' => UserStatus::Activated
        ])->each(function ($user) {
            $user->assignRole(RoleType::Administrator);
        });
    }
}
