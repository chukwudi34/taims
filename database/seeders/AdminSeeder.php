<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = array(
            array(
                'email' => "admin@gmail.com",
                'phone' => "08156722834",
                'user_type_id' => 3,
                'lname' => 'Admin',
                'fname' => 'Admin',
                'email_verified_at' => Now(),
                'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyudBxqf1sdD2e3L4nI3nqsMt1_tceOyuZ7A&usqp=CAU",
                'password' => bcrypt('12345678'),
                'region' => 'Africa/Lagos'

            )
        );

        foreach ($admin as $value) {
            $user = User::Create($value);
        }
    }
}
