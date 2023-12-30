<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostelBooking\CreateHostelBookingRequest;
use App\Http\Resources\HostelBookingPendingResource;
use App\Models\HostelBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userID=request()->query('user_id');
        
        $hostelBooking=HostelBooking::join('users','users.id','=', 'hostel_bookings.user_id')
        ->join('hostels','hostels.id','=', 'hostel_bookings.hostel_id')
        ->select('hostel_bookings.id','users.name','users.email','hostel_bookings.created_at')
        ->where('hostels.user_id',$userID)->where('hostel_bookings.status','pending')->latest('hostel_bookings.created_at','desc')->get();

        
        return HostelBookingPendingResource::collection($hostelBooking);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateHostelBookingRequest $request)
    {
        $hostel=HostelBooking::where('hostel_id',$request->hostel_id)->where('user_id',auth()->user()->id)->first();
        if($hostel){
            return responseError('You have already requested this hostel',500);
        }
        try {
            $booking = DB::transaction(function () use ($request) {
                $booking = HostelBooking::create([
                    'user_id' => auth()->user()->id,
                    'hostel_id' => $request->hostel_id

                ]);
                return $booking;
            });
            if ($booking) {
                return responseSuccess($booking, 200, "You have requested the hostel successfully!");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking=HostelBooking::find($id);
        if(!$booking){
            return responseError('Booking ID Not Found!',404);
        }
        $user=User::where('id',$booking->user_id)->first();
        if(!$user){
            return responseError('User Not Found!',404);
        }
        try{
            DB::transaction(function()use($booking,$user){
                $booking->update([
                    'status'=>'approved'
                    
                ]);

                HostelBooking::where('user_id', $user->id)
                ->where('status', 'pending')
                ->update(['status' => '']);
                $user=$user->update([
                    'hostel_id'=>$booking->hostel_id,
                    'status'=>'Hostel_User'
                ]);
                return $booking;
                
            });
        
            if($booking){
                return responseSuccess($booking,200,'Booking approved successfully!');
            }
            
        }
        catch(\Exception $e){
            return responseError($e->getMessage(),500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}