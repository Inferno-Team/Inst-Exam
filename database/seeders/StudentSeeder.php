<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentStatus;
use App\Models\StudentYear;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->count(10)->create()
            ->each(function (User $user) {
                info("user : $user->id");
                Student::factory()->count(1)->create(['user_id' => $user->id])
                    ->each(function (Student $student) {
                        info("student : $student->id");
                        $studentYear = StudentYear::factory()->count(1)->create([
                            "student_id" => $student->id,
                            "section_year_id" => rand(1, 2)
                        ])->first();
                        if ($studentYear->section_year_id == 2) {
                            StudentStatus::factory()->count(1)->create([
                                'student_id' => $student->id,
                                'status' => 'منقول',
                                'section_year_id' => 1,
                                'last_status' => false,
                                'year_date' => '2021-2022'
                            ]);
                        }
                    });
            });
    }
}
