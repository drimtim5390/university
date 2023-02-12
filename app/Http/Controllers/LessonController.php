<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use App\Support\TimetableFacade;
use Illuminate\Support\Carbon;

class LessonController extends Controller
{
    private $lessons;
    public function __construct(Lesson $lessons)
    {
        $this->lessons = $lessons;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $star_date = request()->filled('start_date') ? Carbon::parse(request()->query('start_date')) : Carbon::now()->startOfWeek();
        $end_date = request()->filled('end_date') ? Carbon::parse(request()->query('end_date')) : Carbon::now()->endOfWeek();

        $lessons = $this->lessons
            ->whereBetween('date', [$star_date->toDateString(), $end_date->toDateString()])
            ->whereHas('group', function ($query) {
                $query->orderBy('label');
            })
            ->orderBy('date', 'asc')
            ->orderBy('position', 'asc')
            ->get();

        return response()->json($lessons);
    }
    public function timetable()
    {
        $star_date = request()->filled('start_date') ? Carbon::parse(request()->query('start_date')) : Carbon::now()->startOfWeek();
        $end_date = request()->filled('end_date') ? Carbon::parse(request()->query('end_date')) : Carbon::now()->endOfWeek();

        $lessons = $this->lessons
            ->whereBetween('date', [$star_date->toDateString(), $end_date->toDateString()])
            ->whereHas('group', function ($query) {
                $query->orderBy('label');
            })
            ->orderBy('date', 'asc')
            ->orderBy('position', 'asc')
            ->with(['group', 'room', 'subject', 'teacher'])
            ->get();

        $timetable = TimetableFacade::build($lessons);

        return response()->json($timetable);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = new Lesson();
        $lesson->fill($request->all());
        $lesson->save();

        return response()->json($lesson);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        return response()->json($lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLessonRequest  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->fill($request->all());
        $lesson->save();

        return response()->json($lesson);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
    }

    public function count() {
        $result = $this->lessons
            ->select('id')
            ->when(request()->filled('date'), function ($query) {
                $query->where('date', request()->query('date'));
            })
            ->when(request()->filled('position'), function ($query) {
                $query->where('position', request()->query('position'));
            })
            ->when(request()->filled('group_id'), function ($query) {
                $query->where('group_id', request()->query('group_id'));
            })
            ->when(request()->filled('room_id'), function ($query) {
                $query->where('room_id', request()->query('room_id'));
            })
            ->when(request()->filled('teacher_id'), function ($query) {
                $query->where('teacher_id', request()->query('teacher_id'));
            })
            ->get()
            ->pluck('id')
            ->toArray();

        return response()->json($result);
    }}
