<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;

class GroupController extends Controller
{
    private $groups;

    public function __construct(Group $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->groups
            ->when(request()->filled('label'), function ($query) {
                $query->where('label', 'like', '%' . request()->query('label') . '%');
            })
            ->orderBy('label')
            ->paginate(request()->filled('size') ? request()->query('size') : 10);

        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        $group = new Group();
        $group->label = $request->label;
        $group->save();

        return response()->json($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupRequest  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->label = $request->label;
        $group->save();

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function count() {
        $result = $this->groups
            ->select('id')
            ->when(request()->filled('label'), function ($query) {
                $query->where('label', request()->query('label'));
            })
            ->get()
            ->pluck('id')
            ->toArray();

        return response()->json($result);
    }
}
