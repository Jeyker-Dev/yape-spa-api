<?php

namespace App\Http\Controllers;

use App\Http\Requests\Panel\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $services = Service::all();

        return response()->json(['services' => $services], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param ServiceRequest $request
     * @return JsonResponse
     */
    public function store(ServiceRequest $request): JsonResponse
    {
        $request->validated();

        $service = Service::create([
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'image' => $request->image,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        return response()->json(['message' => 'Service created successfully.', 'service' => $service], 201);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        return response()->json(['service' => $service], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param ServiceRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(ServiceRequest $request, string $id): JsonResponse
    {
        $request->validated();

        $service = Service::findOrFail($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->update([
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'image' => $request->image,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        return response()->json(['message' => 'Service updated successfully.', 'service' => $service], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully.'], 200);
    }
}
