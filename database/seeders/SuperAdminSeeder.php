<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Try to find the user by their email, replace with the user's actual registered email used in testing.
        $user = User::first(); // Grant the first user super admin access for easy testing.

        if ($user) {
            $user->is_super_admin = true;
            $user->save();
        }
    }
}
