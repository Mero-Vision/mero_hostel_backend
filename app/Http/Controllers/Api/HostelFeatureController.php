<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostelFeaturesRequest;
use App\Http\Resources\HostelFeatureResource;
use App\Models\HostelFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = HostelFeature::all();
        return HostelFeatureResource::collection($features);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HostelFeaturesRequest $request)
    {
        $feature = HostelFeature::where('hostel_id', $request->hostel_id)->first();
        if ($feature) {
            return responseError('You have already created the features!', 500);
        }
        try {
            $feature = DB::transaction(function () use ($request) {
                $feature = HostelFeature::create([
                    'hostel_id' => $request->hostel_id,
                    'hostel_feature' => $request->hostel_feature,
                ]);
                return $feature;
            });
            if ($feature) {
                return responseSuccess(new HostelFeatureResource($feature), 200, 'Hostel Features has been created Successfully');
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
        $feature = HostelFeature::where('id', $id)->first();
        if (is_null($feature)) {
            return responseError('Hostel not found', 404);
        } else {
            return responseSuccess(new HostelFeatureResource($feature), 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $feature = HostelFeature::where('id', $id)->first();
        if (is_null($feature)) {
            return response('id not found!', 404);
        }
        try {
            $feature = DB::transaction(function () use ($request, $feature) {
                $feature->update([
                    'hostel_id' => $request->hostel_id,
                    'hostel_feature' => $request->hostel_feature,
                ]);
                return $feature;
            });
            if ($feature) {
                return responseSuccess(new HostelFeatureResource($feature), 200, 'Hostel Features has been created Successfully');
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
        $feature = HostelFeature::where('id', $id)->first();
        if (is_null($feature)) {
            return response('id not found', 404);
        }
        try {
            $feature = DB::transaction(function () use ($feature) {
                $feature->update();
                return $feature;
            });
            if ($feature) {
                return responseSuccess(new HostelFeatureResource($feature), 200, 'Hostel Feature Deleated Successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(),500);
        }
    }
}
