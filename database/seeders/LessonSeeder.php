<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lesson;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Teacher;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {
            try {
                Lesson::factory()
                    ->afterMaking(function ($lesson) {
                        $lesson->group_id = Group::inRandomOrder()->first()->id;
                        $lesson->room_id = Room::inRandomOrder()->first()->id;
                        $lesson->teacher_id = Teacher::inRandomOrder()->first()->id;
                        $lesson->subject_id = Subject::inRandomOrder()->first()->id;
                        return $lesson;
                    })
                    ->create();
            } catch (QueryException $e) {
            }
        }
    }
}
