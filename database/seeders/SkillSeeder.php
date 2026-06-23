<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'Flutter', 'slug' => 'flutter'],
            ['name' => 'Dart', 'slug' => 'dart'],
            ['name' => 'Python', 'slug' => 'python'],
            ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
            ['name' => 'React', 'slug' => 'react'],
        ];

        Skill::insert($skills);
    }
}