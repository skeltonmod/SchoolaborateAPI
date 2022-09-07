<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use App\Models\Student;
use Deyji\Manage\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SchoolLevel::create([
            'name' => 'Grade 1',
            'description' => 'Grade 1',
        ]);

        $admin_user = Users::create([
            "email" => "admin@admin.com",
            "name" => "Admin",
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            "password" => Hash::make("123456"),
        ]);

        $admin_user->assignRole('Admin');

        $students_list = ['Elijah', 'Michael John', 'Paulino'];

        foreach($students_list as $student){
            $student_user = Users::create([
                "email" => $student."@student.com",
                'first_name' => $student,
                'last_name' => 'Student',
                "name" => $student,
                "password" => Hash::make("123456"),
            ]);

            $student_user->assignRole('Student');
            Student::create([
                "user_id" => $student_user->id,
                "contactNumber" => rand(10000000000, 99999999999),
                "guardianNumber" => rand(10000000000, 99999999999),
                "school_level_id" => 1,
            ]);
        }
    }
}
