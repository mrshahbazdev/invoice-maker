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
        // Target the specific user email requested
        $user = User::where('email', 'mrshahbaznns@gmail.com')->first();

        if ($user) {
            $user->is_super_admin = true;
            $user->password = bcrypt('11223344');
            $user->save();
        }
    }
}
