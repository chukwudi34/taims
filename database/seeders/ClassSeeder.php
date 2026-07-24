<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = array(
            ['id'=> 1, 'class_code' => "J1", "class_name" => "JSS1", 'created_at' => now()],
            ['id'=> 2, 'class_code' => "J2", "class_name" => "JSS2", 'created_at' => now()],
            ['id'=> 3, 'class_code' => "J3", "class_name" => "JSS3", 'created_at' => now()],
            ['id'=> 4, 'class_code' => "S1", "class_name" => "SS1", 'created_at' => now()],
            ['id'=> 5, 'class_code' => "S2", "class_name" => "SS2", 'created_at' => now()],
            ['id'=> 6, 'class_code' => "S3", "class_name" => "SS3", 'created_at' => now()],
        );

        DB::table('classes')->insert($classes);
    }
}
