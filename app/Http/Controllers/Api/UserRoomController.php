<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoom\UserRoomCreateRequest;
use App\Http\Resources\RoomResource;
use App\Http\Resources\UserRoomResource;
use App\Models\Room;
use App\Models\UserRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hostel_id=request()->query('hostel_id');
        $userRooms = Room::with('userRooms.users')->when($hostel_id,function($query)use($hostel_id){
            $query->where('hostel_id',$hostel_id);
            
        })->latest()->get();

        $formattedResponse = [
            'data' => $userRooms->map(function ($room) {
                return [
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'room_type' => $room->room_type,
                    'room_capacity'=>$room->capacity,

                    'user_rooms' => $room->userRooms->map(function ($userRoom) {
                        return [
                            'id' => $userRoom->id,
                            'user_id' => $userRoom->user_id,
                            'room_id' => $userRoom->room_id,
                            'check_in_date' => $userRoom->check_in_date,
                            'check_out_date' => $userRoom->check_out_date,
                            'status' => $userRoom->status,
                            'created_at' => $userRoom->created_at,
                            'updated_at' => $userRoom->updated_at,
                            'user_name' => $userRoom->users->name??null, 
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($formattedResponse);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRoomCreateRequest $request)
    {
        try{
            $userRoom=DB::transaction(function()use($request){
                $userRoom=UserRoom::create([
                    'room_id'=>$request->room_id,
                    'user_id'=>$request->user_id,
                    'check_in_date'=>Carbon::now(),
                    'status'=>'active'
                    
                ]);
                return $userRoom;
                
            });
            if($userRoom){
                return responseSuccess($userRoom,200,'User assigned to room successfully!');
            }
            
        }
        catch(\Exception $e){
            return responseError($e->getMessage(),500);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}