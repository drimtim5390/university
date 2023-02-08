<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{
    private $subjects;

    public function __construct(Subject $subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->subjects
            ->when(request()->filled('name'), function ($query) {
                $query->where('name', 'like', '%' . request()->query('name') . '%');
            })
            ->orderBy('name')
            ->paginate(request()->filled('size') ? request()->query('size') : 10);

        return response()->json($subjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->save();

        return response()->json($subject);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubjectRequest  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->name = $request->name;
        $subject->save();

        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function count() {
        $result = $this->subjects
            ->select('id')
            ->when(request()->filled('name'), function ($query) {
                $query->where('name', request()->query('name'));
            })
            ->get();

        return response()->json($result);
    }
}
