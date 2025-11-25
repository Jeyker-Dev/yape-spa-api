<?php

namespace App\Http\Controllers;

use App\Http\Requests\Panel\AppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $appointments = Appointment::all();

        return response()->json(['appointments' => $appointments], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param AppointmentRequest $request
     * @return JsonResponse
     */
    public function store(AppointmentRequest $request): JsonResponse
    {
        $request->validated();

        $appointment = Appointment::create([
            'user_id' => $request->user_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return response()->json(['appointment' => $appointment], 201);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        return response()->json(['appointment' => $appointment], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param AppointmentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AppointmentRequest $request, int $id): JsonResponse
    {
        $request->validated();

        $appointment = Appointment::findOrFail($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->update([
            'user_id' => $request->user_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return response()->json(['appointment' => $appointment], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully'], 200);
    }
}
