<?php

namespace App\Http\Controllers;

use App\Http\Requests\Panel\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paymentMethods = PaymentMethod::all();

        return response()->json(['payment_methods' => $paymentMethods], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param PaymentMethodRequest $request
     * @return JsonResponse
     */
    public function store(PaymentMethodRequest $request): JsonResponse
    {
        $request->validated();

        $paymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description,
        ]);

        return response()->json(['payment_method' => $paymentMethod], 201);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if (!$paymentMethod) {
            return response()->json(['message' => 'Payment method not found'], 404);
        }

        return response()->json(['payment_method' => $paymentMethod], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param PaymentMethodRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PaymentMethodRequest $request, int $id): JsonResponse
    {
        $request->validated();

        $paymentMethod = PaymentMethod::findOrFail($id);

        if (!$paymentMethod) {
            return response()->json(['message' => 'Payment method not found'], 404);
        }

        $paymentMethod->update([
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description,
        ]);

        return response()->json(['payment_method' => $paymentMethod], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if (!$paymentMethod) {
            return response()->json(['message' => 'Payment method not found'], 404);
        }

        $paymentMethod->delete();

        return response()->json(['message' => 'Payment method deleted successfully'], 200);
    }
}
