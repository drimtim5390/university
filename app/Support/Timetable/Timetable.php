<?php

namespace App\Support\Timetable;

use Illuminate\Support\Carbon;

class Timetable
{
    private $dates = [];

    private $groups = [];

    private $data = [];

    public function build($lessons, $star_date = null, $end_date = null) {
        $this->setDates($lessons, $star_date, $end_date);
        $this->setGroups($lessons);

        foreach ($this->groups as $group) {
            foreach (range(1, 6) as $i) {
                $row = [];
                $row['group'] = $group;
                $row['position'] = $i;
                foreach ($this->dates as $date) {
                    $row[$date] = $lessons->firstWhere(function ($a) use ($date, $group, $i) {
                        return $a->date === $date && $a->group_id === $group->id && $a->position === $i;
                    });
                }
                $this->data[] = $row;
            }
        }

        return [
            'data' => $this->data,
            'dates' => $this->dates
        ];
    }

    private function setDates($lessons, $start_date, $end_date)
    {
        $this->dates = [];
        if ($start_date === null && $end_date === null) {
            $this->dates = array_unique($lessons->pluck('date')->toArray());
        } else {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->startOfDay();
            while ($start_date->isBefore($end_date) || $start_date->isSameDay($end_date)) {
                $this->dates[] = $start_date->toDateString();
                $start_date->addDay();
            }
        }
    }

    private function setGroups($lessons)
    {
        $this->groups = $lessons->pluck('group')->unique()->sort(function ($a, $b) {
            return $a->label > $b->label;
        });
    }
}
