<?php

namespace App\Http\Controllers;

use App\Http\Requests\Panel\AvailabilityRequest;
use App\Models\Availability;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the availabilities.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $availabilities = Availability::all();

        return response()->json(['availabilities' => $availabilities], 200);
    }

    /**
     * Display the specified availability.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $availability = Availability::find($id);

        if (!$availability) {
            return response()->json(['message' => 'Availability not found.'], 404);
        }

        return response()->json(['availability' => $availability], 200);
    }

    /**
     * Store a newly created availability in storage.
     *
     * @param AvailabilityRequest $request
     * @return JsonResponse
     */
    public function store(AvailabilityRequest $request): JsonResponse
    {
        $request->validated();

        $availability = Availability::create([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_working' => $request->is_working,
        ]);

        return response()->json(['message' => 'Availability created successfully.', 'availability' => $availability], 201);
    }

    /**
     * Update the specified availability in storage.
     *
     * @param AvailabilityRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AvailabilityRequest $request, int $id): JsonResponse
    {
        $availability = Availability::findOrFail($id);

        if (!$availability) {
            return response()->json(['message' => 'Availability not found.'], 404);
        }

        $request->validated();

        $availability->update([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_working' => $request->is_working,
        ]);

        return response()->json(['message' => 'Availability updated successfully.', 'availability' => $availability], 200);
    }

    /**
     * Remove the specified availability from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $availability = Availability::findOrFail($id);

        if (!$availability) {
            return response()->json(['message' => 'Availability not found.'], 404);
        }

        $availability->delete();

        return response()->json(['message' => 'Availability deleted successfully.'], 200);
    }
}
