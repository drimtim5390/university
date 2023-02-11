<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    private $rooms;

    public function __construct(Room $rooms)
    {
        $this->rooms = $rooms;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = $this->rooms
            ->when(request()->filled('label'), function ($query) {
                $query->where('label', 'like', '%' . request()->query('label') . '%');
            })
            ->orderBy('label')
            ->paginate(request()->filled('size') ? request()->query('size') : 10);

        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        $room = new Room();
        $room->label = $request->label;
        $room->save();

        return response()->json($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->label = $request->label;
        $room->save();

        return response()->json($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function count() {
        $result = $this->rooms
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
