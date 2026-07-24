<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user_type_names = array(
        //     ['id'=> 1, 'user_type_name' => "Staff", 'created_at' => now()],
        //     ['id'=> 2, 'user_type_name' => "Learner", 'created_at' => now()],
        //     ['id'=> 3, 'user_type_name' => "Parent", 'created_at' => now()],
        //     ['id'=> 4, 'user_type_name' => "Tutor", 'created_at' => now()],
        //     ['id'=> 5, 'user_type_name' => "Admin", 'created_at' => now()],
        // );


        $user_type_names = array(
            ['id' => 1, 'user_type_name' => "instructor", 'created_at' => now()],
            ['id' => 2, 'user_type_name' => "learner", 'created_at' => now()],
            ['id' => 3, 'user_type_name' => "admin", 'created_at' => now()],
        );

        DB::table('user_types')->insert($user_type_names);
    }
}
