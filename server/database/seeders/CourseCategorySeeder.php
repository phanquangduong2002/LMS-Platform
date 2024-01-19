<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_categories')->insert([
            [
                'title' => 'English',
                'slug' => 'english'
            ],
            [
                'title' => 'Tiếng Việt',
                'slug' => 'tieng-viet'
            ]
        ]);
    }
}
