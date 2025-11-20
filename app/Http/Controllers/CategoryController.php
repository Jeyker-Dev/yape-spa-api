<?php

namespace App\Http\Controllers;

use App\Http\Requests\Panel\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories for the authenticated user.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json(['categories' => $categories], 200);
    }

    /**
     * Display the specified category for the authenticated user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        return response()->json(['category' => $category], 200);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $request->validated();

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Category created successfully.', 'category' => $category], 201);
    }

    /**
     * Update the specified category in storage.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.']);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Category updated successfully.', 'category' => $category], 200);
    }

    /**
     * Remove the specified category from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }
}
