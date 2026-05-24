<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\Business;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = Business::all();

        if ($businesses->isEmpty()) {
            return;
        }

        foreach ($businesses as $business) {
            $business->seedDefaultTemplates();
        }
    }
}
