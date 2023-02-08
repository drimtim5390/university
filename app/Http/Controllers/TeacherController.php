<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    private $teachers;

    public function __construct(Teacher $teachers) {
        $this->teachers = $teachers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = $this->teachers
            ->when(request()->filled('full_name'), function ($query) {
                $query->where(
                    DB::raw('concat(first_name, \' \', last_name)'),
                    'like',
                    $this->getFullNamePattern(request()->query('full_name'))
                );
            })
            ->orderBy(DB::raw('concat(first_name, \' \', last_name)'))
            ->paginate(request()->filled('size') ? request()->query('size') : 10);

        return response()->json($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        $teacher = new Teacher();
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->save();

        return response()->json($teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return response()->json($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeacherRequest  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->save();

        return response()->json($teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    private function getFullNamePattern(string $full_name)
    {
        $trimmed_full_name = trim(preg_replace('/[\t\n\r\s]+/', ' ', $full_name));
        $tokens = explode(' ', $trimmed_full_name);
        return '%' . implode('%', $tokens) . '%';
    }
}
