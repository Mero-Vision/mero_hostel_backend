<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest\CreateRoomRequest;
use App\Http\Requests\RoomRequest\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->get();
        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoomRequest $request)
    {
        try {
            $room = DB::transaction(function () use ($request) {
                $room = Room::create([
                    'room_number' => $request->room_number,
                    'room_type' => $request->room_type,
                    'capacity' => $request->capacity,
                    'availability' => $request->availability,
                    'price' => $request->price,
                    'features' => $request->features,
                    'hostel_id' => $request->hostel_id,
                ]);
                if ($request->room_image) {
                    $room->addMedia($request->room_image)->toMediaCollection('room_image');
                }
                return $room;
            });

            if ($room) {
                return responseSuccess(new RoomResource($room), 200, 'Hostel Room has been created successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::where('room_number', $id)->first();
        if (is_null($room)) {
            return responseError('Room not found!', 404);
        }
        return responseSuccess(new RoomResource($room));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, string $id)
    {
        $room = Room::where('room_number', $id)->first();
        if (is_null($room)) {
            return responseError('Room not found!', 404);
        }
        try {
            $room = DB::transaction(function () use ($room, $request) {
                $room->update([
                    'room_number' => $request->room_number,
                    'room_type' => $request->room_type,
                    'capacity' => $request->capacity,
                    'availability' => $request->availability,
                    'price' => $request->price,
                    'features' => $request->features,
                ]);
                return $room;
            });

            if ($room) {
                return responseSuccess(new RoomResource($room), 200, 'Hostel Room has been updated successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::where('room_number', $id)->first();
        if (is_null($room)) {
            return responseError('Room not found!', 404);
        }
        try {
            $room = DB::transaction(function () use ($room) {
                $room->delete();
                return $room;
            });
            if ($room) {
                return responseSuccess(null, 204);
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }
}
