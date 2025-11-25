<?php

namespace App\Http\Controllers;

use App\Http\Requests\Panel\NotificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $notifications = Notification::all();

        return response()->json(['notifications' => $notifications], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request): JsonResponse
    {
        $request->validated();

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'appointment_id' => $request->appointment_id,
            'type' => $request->type,
            'message' => $request->message,
            'sent_at' => $request->sent_at,
            'is_new' => $request->is_new,
            'is_read' => $request->is_read,
        ]);

        return response()->json(['notification' => $notification], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $notification = Notification::findOrFail($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json(['notification' => $notification], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param NotificationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(NotificationRequest $request, int $id): JsonResponse
    {
        $request->validated();

        $notification = Notification::findOrFail($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->update([
            'user_id' => $request->user_id,
            'appointment_id' => $request->appointment_id,
            'type' => $request->type,
            'message' => $request->message,
            'sent_at' => $request->sent_at,
            'is_new' => $request->is_new,
            'is_read' => $request->is_read,
        ]);

        return response()->json(['notification' => $notification], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $notification = Notification::findOrFail($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully'], 200);
    }
}
