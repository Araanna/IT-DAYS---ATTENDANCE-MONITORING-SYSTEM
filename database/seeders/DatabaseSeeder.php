<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       DB::table('year_levels')->insert([
        ['label' => '1st Year'],
        ['label' => '2nd Year'],
        ['label' => '3rd Year'],
        ['label' => '4th Year'],
    ]);
    }
}
