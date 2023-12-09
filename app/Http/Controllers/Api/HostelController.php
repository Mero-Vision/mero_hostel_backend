<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHostelRequest;
use App\Http\Requests\UpdateHostelRequest;
use App\Http\Resources\HostelResource;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $hostel = Hostel::latest()->get();
        return HostelResource::collection($hostel);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateHostelRequest $request)
    {
        try {

            $hostel = DB::transaction(function () use ($request) {
                $hostel = Hostel::create([
                    'hostel_name' => $request->hostel_name,
                    'hostel_type'=>$request->hostel_type,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'website' => $request->website,
                    'user_id' => auth()->user()->id,

                ]);
                if ($request->hostel_image) {

                    $hostel->addMedia($request->hostel_image)->toMediaCollection('hostel_image');
                }
                return $hostel;
            });
            if ($hostel) {
                return responseSuccess(new HostelResource($hostel), 200, 'Hostel has been created successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $hostel = Hostel::where('slug', $slug)->first();
        if (is_null($hostel)) {
            return responseError('Slug not found!', 404);
        } else {
            return responseSuccess(new HostelResource($hostel));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHostelRequest $request, $slug)
    {
        $hostel = Hostel::where('slug', $slug)->first();
        if (is_null($hostel)) {
            return responseError('Slug not found!', 404);
        }

        try {
            $hostel = DB::transaction(function () use ($hostel, $request) {
                $hostel->update([
                    'hostel_name' => $request->hostel_name,
                    'hostel_type'=>$request->hostel_type,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'website' => $request->website,
                ]);
                return $hostel;
            });
            if ($hostel) {
                return responseSuccess(new HostelResource($hostel), 200, 'Hostels Data has been updated successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        try {
            $hostel = Hostel::where('slug', $slug)->first();
            if (is_null($hostel)) {
                return responseError('Slug not found!', 404);
            }
            $hostel = DB::transaction(function () use ($hostel) {
                $hostel->delete();
                return $hostel;
            });
            if ($hostel) {
                return responseSuccess(null, 204);
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }
}
